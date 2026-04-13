<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Exception;

class StudentImportService
{
    private $successCount = 0;
    private $failureCount = 0;
    private $errors = [];
    private $duplicates = [];

    /**
     * Import students from CSV file
     */
    public function import($filePath)
    {
        try {
            $this->successCount = 0;
            $this->failureCount = 0;
            $this->errors = [];
            $this->duplicates = [];

            $file = fopen($filePath, 'r');
            // Remove BOM if present
            $bom = fread($file, 3);
            if ($bom !== "\xEF\xBB\xBF") {
                rewind($file);
            }

            $rowNumber = 0;
            $headers = null;

            while (($row = fgetcsv($file, 0, ',')) !== false) {
                $rowNumber++;

                // Skip empty rows
                if (empty(array_filter($row))) {
                    continue;
                }

                // Parse header row
                if ($rowNumber === 1) {
                    $headers = $this->parseHeaders($row);
                    continue;
                }

                $this->processRow($row, $headers, $rowNumber);
            }

            fclose($file);

            // Log summary
            Log::info('Student import completed', [
                'success' => $this->successCount,
                'failure' => $this->failureCount,
                'duplicates' => count($this->duplicates),
            ]);

            return $this->getResult();
        } catch (Exception $e) {
            Log::error('Student import failed', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * Parse CSV headers
     */
    private function parseHeaders($headerRow)
    {
        $headers = [];
        foreach ($headerRow as $index => $header) {
            $header = trim(strtolower($header));
            $headers[$header] = $index;
        }
        return $headers;
    }

    /**
     * Process individual CSV row
     */
    private function processRow($row, $headers, $rowNumber)
    {
        try {
            // Extract data from row
            $data = $this->extractRowData($row, $headers);

            // Validate required fields
            $validation = $this->validateRowData($data);
            if (!$validation['valid']) {
                $this->failureCount++;
                $this->errors[] = [
                    'row' => $rowNumber,
                    'error' => $validation['message'],
                    'data' => $data,
                ];
                return;
            }

            // Check for duplicates
            if ($this->isDuplicate($data)) {
                $this->failureCount++;
                $this->duplicates[] = [
                    'row' => $rowNumber,
                    'student_code' => $data['student_code'] ?? null,
                    'email' => $data['email'] ?? null,
                ];
                return;
            }

            // Create user
            $this->createStudent($data);
            $this->successCount++;
        } catch (Exception $e) {
            $this->failureCount++;
            $this->errors[] = [
                'row' => $rowNumber,
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * Extract data from CSV row based on headers
     */
    private function extractRowData($row, $headers)
    {
        $data = [];

        $fieldMapping = [
            'student_code' => 'mã sinh viên',
            'email' => 'email',
            'first_name' => 'tên',
            'last_name' => 'họ',
            'phone' => 'số điện thoại',
            'faculty_id' => 'mã khoa',
            'class_id' => 'mã lớp',
            'group_id' => 'mã nhóm',
            'birthdate' => 'ngày sinh',
            'degree_type' => 'loại bằng',
        ];

        foreach ($fieldMapping as $field => $headerName) {
            if (isset($headers[$headerName])) {
                $value = trim($row[$headers[$headerName]] ?? '');
                $data[$field] = $value ?: null;
            }
        }

        return $data;
    }

    /**
     * Validate row data
     */
    private function validateRowData($data)
    {
        $required = ['student_code', 'email', 'first_name', 'last_name'];

        // Field name translations
        $fieldNames = [
            'student_code' => 'Mã sinh viên',
            'email' => 'Email',
            'first_name' => 'Tên',
            'last_name' => 'Họ',
            'phone' => 'Số điện thoại',
            'faculty_id' => 'Mã khoa',
            'class_id' => 'Mã lớp',
            'group_id' => 'Mã nhóm',
        ];

        foreach ($required as $field) {
            if (empty($data[$field])) {
                $fieldDisplay = $fieldNames[$field] ?? $field;
                return [
                    'valid' => false,
                    'message' => "Trường '{$fieldDisplay}' không được để trống",
                ];
            }
        }

        // Validate email format
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            return [
                'valid' => false,
                'message' => "Email '{$data['email']}' không hợp lệ",
            ];
        }

        // Validate phone if provided
        if (!empty($data['phone']) && !preg_match('/^[0-9]{10,11}$/', $data['phone'])) {
            return [
                'valid' => false,
                'message' => "Số điện thoại '{$data['phone']}' không hợp lệ (phải có 10-11 chữ số)",
            ];
        }

        // Validate faculty_id if provided
        if (!empty($data['faculty_id'])) {
            $facultyExists = \App\Models\Faculty::where('id', $data['faculty_id'])->exists();
            if (!$facultyExists) {
                return [
                    'valid' => false,
                    'message' => "Mã khoa '{$data['faculty_id']}' không tồn tại trong hệ thống",
                ];
            }
        }

        // Validate class_id if provided
        if (!empty($data['class_id'])) {
            $classExists = \App\Models\SchoolClass::where('id', $data['class_id'])->exists();
            if (!$classExists) {
                return [
                    'valid' => false,
                    'message' => "Mã lớp '{$data['class_id']}' không tồn tại trong hệ thống",
                ];
            }
        }

        // Validate group_id if provided
        if (!empty($data['group_id'])) {
            $groupExists = \App\Models\UserGroup::where('id', $data['group_id'])->exists();
            if (!$groupExists) {
                return [
                    'valid' => false,
                    'message' => "Mã nhóm '{$data['group_id']}' không tồn tại trong hệ thống",
                ];
            }
        }

        return ['valid' => true];
    }

    /**
     * Check if student already exists
     */
    private function isDuplicate($data)
    {
        $exists = User::where('email', $data['email'])
            ->orWhere('student_code', $data['student_code'])
            ->first();

        return $exists !== null;
    }

    /**
     * Create student record
     */
    private function createStudent($data)
    {
        $data['password'] = Hash::make($data['student_code']);
        $data['role'] = 0; // Student role
        $data['status'] = 'active'; // Active by default (use string for status column)

        // Handle optional fields
        if (empty($data['group_id'])) unset($data['group_id']);
        if (empty($data['faculty_id'])) unset($data['faculty_id']);
        if (empty($data['class_id'])) unset($data['class_id']);
        if (empty($data['birthdate'])) unset($data['birthdate']);
        if (empty($data['degree_type'])) unset($data['degree_type']);
        if (empty($data['phone'])) unset($data['phone']);

        User::create($data);
    }

    /**
     * Get import result summary
     */
    public function getResult()
    {
        return [
            'success' => $this->successCount,
            'failure' => $this->failureCount,
            'errors' => $this->errors,
            'duplicates' => $this->duplicates,
            'total_processed' => $this->successCount + $this->failureCount + count($this->duplicates),
        ];
    }

    /**
     * Generate CSV template
     */
    public static function generateCsvTemplate()
    {
        $headers = [
            'Mã sinh viên',
            'Email',
            'Tên',
            'Họ',
            'Số điện thoại',
            'Mã khoa',
            'Mã lớp',
            'Mã nhóm',
            'Ngày sinh (Y-m-d)',
            'Loại bằng',
        ];

        $content = implode(',', $headers) . "\n";

        // Add example row
        $example = [
            'SV001',
            'student1@example.com',
            'Minh',
            'Nguyễn',
            '0912345678',
            '1',
            '1',
            '1',
            '2000-01-15',
            'Đại học',
        ];

        $content .= implode(',', $example) . "\n";

        return $content;
    }
}
