# CSV Import Feature - Student Management System

## Overview
The CSV import feature allows administrators to bulk import student records from CSV/TXT files, significantly reducing manual data entry time.

## Features

### 1. Import Button
- Located in the Student List header (`admin.students.index`)
- Opens a modal dialog for file upload
- Link: "Import CSV" button

### 2. CSV Template Download
- Route: `admin.students.template`
- Provides a template CSV file with correct column structure
- Example data included for reference

### 3. CSV Format Requirements

#### Column Headers (Case-insensitive):
| Field | Required | Format | Example |
|-------|----------|--------|---------|
| Mã sinh viên | Yes | Text | SV001 |
| Email | Yes | Valid Email | student@domain.com |
| Tên | Yes | Text | Minh |
| Họ | Yes | Text | Nguyễn |
| Số điện thoại | No | 10-11 digits | 0912345678 |
| Mã khoa | No | Numeric ID | 1 |
| Mã lớp | No | Numeric ID | 1 |
| Mã nhóm | No | Numeric ID | 1 |
| Ngày sinh (Y-m-d) | No | Date format YYYY-MM-DD | 2000-01-15 |
| Loại bằng | No | Text | Đại học |

#### Example CSV Content:
```csv
Mã sinh viên,Email,Tên,Họ,Số điện thoại,Mã khoa,Mã lớp,Mã nhóm,Ngày sinh (Y-m-d),Loại bằng
SV001,student1@example.com,Minh,Nguyễn,0912345678,1,1,1,2000-01-15,Đại học
SV002,student2@example.com,Hùng,Trần,0987654321,1,2,1,2001-03-20,Đại học
```

## Validation Rules

### Row-Level Validation:
1. **Required Fields**: `student_code`, `email`, `first_name`, `last_name` must not be empty
2. **Email Format**: Must be a valid email address
3. **Phone**: If provided, must be 10-11 digits
4. **Duplicate Check**: Row skipped if `email` or `student_code` already exists in database
5. **Invalid Rows**: Errors are logged with row number and reason

### Response Format:
After import, the system displays:
- ✅ Number of successfully imported students
- ❌ Number of failed/skipped rows
- ⚠️ Number of duplicate entries
- 📋 Detailed error report (if any)

## Implementation Details

### Backend Components

#### 1. StudentImportService (`app/Services/StudentImportService.php`)
- **Method**: `import($filePath)` - Main import processor
- **Features**:
  - CSV file parsing (fgetcsv)
  - Row validation
  - Duplicate detection
  - Batch student creation
  - Comprehensive error logging
  - Returns result summary

- **Key Methods**:
  - `parseHeaders()` - Extract column mappings
  - `processRow()` - Validate and process individual rows
  - `extractRowData()` - Map CSV columns to model fields
  - `validateRowData()` - Validate data format and required fields
  - `isDuplicate()` - Check for existing students
  - `createStudent()` - Create new student record
  - `generateCsvTemplate()` - Generate template content

#### 2. StudentListController (`app/Http/Controllers/Admin/StudentListController.php`)
- **Methods**:
  - `downloadTemplate()` - Download CSV template
  - `storeImport()` - Process uploaded CSV file
  - Returns JSON response with import results

#### 3. Routes (`routes/web.php`)
```php
Route::get('students/template/download', [...] )->name('students.template');
Route::post('students/import', [...] )->name('students.import');
```

### Frontend Components

#### Import Modal (`resources/views/admin/students/index.blade.php`)
- **Location**: Bottom of the student list page
- **Features**:
  - File upload input (CSV/TXT, max 5MB)
  - Template download link
  - Progress indicator
  - Results display (success/failure counts)
  - Error detail table
  - Auto-reload on successful import

## Usage Flow

### For Admin Users:

1. **Navigate** to Admin → Student Management → Student List
2. **Click** "Import CSV" button
3. **Select Action**:
   - Option A: Click "Download Template" to get sample file
   - Option B: Directly upload prepared CSV file
