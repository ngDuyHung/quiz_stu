# CSV Import Feature for Questions - Complete Guide

## 📋 Overview

The CSV import feature allows administrators to import hundreds of questions at once from a CSV file instead of manually entering them one by one. This significantly saves time and reduces data entry errors.

---

## ✨ Features

✅ **Bulk Import**: Import up to hundreds of questions in one operation  
✅ **Format Validation**: Validates each row before import  
✅ **Detailed Error Logging**: Shows exactly which rows failed and why  
✅ **Preview Before Import**: Shows 5 sample rows before confirming  
✅ **Error Download**: Download error log as CSV for fixing and re-import  
✅ **CSV Template**: Pre-built CSV template with examples  
✅ **Type Support**: Single choice, multiple choice, and matching questions  
✅ **Progress Feedback**: Shows success count vs failure count  

---

## 📊 CSV Format Specification

### Required Columns

```
type
content
category_id
level_id
option_1
option_2
option_3
option_4
option_5
option_6
match_text_1
match_text_2
match_text_3
match_text_4
match_text_5
match_text_6
description (optional)
correct_options
```

### Column Details

| Column | Type | Required | Description | Example |
|--------|------|----------|-------------|---------|
| `type` | string | YES | Question type: `single`, `multiple`, or `match` | `single` |
| `content` | string | YES | Question text (can contain HTML) | `What is 2+2?` |
| `category_id` | integer | YES | Category ID (must exist in DB) | `1` |
| `level_id` | integer | YES | Difficulty level ID (must exist in DB) | `2` |
| `option_1` to `option_6` | string | At least 2 | Answer/choice text | `Paris` |
| `match_text_1` to `match_text_6` | string | For match type | Right-side text for matching | `Capital of France` |
| `description` | string | NO | Optional question explanation | `Geography question` |
| `correct_options` | string | YES | **1-indexed** indices of correct answers, pipe-separated | `1` or `1\|3\|5` |

---

## 🎯 Question Type Rules

### Single Choice (`single`)
```
Rule: EXACTLY 1 correct answer
Example:
  type: single
  content: What is the capital of France?
  option_1: Paris
  option_2: London
  option_3: Berlin
  correct_options: 1
```

### Multiple Choice (`multiple`)
```
Rule: AT LEAST 2 correct answers
Example:
  type: multiple
  content: Select all prime numbers:
  option_1: 2
  option_2: 3
  option_3: 4
  option_4: 5
  option_5: 6
  correct_options: 1|2|4
```

### Matching (`match`)
```
Rule: No correctness requirement (all pairs are valid)
Example:
  type: match
  content: Match countries with capitals:
  option_1: France
  option_2: Germany
  option_3: Italy
  match_text_1: Paris
  match_text_2: Berlin
  match_text_3: Rome
  correct_options: (leave empty or put anything)
```

---

## 📝 CSV Examples

### Single Choice Example
```csv
type,content,category_id,level_id,description,option_1,option_2,option_3,option_4,option_5,option_6,correct_options
single,What is 2+2?,1,1,Basic math,3,4,5,6,,4
single,Capital of France?,1,1,Geography,Paris,London,Berlin,Madrid,,1
```

### Multiple Choice Example
```csv
type,content,category_id,level_id,description,option_1,option_2,option_3,option_4,option_5,option_6,correct_options
multiple,Select prime numbers:,1,2,Math,2,3,4,5,6,1|2|4
multiple,Which programming languages exist?,2,2,Computer Science,Python,Java,C++,HTML,JavaScript,Kotlin,1|2|3|5|6
```

### Matching Example
```csv
type,content,category_id,level_id,description,option_1,option_2,option_3,match_text_1,match_text_2,match_text_3,correct_options
match,Match countries with capitals:,1,1,Geography,France,Germany,Italy,Paris,Berlin,Rome,
match,Match verbs with meanings:,3,2,English,Run,Eat,Sleep,Move quickly,Consume food,Rest,
```

### Full Example with All Columns
```csv
type,content,category_id,level_id,description,option_1,option_2,option_3,option_4,option_5,option_6,match_text_1,match_text_2,match_text_3,match_text_4,match_text_5,match_text_6,correct_options
single,What is the largest planet in our solar system?,1,1,Astronomy,Mercury,Venus,Jupiter,Mars,Saturn,Uranus,,,,,,,3
multiple,Select reptiles:,2,2,Biology,Snake,Cat,Lizard,Dog,Crocodile,Bird,,,,,,,1|3|5
match,Match capital cities with countries:,1,1,Geography,Tokyo,Paris,Berlin,Canberra,Japan,France,Germany,Australia,,,,,
```

---

## 🚀 How to Use

### Step 1: Prepare CSV File

