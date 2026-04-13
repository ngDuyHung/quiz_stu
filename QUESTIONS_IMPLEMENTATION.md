# Questions & Answers Management System - Implementation Guide

## Feature Overview

A complete CRUD system for creating and managing questions with multiple question types (single choice, multiple choice, and matching), with dynamic option management, rich text editor support, and comprehensive validation.

---

## ✅ Acceptance Criteria - All Met

| Requirement | Implementation | Status |
|-------------|-----------------|--------|
| **Danh sách câu hỏi: filter theo category_id, level_id, type** | Implemented with dropdown filters and search | ✅ |
| **Hiển thị số đáp án + stats** | Shows option count and stats (served/correct/incorrect) | ✅ |
| **Rich text editor cho content** | TinyMCE editor integrated | ✅ |
| **Single type: 1 is_correct** | Validation: exactly 1 correct answer required | ✅ |
| **Multiple type: ≥2 is_correct** | Validation: at least 2 correct answers required | ✅ |
| **Match type: content + match_text** | Each option has left (content) and right (match_text) fields | ✅ |
| **Thêm/xóa option động bằng JS** | Full dynamic options with add/remove buttons | ✅ |
| **Sửa câu hỏi: load lại options** | Edit form pre-populates all options and allows modifications | ✅ |
| **Xóa câu hỏi: CASCADE delete options** | ON DELETE CASCADE configured in migration | ✅ |

---

## Files Created/Modified

### Backend

#### 1. **Controller** 
**File**: `app/Http/Controllers/Admin/QuestionsandAnswersController.php`

**Methods**:
- `index()` - List with filters (category, level, type, search)
- `create()` - Show create form
- `store()` - Save new question with validation
- `show()` - View single question details
- `edit()` - Show edit form with pre-populated data
- `update()` - Update question and options
- `destroy()` - Delete question (CASCADE deletes options)
- `getOptionsCount()` - API endpoint for option count
- `getStats()` - API endpoint for statistics

**Validations**:
- Single type: exact 1 correct answer
- Multiple type: at least 2 correct answers
- Match type: no specific correct answer requirement
- Minimum 2 options required
- Required fields: type, content, category_id, level_id

#### 2. **Routes**
**File**: `routes/web.php` - Added routes:
```php
Route::resource('questions', QuestionsandAnswersController::class);
Route::get('questions/{question}/options-count', ...)->name('questions.options-count');
Route::get('questions/{question}/stats', ...)->name('questions.stats');
```

#### 3. **Models**
**Files**: 
- `app/Models/Question.php` (existing, verified)
- `app/Models/QuestionOption.php` (existing, verified)

**Relationships**:
- Question has many QuestionOptions
- Question belongs to QuestionCategory
- Question belongs to QuestionLevel

### Frontend

#### 1. **Views**

**a) `resources/views/admin/questions/index.blade.php`** - List view
- Filter form (category, level, type, search)
- Table with:
  - Question content preview (max 80 chars)
  - Category badge
  - Level badge
  - Question type badge
  - Option count
  - Statistics (served/correct/incorrect)
  - Action buttons (view/edit/delete)
- Pagination support
- Delete confirmation modal (SweetAlert2)

**b) `resources/views/admin/questions/create.blade.php`** - Create form
- Question type selection (single/multiple/match)
- Category dropdown
- Level dropdown
- Rich text editor (TinyMCE) for content
- Description textarea
- Dynamic options management with:
  - Add option button
  - Remove option button per row
  - Type-specific layout (match has 2 input fields, others have 1)
  - Correct answer checkbox
- Type-specific help text
- Client-side validation
- Submit/Cancel buttons

**c) `resources/views/admin/questions/edit.blade.php`** - Edit form
- Pre-populated with existing question data
- Same layout as create form
- Shows current statistics
- Edit mode with hidden option IDs for updates
- Only deletes options that are removed, updates existing ones

**d) `resources/views/admin/questions/show.blade.php`** - Detail view
- Question metadata cards (category, level, type, option count)
- Rendered question content with HTML support
- Description if available
- Full statistics display
- Type-specific option display:
  - Single: Shows ✓ for correct answer
  - Multiple: Shows ✓ for correct answers
  - Match: Shows left and right columns
- Creation/update timestamps
- Edit and back buttons

#### 2. **CSS Styling**
- Responsive grid layout for options
- Match type options in 3-column grid (left, right, delete button)
- Other types in 3-column grid (content, is_correct checkbox, delete button)
- Badge colors for different information types
- Alert boxes for type-specific help text

#### 3. **JavaScript/TinyMCE**
- TinyMCE rich text editor for question content
- Dynamic options:
  - Add/remove buttons
  - Event listeners for type changes
  - Option HTML generation based on question type
  - Form validation before submit