4. **Upload** CSV file with student data
5. **Review Results**:
   - See import summary (success/failure counts)
   - Review error details if any rows failed
   - Page auto-reloads on success

### For Data Preparation:

1. Download the CSV template
2. Open in Excel/Google Sheets/Text Editor
3. Fill in student information:
   - Required: MSSV, Email, Tên, Họ
   - Optional: Phone, Faculty ID, Class ID, etc.
4. Save as CSV format (comma-separated)
5. Upload via the modal

## Error Handling

### Row Processing Errors:
- **Missing Required Fields**: Field name shown in error message
- **Invalid Email Format**: Email value shown in error message
- **Invalid Phone Format**: "Must be 10-11 digits"
- **Duplicate Detection**: "Student already exists (MSSV or email duplicate)"

### File Upload Errors:
- **Invalid File Type**: "Only CSV/TXT files allowed"
- **File Too Large**: "File must not exceed 5MB"
- **File Processing Error**: "Error processing file" with exception message

### Display:
- Errors are displayed in a collapsible error details table
- Shows: Row number, Student Code, Email, Error message
- Users can scroll through errors if many exist

## Database Operations

### Student Creation:
When a row is successfully validated:
1. Generate password as hash of `student_code`
2. Set `role = 0` (student)
3. Set `status = 1` (active by default)
4. Create User record with all provided data
5. Omit empty optional fields

### Data Integrity:
- **Unique Constraints**: Enforced at database level
- **Foreign Keys**: Faculty ID, Class ID, Group ID validated if provided
- **Transaction Safety**: No partial imports
- **Logging**: All operations logged to `/storage/logs/laravel.log`

## Performance Considerations

### File Size Limits:
- Maximum: 5MB per file
- Recommended: <1000 rows (typically <100KB)

### Processing Time:
- Approximately 0.1-0.2 seconds per row
- 1000 students ≈ 100-200 seconds

### Temporary Storage:
- Files stored in `storage/app/imports/`
- Automatically cleaned up after processing
- Old files should be manually removed if disk space is concern

## Security Implications

### Data Validation:
- ✅ All inputs validated before database insertion
- ✅ SQL injection prevented via Laravel ORM
- ✅ File upload restricted to CSV/TXT
- ✅ File size limited to 5MB

### Access Control:
- 🔒 Requires Admin role (`auth`, `admin.only` middleware)
- 🔒 CSRF protection on POST requests

### Logging:
- 📝 All imports logged with:
  - Number of successful/failed records
  - Exact error details for debugging
  - Timestamp of import operation

## Troubleshooting

### Common Issues:

#### "File upload failed"
- Check file size (max 5MB)
- Verify file is valid CSV format
- Ensure MIME type is csv or txt

#### "All rows failed to import"
- Check CSV header spelling matches requirements
- Verify required fields present in all rows
- Check email format validity

#### "Some rows imported, others failed"
- Review error details table
- Check duplicate emails/student codes
- Verify Faculty/Class IDs exist in system

#### "Students not appearing after import"
- Check page not refreshed automatically
- Manually refresh the student list
- Check import result shows success count > 0

## Database Log Files

Import errors are logged to:
- **File**: `storage/logs/laravel.log`
- **Format**: Timestamp | Channel | Level | Message
- **Search**: `Student import` to find relevant entries

Example log entry:
```
[2024-03-16 14:45:30] local.INFO: Student import completed {"success":45,"failure":2,"duplicates":1}
[2024-03-16 14:45:30] local.ERROR: Student import failed {"error":"File not found"}
```

## Future Enhancements

Potential improvements for future versions:
1. Excel file support (.xlsx)
2. Photo/Avatar bulk upload
3. Import scheduling/automation
4. Import history logging
5. Custom field mapping
6. Duplicate handling options (skip/update/merge)
7. Batch email verification
8. Rollback capability
