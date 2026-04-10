<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Imports\StudentsImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;

class DebugImport extends Command
{
    protected $signature = 'app:debug-import';
    protected $description = 'Debug import students from CSV';

    public function handle()
    {
        $filePath = storage_path('app/test_import.csv');
        
        if (!file_exists($filePath)) {
            $this->error("File not found at: " . $filePath);
            return;
        }

        $fullPath = $filePath;
        $this->info("Checking CSV content...");
        
        // 1. In ra mảng dữ liệu để kiểm tra Header
        $data = Excel::toArray(new StudentsImport, $fullPath);
        $this->table(['Headers found in CSV'], [array_keys($data[0][0])]);
        $this->info("Data preview:");
        print_r($data[0]);

        // 2. Chạy thử Import
        $this->info("\nStarting Import Test...");
        $import = new StudentsImport;
        
        try {
            $import->import($fullPath);
            
            if ($import->failures()->isNotEmpty()) {
                $this->error("Validation Errors:");
                foreach ($import->failures() as $failure) {
                    $this->warn("Row " . $failure->row() . " [" . implode(', ', $failure->errors()) . "]: " . json_encode($failure->values()));
                }
            } else {
                $this->info("No validation errors found.");
            }
            
            $this->info("Import process finished. Check logs for missing ID errors.");
            
        } catch (\Throwable $e) {
            $this->error("System Error: " . $e->getMessage());
        }
    }
}