- Type help text updates
- Old data restore on page reload/validation error
- Pre-population of existing options in edit mode

---

## Database Schema

### Tables (Already Created)

**questions**
```sql
- id
- type (single/multiple/match)
- content (HTML text)
- description (nullable)
- category_id (foreign key, CASCADE delete)
- level_id (foreign key, nullable)
- times_served (integer, default 0)
- times_correct (integer, default 0)
- times_incorrect (integer, default 0)
- created_at, updated_at
```

**question_options**
```sql
- id
- question_id (foreign key, CASCADE delete)
- content (text)
- match_text (nullable, for match type)
- is_correct (boolean)
```

### Relationships

```
Question
├─ belongsTo(QuestionCategory)
├─ belongsTo(QuestionLevel)
├─ hasMany(QuestionOption)
└─ hasMany(ResultAnswer)

QuestionOption
├─ belongsTo(Question) [CASCADE delete]
└─ hasMany(ResultAnswer)
```

---

## Feature Details

### Question Types

#### 1. **Single Choice (single)**
- Exactly 1 correct answer
- Radio button behavior for students
- Example: "What is 2+2?" A) 3  B) 4 (correct)  C) 5

#### 2. **Multiple Choice (multiple)**
- At least 2 correct answers
- Checkbox behavior for students
- Example: "Select prime numbers" A) 2 (✓)  B) 4  C) 5 (✓)  D) 10

#### 3. **Matching (match)**
- Pairs of left (content) and right (match_text)
- No correctness flag (all pairs are valid matches)
- Example: "Match terms with definitions"
  - Left: "Derivative", Right: "Rate of change"
  - Left: "Integral", Right: "Area under curve"

### Validation Rules

**Create/Update**:
1. Question type: required, in [single, multiple, match]
2. Content: required, any HTML allowed
3. Category: required, must exist
4. Level: required, must exist
5. Options: minimum 2, each with non-empty content

**Type-Specific**:
- Single: exactly 1 is_correct = true
- Multiple: at least 2 is_correct = true
- Match: no correctness requirement

**Validation Location**:
- Server-side: PHP validation in controller
- Client-side: JavaScript before form submit

### Dynamic Options Management

**Add Option**:
- Generates new form fields based on question type
- Append to container
- Re-attach event listeners

**Remove Option**:
- Removes entire option item from DOM
- No server call needed until form submit

**Type Change**:
- Clear all options
- Regenerate empty options based on new type
- Update help text

**Edit Mode**:
- Pre-populate existing options with data
- Include hidden ID field for update tracking
- Delete removed options on submit

---

## Routes & Endpoints

### Web Routes (Protected by auth + admin.only)

```
GET     /admin/questions                  → index()     list questions
GET     /admin/questions/create           → create()    show create form
POST    /admin/questions                  → store()     save new question
GET     /admin/questions/{id}             → show()      view details
GET     /admin/questions/{id}/edit        → edit()      show edit form
PUT     /admin/questions/{id}             → update()    save changes
DELETE  /admin/questions/{id}             → destroy()   delete question
```

### API Routes (for AJAX calls)

```
GET     /admin/questions/{id}/options-count    → JSON with count
GET     /admin/questions/{id}/stats            → JSON with stats
```

---

## Usage Workflow

### For Admin Users

#### Creating a Question

1. Navigate to: **Admin → Câu hỏi & Đáp án**
2. Click **Thêm câu hỏi** button
3. Select question type:
   - Single: Choose for "pick one"
   - Multiple: Choose for "pick multiple"
   - Match: Choose for "pairs"
4. Select category and level
5. Fill question content using rich text editor
6. Add 2+ options:
   - For Single/Multiple: Enter option text, check "correct" for right answer(s)
   - For Match: Enter left side (concept), right side (definition)
7. Click **Lưu câu hỏi**

#### Editing a Question

1. Go to **Danh sách Câu hỏi**
2. Find question, click **Sửa** button
3. Modify any field
4. Add/remove options as needed
5. Click **Lưu thay đổi**

#### Viewing/Analyzing Question

1. Go to **Danh sách Câu hỏi**
2. Click **Xem** button
3. See full details with statistics
4. Option to edit from detail view

#### Deleting Question

1. Go to **Danh sách Câu hỏi**
2. Click **Xóa** button
3. Confirm in modal
4. Question and all options deleted automatically (CASCADE)

### Search & Filter

1. Question content search
2. Filter by category
3. Filter by difficulty level
4. Filter by question type
5. Combine multiple filters

---

## Technical Implementation Details

### Frontend Technologies

- **HTML/Blade**: Template rendering
- **Bootstrap 5**: Responsive CSS framework
- **TinyMCE 6**: Rich text editor for question content
- **JavaScript (Vanilla)**: Dynamic options management
- **SweetAlert2**: Delete confirmation modal
- **FontAwesome 6**: Icons

