@extends('admin.dashboard')

@section('title', 'Chỉnh sửa câu hỏi')

@section('content')
<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js"></script>

<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-lg-10 mx-auto">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0">
                        <i class="fas fa-edit me-2"></i>Chỉnh sửa câu hỏi
                    </h5>
                </div>

                <div class="card-body">
                    {{-- Errors Display --}}
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show">
                            <strong>Lỗi:</strong>
                            <ul class="mb-0 mt-2">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form action="{{ route('admin.questions.update', $question->id) }}" method="POST" id="questionForm" 
                          data-existing-options='@json($question->options)'>
                        @csrf
                        @method('PUT')

                        {{-- Question Type --}}
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Loại câu hỏi <span class="text-danger">*</span></label>
                                <select name="type" id="questionType" class="form-select @error('type') is-invalid @enderror" required>
                                    <option value="">-- Chọn loại --</option>
                                    <option value="single" {{ $question->type === 'single' ? 'selected' : '' }}>
                                        Một đáp án (Single Choice)
                                    </option>
                                    <option value="multiple" {{ $question->type === 'multiple' ? 'selected' : '' }}>
                                        Nhiều đáp án (Multiple Choice)
                                    </option>
                                    <option value="match" {{ $question->type === 'match' ? 'selected' : '' }}>
                                        Ghép cặp (Matching)
                                    </option>
                                </select>
                                @error('type')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Danh mục <span class="text-danger">*</span></label>
                                <select name="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                                    <option value="">-- Chọn danh mục --</option>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->id }}" {{ $question->category_id == $cat->id ? 'selected' : '' }}>
                                            {{ $cat->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Mức độ <span class="text-danger">*</span></label>
                                <select name="level_id" class="form-select @error('level_id') is-invalid @enderror" required>
                                    <option value="">-- Chọn mức độ --</option>
                                    @foreach($levels as $level)
                                        <option value="{{ $level->id }}" {{ $question->level_id == $level->id ? 'selected' : '' }}>
                                            {{ $level->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('level_id')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Question Content --}}
                        <div class="mb-3">
                            <label class="form-label">Nội dung câu hỏi <span class="text-danger">*</span></label>
                            <textarea name="content" id="questionContent" class="form-control @error('content') is-invalid @enderror" 
                                      rows="5" required>{!! $question->content !!}</textarea>
                            @error('content')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Hỗ trợ HTML, định dạng, hình ảnh</small>
                        </div>

                        {{-- Question Description --}}
                        <div class="mb-3">
                            <label class="form-label">Ghi chú / Giải thích</label>
                            <textarea name="description" class="form-control @error('description') is-invalid @enderror" 
                                      rows="3" placeholder="Ghi chú/giải thích cho câu hỏi này">{{ $question->description }}</textarea>
                            @error('description')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Stats --}}
                        <div class="row mb-4">
                            <div class="col-md-3">
                                <div class="alert alert-info py-2 px-3 mb-0">
                                    <small class="d-block">Phục vụ: <strong>{{ $question->times_served }}</strong></small>
                                    <small class="d-block text-success">Đúng: <strong>{{ $question->times_correct }}</strong></small>
                                    <small class="d-block text-danger">Sai: <strong>{{ $question->times_incorrect }}</strong></small>
                                </div>
                            </div>
                        </div>

                        {{-- Options --}}
                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <label class="form-label fw-bold">Đáp án <span class="text-danger">*</span></label>
                                <button type="button" class="btn btn-outline-primary btn-sm" id="addOption">
                                    <i class="fas fa-plus me-1"></i>Thêm đáp án
                                </button>
                            </div>

                            <div id="optionsContainer">
                                {{-- Options will be rendered here --}}
                            </div>
                        </div>

                        {{-- Help Text --}}
                        <div class="alert alert-info" id="typeHelp">
                            <i class="fas fa-info-circle me-2"></i>
                            <span id="typeHelpText"></span>
                        </div>

                        {{-- Action Buttons --}}
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-warning">
                                <i class="fas fa-save me-2"></i>Lưu thay đổi
                            </button>
                            <a href="{{ route('admin.questions.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times me-2"></i>Hủy
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.option-item {
    background: #f8f9fa;
    padding: 15px;
    border-radius: 5px;
    margin-bottom: 12px;
    border: 1px solid #dee2e6;
}

.option-item.match-option {
    display: grid;
    grid-template-columns: 1fr 1fr auto;
    gap: 10px;
    align-items: end;
}

.option-item:not(.match-option) {
    display: grid;
    grid-template-columns: 1fr auto auto;
    gap: 10px;
    align-items: end;
}

.option-item input[type="text"],
.option-item input[type="checkbox"] {
    margin: 0;
}

.btn-remove-option {
    padding: 5px 10px;
}
</style>