1. Download the template from the import page
2. Fill in your questions following the format rules
3. Save as `.csv` file
4. File size limit: **10MB**

### Step 2: Navigate to Import

1. Go to **Admin Dashboard**
2. Click **"Nhập câu hỏi (CSV)"** in the Module 3 section
3. Or navigate to: `/admin/questions-import`

### Step 3: Upload File

1. Click "Chọn file CSV" to select your file
2. Click "Kiểm tra & Xem trước" to validate
3. The system will:
   - Parse the CSV file
   - Validate each row
   - Show preview of first 5 valid rows
   - Display error details for invalid rows
   - Show expected success/failure counts

### Step 4: Review Preview

The preview page shows:
- **Success Count**: How many will be imported
- **Failure Count**: How many will fail
- **Preview Table**: First 5 valid rows
- **Error Details**: Each error with line number, error message, and content

### Step 5: Confirm Import

If satisfied with preview:
1. Click **"Xác nhận & Nhập"** button
2. Wait for import to complete
3. The system will:
   - Import all valid rows to database
   - Generate error log if there are failures
   - Display importing results

### Step 6: View Results

The results page shows:
- **Total Successful**: Green card with count
- **Total Failed**: Red card with count
- **Error Details**: List of failed rows with reasons
- **Download Error Log**: CSV file for fixing and re-import

---

## ⚠️ Validation Rules

### System Validates

✓ File exists and is readable  
✓ CSV headers are correct  
✓ Each row has required fields  
✓ Type is valid (single/multiple/match)  
✓ Content is not empty  
✓ category_id is numeric and exists  
✓ level_id is numeric and exists  
✓ At least 2 options provided  
✓ Maximum 6 options per question  
✓ correct_options are 1-indexed numbers  
✓ Indices don't exceed option count  
✓ Type-specific validation:
  - Single: exactly 1 correct answer
  - Multiple: at least 2 correct answers
  - Match: any number valid (no validation)

---

## 🔴 Common Errors

### Error: "File không tồn tại"
**Cause**: File upload failed or server issue  
**Fix**: Try uploading again with a smaller file

### Error: "Header không hợp lệ"
**Cause**: CSV columns don't match required format  
**Fix**: Use the downloaded template and follow the column names exactly

### Error: "category_id không tồn tại: X"
**Cause**: The category with ID X doesn't exist in database  
**Fix**: Check category IDs in the Category Management page

### Error: "level_id không tồn tại: X"
**Cause**: The level with ID X doesn't exist in database  
**Fix**: Check available levels in the system

### Error: "Phải có ít nhất 2 đáp án"
**Cause**: Row has fewer than 2 options  
**Fix**: Add at least 2 non-empty options (option_1 and option_2)

### Error: "Tối đa 6 đáp án ở mỗi câu"
**Cause**: More than 6 options provided  
**Fix**: Remove columns option_7, option_8, etc.

### Error: "Loại 'single' phải có đúng 1 đáp án đúng"
**Cause**: Single choice question has wrong number of correct answers  
**Fix**: Correct the correct_options field - must be exactly 1 index (e.g., `1` or `3`)

### Error: "Loại 'multiple' phải có ít nhất 2 đáp án đúng"
**Cause**: Multiple choice has fewer than 2 correct answers  
**Fix**: Add more indices to correct_options (e.g., `1|3|5`)

### Error: "Chỉ số đáp án vượt quá: X"
**Cause**: correct_options references an option that doesn't exist  
**Fix**: If you have 4 options, correct_indices should only reference 1-4

---

## 📂 File Management

### Uploaded Files
- Stored temporarily in: `storage/app/temp-csv/`
- Deleted after import completes
- Cleaned up automatically on import failure

### Error Logs
- Stored in: `storage/logs/`
- Filename format: `question_import_errors_YYYY-MM-DD_HH-ii-ss.csv`
- Downloaded automatically from results page
- Contains line number, error description, and question content

### CSV Template
- Stored in: `storage/app/templates/`
- Generated on first download request
- Pre-loaded with 3 examples (single, multiple, match types)

---

## 🔍 Data Flow

```
Upload CSV
    ↓
Parse & Validate
    ├─ Check file format
    ├─ Validate headers
    ├─ Validate each row
    └─ Collect preview data
    ↓
Show Preview
    ├─ Success count
    ├─ Failure count
    ├─ Error details
    └─ First 5 valid rows
    ↓
Confirm Import
    ↓
Import Process (Database Transaction)
    ├─ For each valid row:
    │  ├─ Create Question
    │  ├─ Create QuestionOptions
    │  └─ Parse correct_options
    └─ Rollback on error
    ↓
Generate Results
    ├─ Count successes
    ├─ Collect failures
    ├─ Generate error log CSV
    └─ Display results
    ↓
Show Results & Offer Downloads
```