### Backend Technologies

- **Laravel 11**: Framework
- **Eloquent ORM**: Database queries
- **Database Transactions**: Atomic operations during create/update
- **Validation**: Request validation rules

### JavaScript Features

- Dynamic form field generation
- Event listener management
- DOM manipulation
- Form validation before submit
- Type change handling
- Old data restoration

### Database Operations

- **Create**: Transaction ensures question + options created together
- **Read**: Eager loading of options and relationships
- **Update**: Transaction ensures atomic updates
- **Delete**: CASCADE delete handles options cleanup

---

## Error Handling

### Validation Errors

```
❌ Question type validation error
   → Message: "Loại câu hỏi không hợp lệ"
   
❌ Missing required fields
   → Message: "{Field} không được để trống"
   
❌ Wrong number of correct answers (Single type)
   → Message: "Loại 'Một đáp án' phải có đúng 1 đáp án đúng!"
   
❌ Wrong number of correct answers (Multiple type)
   → Message: "Loại 'Nhiều đáp án' phải có ít nhất 2 đáp án đúng!"
   
❌ Minimum 2 options required
   → Message: "Phải có ít nhất 2 đáp án!"
```

### User Feedback

- Success messages on create/update/delete
- Bootstrap alerts for errors
- Form validation messages
- SweetAlert2 confirmation modals
- Help text for question types

---

## Statistics & Metrics

### Question Stats Tracked

- **times_served**: How many times used in quizzes
- **times_correct**: How many students answered correctly
- **times_incorrect**: How many students answered incorrectly
- **correct_rate**: Calculated as (correct/served) * 100

### Display Locations

- List view: Shows all three stats for each question
- Detail view: Full statistics cards with counts
- Stats columns: Right-aligned in table

---

## Special Features

### Rich Text Editor

- **TinyMCE Integration**: CDN-based, no installation needed
- **Supported**: Lists, links, images, code blocks, formatting
- **Use Case**: Complex question content with formatting
- **Limitation**: No form if no TinyMCE API key (uses no-api-key)

### Dynamic Form Management

- **JavaScript-Only**: No page reloads for add/remove
- **Type-Aware**: Different layouts for different question types
- **Validation**: Real-time and on-submit
- **State Recovery**: Handles validation errors without data loss

### CASCADE Delete

- **Automatic**: Deleting question auto-deletes options
- **Database-Level**: Configured in migration with cascadeOnDelete()
- **Data Integrity**: No orphaned options remain
- **Performance**: Handled by DB, not Laravel

---

## Testing Checklist

- [ ] Create single choice question with 1 correct answer
- [ ] Create multiple choice question with 2+ correct answers
- [ ] Create matching question with pairs
- [ ] Edit question and modify options
- [ ] Add new option to existing question
- [ ] Remove option from existing question
- [ ] Delete question (verify options deleted)
- [ ] Test filters: category, level, type
- [ ] Test search by question content
- [ ] Test pagination with many questions
- [ ] Verify rich text content displays correctly
- [ ] Test form validation errors
- [ ] Test stats display for each question
- [ ] Verify timestamps (created/updated_at)

---

## Known Limitations

1. **TinyMCE**: Using "no-api-key" - Advanced features limited
2. **Options Display**: First 80 characters truncated in list
3. **No Bulk Operations**: Add/edit one question at a time
4. **Stats Not Real-Time**: Updated only by quiz result submissions
5. **No Photo Support**: Content is text/HTML only

---

## Future Enhancements

1. **Advanced API Key** for TinyMCE with full features
2. **Image Upload** support within question content
3. **Bulk Import** questions from CSV
4. **Question Duplication** feature
5. **Advanced Statistics** with charts/graphs
6. **Question Grouping** by topic/difficulty
7. **Question Reordering** in quizzes
8. **Difficulty Adjustment** based on statistics
9. **Question Comments** for admin notes
10. **Version History** for question content

---

## Menu Integration

**Dashboard Menu**: 
- **Module 3: Ngân hàng đề**
  - ✓ Danh mục câu hỏi
  - ✓ **Câu hỏi & Đáp án** ← Implemented
  - ○ Mức độ khó (placeholder)

---

## Support & Documentation

**Key Files**:
1. Controller: `app/Http/Controllers/Admin/QuestionsandAnswersController.php`
2. Views: `resources/views/admin/questions/`
3. Routes: `routes/web.php`
4. Models: `app/Models/Question.php`, `app/Models/QuestionOption.php`

**External Dependencies**:
- TinyMCE 6 (CDN)
- SweetAlert2 (CDN)
- Bootstrap 5 (CDN)
- FontAwesome 6 (CDN)

---

**Status**: ✅ Complete and Ready for Testing
**Version**: 1.0
**Date**: 2024-04-10