<script>
    tinymce.init({
        selector: '#questionContent',
        plugins: 'lists link image code',
        toolbar: 'formatselect | bold italic underline | bullist numlist | link image code',
        menubar: false
    });

    const questionType = document.getElementById('questionType');
    const optionsContainer = document.getElementById('optionsContainer');
    const addOptionBtn = document.getElementById('addOption');
    const typeHelpText = document.getElementById('typeHelpText');
    let optionCount = 0;

    const typeHelpTexts = {
        single: '✓ Chọn 1 đáp án đúng | ○ Học sinh chọn 1 trong các lựa chọn',
        multiple: '✓ Chọn ≥2 đáp án đúng | □ Học sinh có thể chọn nhiều đáp án',
        match: '↔ Bên trái ghép với bên phải | Học sinh nối các cặp liên quan'
    };

    // Existing options data - will be populated from form on page load
    const existingOptions = [];

    function updateTypeHelp() {
        const type = questionType.value;
        typeHelpText.textContent = typeHelpTexts[type] || '';
    }

    function createOptionElement(optionIndex, optionData = null) {
        const index = optionIndex;
        const isMatchType = questionType.value === 'match';

        if (isMatchType) {
            return `
                <div class="option-item match-option">
                    <div>
                        <label class="form-label small">Bên trái</label>
                        <input type="text" name="options[${index}][content]" class="form-control form-control-sm" 
                               placeholder="Khái niệm/Đạo hàm..." 
                               value="${optionData ? optionData.content : ''}" required>
                        <input type="hidden" name="options[${index}][id]" value="${optionData ? optionData.id : ''}">
                    </div>
                    <div>
                        <label class="form-label small">Bên phải</label>
                        <input type="text" name="options[${index}][match_text]" class="form-control form-control-sm" 
                               placeholder="Định nghĩa/Kết quả..." 
                               value="${optionData ? optionData.match_text : ''}" required>
                    </div>
                    <button type="button" class="btn btn-danger btn-remove-option btn-sm">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            `;
        } else {
            return `
                <div class="option-item">
                    <div>
                        <label class="form-label small">Nội dung đáp án</label>
                        <input type="text" name="options[${index}][content]" class="form-control form-control-sm" 
                               placeholder="Nhập đáp án..." 
                               value="${optionData ? optionData.content : ''}" required>
                        <input type="hidden" name="options[${index}][id]" value="${optionData ? optionData.id : ''}">
                    </div>
                    <div>
                        <label class="form-label small">Là đáp án đúng?</label>
                        <div class="form-check mb-0">
                            <input type="checkbox" name="options[${index}][is_correct]" class="form-check-input" 
                                   value="1" 
                                   ${optionData && optionData.is_correct ? 'checked' : ''}>
                        </div>
                    </div>
                    <button type="button" class="btn btn-danger btn-remove-option btn-sm">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            `;
        }
    }

    function renderOptions() {
        optionsContainer.innerHTML = '';
        optionCount = 0;

        if (existingOptions && existingOptions.length > 0) {
            existingOptions.forEach(option => {
                const html = createOptionElement(optionCount++, option);
                optionsContainer.insertAdjacentHTML('beforeend', html);
            });
        }

        // Add at least 2 empty options if none exist
        if (optionCount === 0) {
            const html = createOptionElement(optionCount++);
            optionsContainer.insertAdjacentHTML('beforeend', html);
            const html2 = createOptionElement(optionCount++);
            optionsContainer.insertAdjacentHTML('beforeend', html);
        }

        attachRemoveListeners();
    }

    function addOption() {
        const html = createOptionElement(optionCount++);
        optionsContainer.insertAdjacentHTML('beforeend', html);
        attachRemoveListeners();
    }

    function attachRemoveListeners() {
        document.querySelectorAll('.btn-remove-option').forEach(btn => {
            btn.removeEventListener('click', removeOption);
            btn.addEventListener('click', removeOption);
        });
    }

    function removeOption(e) {
        e.preventDefault();
        e.target.closest('.option-item').remove();
    }

    questionType.addEventListener('change', function() {
        renderOptions();
        updateTypeHelp();
    });

    addOptionBtn.addEventListener('click', addOption);

    // Initialize - Load existing options from form data attribute
    try {
        const formElement = document.getElementById('questionForm');
        const dataAttr = formElement.getAttribute('data-existing-options');
        if (dataAttr) {
            const parsed = JSON.parse(dataAttr);
            if (Array.isArray(parsed)) {
                existingOptions.push(...parsed);
            }
        }
    } catch (e) {
        console.error('Error loading existing options:', e);
    }
    
    updateTypeHelp();
    renderOptions();

    // Form validation
    document.getElementById('questionForm').addEventListener('submit', function(e) {
        const type = questionType.value;
        const options = Array.from(document.querySelectorAll('[name^="options["][name$="][content]"]'));
        const correctOptions = Array.from(document.querySelectorAll('[name^="options["][name$="][is_correct]"]:checked'));

        if (options.length < 2) {
            e.preventDefault();
            alert('Phải có ít nhất 2 đáp án!');
            return;
        }

        if (type === 'single' && correctOptions.length !== 1) {
            e.preventDefault();
            alert('Loại "Một đáp án" phải có đúng 1 đáp án đúng!');
            return;
        }

        if (type === 'multiple' && correctOptions.length < 2) {
            e.preventDefault();
            alert('Loại "Nhiều đáp án" phải có ít nhất 2 đáp án đúng!');
            return;
        }
    });
</script>

@endsection
