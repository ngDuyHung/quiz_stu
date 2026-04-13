# CSV Import - Quick Start Guide

## 🚀 5-Minute Quick Start

### Step 1: Download Template (1 min)
1. Go to **Admin → Nhập câu hỏi (CSV)**
2. Click **"Tải file mẫu (CSV)"**
3. File `question_import_template.csv` downloads

### Step 2: Fill Template (2-3 min)
1. Open template in Excel or Google Sheets
2. Delete example rows
3. Add your questions in rows 2+
4. Follow format rules (see below)
5. Save as CSV

### Step 3: Upload & Preview (1 min)
1. Go to **Admin → Nhập câu hỏi (CSV)**
2. Click **"Chọn file CSV"**
3. Select your file
4. Click **"Kiểm tra & Xem trước"**
5. Review preview and errors

### Step 4: Import (instant)
1. If errors: Fix and re-upload
2. If OK: Click **"Xác nhận & Nhập"**
3. Results shown immediately

### Step 5: Check Results (1 min)
1. See success/failure counts
2. Download error log if needed
3. View questions list

---

## ✏️ CSV Format (Copy & Paste)

### Column Headers (Copy exactly)
```
type,content,category_id,level_id,description,option_1,option_2,option_3,option_4,option_5,option_6,match_text_1,match_text_2,match_text_3,match_text_4,match_text_5,match_text_6,correct_options
```

### Single Choice Example (Copy & modify)
```
single,What is 2+2?,1,1,Basic math,3,4,5,6,,,,,,,,4
```

### Multiple Choice Example
```
multiple,Select prime numbers,1,2,Math,2,3,4,5,6,,,,,,,,1|2|4
```

### Matching Example
```
match,Match countries-capitals,1,1,Geography,France,Germany,Italy,,,Paris,Berlin,Rome,,,
```

---

## 📋 Cheat Sheet

| Type | Rule | Example correct_options |
|------|------|------------------------|
| single | Exactly 1 correct | `1` or `3` or `5` |
| multiple | At least 2 correct | `1\|3` or `1\|2\|4` |
| match | Any pairs OK | leave empty |

### Things to Know

- **Columns**: Must have all columns from header row (even empty ones)
- **Options**: 2-6 per question, extra columns (option_7+) ignored
- **Correct indices**: 1-based (option_1 = index 1, not 0)
- **Separator**: Use `|` (pipe) for multiple correct answers, no spaces
- **Empty cells**: OK for description, match_text, option_5/6
- **Max file**: 10 MB
- **Max questions**: Tested with 1000+ rows

---

## ✖️ Common Mistakes

❌ **WRONG**: `correct_options: 0`  
✓ **RIGHT**: `correct_options: 1` (1-indexed!)

❌ **WRONG**: `correct_options: 1, 3, 5` (commas with spaces)  
✓ **RIGHT**: `correct_options: 1|3|5` (pipe, no spaces)

❌ **WRONG**: Single with `correct_options: 1|2` (multiple)  
✓ **RIGHT**: Single with `correct_options: 1` (exactly 1)

❌ **WRONG**: Missing header row  
✓ **RIGHT**: First row = headers, data starts row 2

❌ **WRONG**: `type: Single` (capitalized)  
✓ **RIGHT**: `type: single` (lowercase)

---

## 🎯 Step-by-Step Examples

### Example 1: Add 1 Single Choice

**CSV Content**:
```
type,content,category_id,level_id,description,option_1,option_2,option_3,option_4,option_5,option_6,match_text_1,match_text_2,match_text_3,match_text_4,match_text_5,match_text_6,correct_options
single,Capital of France?,1,1,French geography,Paris,London,Berlin,Madrid,,,,,,,,1
```

**Result**: 1 question created, 4 options, "Paris" marked correct

---

### Example 2: Add 1 Multiple Choice

**CSV Content**:
```
type,content,category_id,level_id,description,option_1,option_2,option_3,option_4,option_5,option_6,match_text_1,match_text_2,match_text_3,match_text_4,match_text_5,match_text_6,correct_options
multiple,Select integers,2,2,Math basics,2,3,4.5,5,0,-1,,,,,,2|4|5|6
```

**Result**: 6 options, options 2,4,5,6 (2,3,5,-1) marked correct

---

### Example 3: Add Matching Questions

**CSV Content**:
```
type,content,category_id,level_id,description,option_1,option_2,option_3,option_4,option_5,option_6,match_text_1,match_text_2,match_text_3,match_text_4,match_text_5,match_text_6,correct_options
match,Match countries & capitals,3,1,Geography,Japan,France,Germany,Australia,,Tokyo,Paris,Berlin,Canberra,,,
```

**Result**: Matching question with 4 pairs (no correctness marking)

---

## 🆔 Finding Category & Level IDs

### Get Category IDs
1. Go to **Admin → Danh mục câu hỏi**
2. View the list
3. Each row has an ID (first column or in edit URL)
4. Use those IDs in CSV

### Get Level IDs
1. Check database or ask admin
2. Common values: 1, 2, 3 (Easy, Medium, Hard)
3. Verify before import

---

## 🔍 Understanding Preview

### If Preview Shows GREEN:
✓ Will import! Click "Xác nhận & Nhập"

### If Preview Shows RED:
✗ Has errors! Download errors list

### If Preview Shows MIXED:
⚠ Some row will succeed, some will fail:
- Successful rows: Show in green preview
- Failed rows: Show in error accordion
- Fix errors and re-upload failed rows

---

## 📥 After Import

### Results Show:
- ✓ **Green card**: Success count (imported)
- ✗ **Red card**: Failure count (skipped)

### If Failures:
1. Click **"Tải file log lỗi"**
2. Get CSV with all failed rows
3. Edit the CSV, fix errors
4. Re-upload and import again

### Back to Questions:
1. Click **"Xem tất cả câu hỏi"**
2. New questions appear in list
3. Can edit/delete individually

---

## ⚡ Performance Tips

✓ **Small batches**: 100-200 questions per upload (faster feedback)  
✓ **Check IDs first**: Validate category/level IDs prevent failures  
✓ **Test first**: Upload 5 test rows before full batch  
✓ **Error fix**: Fix all at once, don't re-upload singles  

---

## 🆘 Troubleshooting

| Problem | Cause | Solution |
|---------|-------|----------|
| File won't upload | Too large (>10MB) | Split into smaller files |
| Header error | Wrong column names | Download fresh template |
| Category error | ID doesn't exist | Check Category Management page |
| Single not importing | 0 or 2+ correct answers | Must be exactly 1 |
| Multiple not importing | 0-1 correct answers | Must be 2+ |
| Data looks wrong | CSV encoding issue | Save as UTF-8 CSV |

---

## 📞 Need Help?

- See full guide: `QUESTIONS_CSV_IMPORT_GUIDE.md`
- Check error accordion on preview page
- Download error log for details
- Ask admin for category/level IDs

---

## ✅ Checklist Before Upload

- [ ] Downloaded template
- [ ] CSV has headers in row 1
- [ ] Data starts in row 2
- [ ] All required column headers present
- [ ] type is lowercase (single/multiple/match)
- [ ] category_id is numeric and exists
- [ ] level_id is numeric and exists
- [ ] At least 2 options per question
- [ ] correct_options uses 1-based indices
- [ ] No spaces in correct_options (use `|` separator)
- [ ] Single choice has exactly 1 in correct_options
- [ ] Multiple choice has 2+ in correct_options
- [ ] File size < 10MB

---

**Ready? Go to Admin → Nhập câu hỏi (CSV) and start importing! 🚀**