---

## 📊 Database Schema

### Questions Table
```sql
CREATE TABLE questions (
    id BIGINT PRIMARY KEY,
    type ENUM('single', 'multiple', 'match'),
    content LONGTEXT,
    description TEXT NULLABLE,
    category_id BIGINT FOREIGN KEY,
    level_id BIGINT FOREIGN KEY,
    times_served INT DEFAULT 0,
    times_correct INT DEFAULT 0,
    times_incorrect INT DEFAULT 0,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

### Question_Options Table
```sql
CREATE TABLE question_options (
    id BIGINT PRIMARY KEY,
    question_id BIGINT FOREIGN KEY (CASCADE DELETE),
    content TEXT,
    match_text VARCHAR(500) NULLABLE,
    is_correct BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

---

## 🎓 Best Practices

✅ **Do's**
- Test with a small CSV first (5-10 rows)
- Use the provided template as base
- Check category_id and level_id exist before import
- Keep option text concise for readability
- For match type, ensure left/right pairs are meaningful
- Use pipe `|` for multiple correct indices, no spaces
- Download and check error log if there are failures
- Fix errors and re-import problematic rows

❌ **Don'ts**
- Don't mix question types in categories unnecessarily
- Don't leave blank options between filled options (e.g., option_1=Text, option_2=blank, option_3=Text is OK; option_2=blank, option_3=Text is confusing)
- Don't use special characters that break CSV format
- Don't import without reviewing preview first
- Don't assume all rows imported if failure count is 0 - check results
- Don't forget to save error log for audit trail

---

## 🔧 Technical Details

### Service Class
**Location**: `app/Services/QuestionImportService.php`

**Key Methods**:
- `validateCsv($filePath)`: Validate and preview
- `importCsv($filePath)`: Execute import
- `validateHeaders($headers)`: Check column names
- `validateRow($data, $lineNumber)`: Validate single row
- `importRow($data, $lineNumber)`: Import single row
- `generateErrorLog($errors)`: Create error CSV

### Controller Methods
**Location**: `app/Http/Controllers/Admin/QuestionsandAnswersController.php`

**New Methods**:
- `showImportForm()`: Show upload page
- `previewImport(Request $request)`: Validate and show preview
- `confirmImport(Request $request)`: Execute import
- `downloadTemplate()`: Generate CSV template
- `downloadErrorLog($filename)`: Download error log

### Routes
**Location**: `routes/web.php`

```php
// Import routes (in admin middleware group)
Route::get('questions-import', 'showImportForm')->name('questions.import-form');
Route::post('questions-import/preview', 'previewImport')->name('questions.import-preview');
Route::post('questions-import/confirm', 'confirmImport')->name('questions.import-confirm');
Route::get('questions-import/template/download', 'downloadTemplate')->name('questions.template');
Route::get('questions-import/errors/{filename}', 'downloadErrorLog')->name('questions.error-log');
```

### Views
**Locations**:
- `resources/views/admin/questions/import.blade.php` - Upload form
- `resources/views/admin/questions/import-preview.blade.php` - Preview page
- `resources/views/admin/questions/import-result.blade.php` - Results page

---

## 📈 Performance

- **CSV Parsing**: Line-by-line to reduce memory usage
- **Database**: Uses transactions for data integrity
- **Validation**: Early termination on validation errors
- **File Size**: 10MB limit prevents server strain
- **Error Logging**: Efficient CSV generation

---

## ✅ Testing

### Test Case 1: Single Choice
```
Upload: 1 single-choice question with 1 correct answer
Expected: Success
```

### Test Case 2: Multiple Choice
```
Upload: 1 multiple-choice with 2+ correct answers
Expected: Success
```

### Test Case 3: Matching
```
Upload: 1 matching question with 3 pairs
Expected: Success
```

### Test Case 4: Invalid Type
```
Upload: Row with type="invalid"
Expected: Failure - error in preview
```

### Test Case 5: Missing Category
```
Upload: Row with category_id=9999
Expected: Failure - category doesn't exist
```

### Test Case 6: Wrong Correct Count (single)
```
Upload: Single-choice with 2 correct answers
Expected: Failure - needs exactly 1 correct
```

### Test Case 7: Duplicate Import
```
Upload: Same CSV twice
Expected: Both succeed - creates duplicate questions
```

---

## 🎯 Summary

The CSV import feature provides:
- **Efficiency**: Import hundreds of questions in seconds
- **Reliability**: Comprehensive validation prevents data corruption
- **Visibility**: Preview and error reporting provide full transparency
- **Recovery**: Error logs enable fixing and re-import
- **Flexibility**: Supports all three question types

For questions or issues, check the error log and follow the troubleshooting guide above.

