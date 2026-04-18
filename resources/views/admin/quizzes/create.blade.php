@extends('admin.dashboard')

@section('title', 'Tạo Bài thi mới')

@section('content')
<div class="container-fluid mt-4">
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-header bg-dark text-white">
            <h5 class="mb-0"><i class="fas fa-plus me-2"></i>Tạo Bài thi mới</h5>
        </div>
        <div class="card-body">

            <form action="{{ route('admin.quizzes.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Tên bài thi</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Mô tả</label>
                            <textarea name="description" class="form-control" rows="2">{{ old('description') }}</textarea>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Thời gian bắt đầu</label>
                                <input type="datetime-local" name="start_date" class="form-control" value="{{ old('start_date') }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Thời gian kết thúc</label>
                                <input type="datetime-local" name="end_date" class="form-control" value="{{ old('end_date') }}" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold">Thời gian làm bài (phút)</label>
                                <input type="number" name="duration_minutes" class="form-control" value="{{ old('duration_minutes', 60) }}" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold">Số lần làm bài tối đa</label>
                                <input type="number" name="max_attempts" class="form-control" value="{{ old('max_attempts', 1) }}" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold">Phần trăm đạt (%)</label>
                                <input type="number" name="pass_percent" class="form-control" value="{{ old('pass_percent', 50) }}" required>
                            </div>
                        </div>

                        {{-- Cấu trúc đề thi --}}
                        <div class="mt-4">
                            <div class="d-flex justify-content-between align-items-center mb-2 border-bottom pb-2">
                                <h6 class="fw-bold mb-0">Cấu trúc đề thi (Bốc câu hỏi tự động)</h6>
                                <button type="button" class="btn btn-outline-primary btn-sm" onclick="addConfigRow()">
                                    <i class="fas fa-plus me-1"></i>Thêm cấu hình
                                </button>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered">
                                    <thead class="table-light">
                                        <tr class="small text-center">
                                            <th>Danh mục</th>
                                            <th>Mức độ</th>
                                            <th width="100">Số câu</th>
                                            <th width="100">Điểm (+)</th>
                                            <th width="100">Điểm (-)</th>
                                            <th width="40"></th>
                                        </tr>
                                    </thead>
                                    <tbody id="config-body">
                                        <tr class="config-row">
                                            <td>
                                                <select name="configs[0][category_id]" class="form-select form-select-sm" required>
                                                    @foreach($categories as $cat)
                                                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <select name="configs[0][level_id]" class="form-select form-select-sm">
                                                    <option value="">-- Ngẫu nhiên --</option>
                                                    @foreach($levels as $lv)
                                                        <option value="{{ $lv->id }}">{{ $lv->name }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td><input type="number" name="configs[0][question_count]" class="form-control form-control-sm text-center" value="10" required></td>
                                            <td><input type="number" step="0.1" name="configs[0][score_correct]" class="form-control form-control-sm text-center" value="1.0"></td>
                                            <td><input type="number" step="0.1" name="configs[0][score_incorrect]" class="form-control form-control-sm text-center" value="0.0"></td>
                                            <td class="text-center"><button type="button" class="btn btn-link text-danger p-0" onclick="removeRow(this)"><i class="fas fa-times"></i></button></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        {{-- Chọn nhóm --}}
                        <div class="card mb-3 border-0 shadow-sm">
                            <div class="card-header bg-primary text-white py-2">
                                <h6 class="mb-0 small fw-bold">Gán cho Nhóm Sinh viên</h6>
                            </div>
                            <div class="card-body py-3" style="max-height: 250px; overflow-y: auto;">
                                @foreach($userGroups as $group)
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" name="group_ids[]" value="{{ $group->id }}" id="group_{{ $group->id }}">
                                    <label class="form-check-label small" for="group_{{ $group->id }}">
                                        {{ $group->name }}
                                    </label>
                                </div>
                                @endforeach
                                @error('group_ids')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Cấu hình nâng cao --}}
                        <div class="card bg-light border-0">
                            <div class="card-body">
                                <h6 class="fw-bold mb-3 border-bottom pb-2">Cấu hình nâng cao</h6>
                                
                                <div class="form-check form-switch mb-3">
                                    <input class="form-check-input" type="checkbox" name="show_answer" id="show_answer">
                                    <label class="form-check-label" for="show_answer">Hiện đáp án sau khi nộp</label>
                                </div>

                                <div class="form-check form-switch mb-3">
                                    <input class="form-check-input" type="checkbox" name="require_camera" id="require_camera">
                                    <label class="form-check-label" for="require_camera">Yêu cầu bật Camera</label>
                                </div>

                                <div class="form-check form-switch mb-3">
                                    <input class="form-check-input" type="checkbox" name="shuffle_questions" id="shuffle_questions" checked>
                                    <label class="form-check-label" for="shuffle_questions">Tráo câu hỏi</label>
                                </div>

                                <div class="form-check form-switch mb-3">
                                    <input class="form-check-input" type="checkbox" name="require_login" id="require_login" checked>
                                    <label class="form-check-label" for="require_login">Yêu cầu đăng nhập</label>
                                </div>

                                <div class="form-check form-switch mb-3">
                                    <input class="form-check-input" type="checkbox" name="is_demo" id="is_demo">
                                    <label class="form-check-label" for="is_demo">Bài thi thử nghiệm (Demo)</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <hr>
                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.quizzes.index') }}" class="btn btn-secondary">Quay lại</a>
                    <button type="submit" class="btn btn-primary px-4">Lưu Bài thi</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    let configIdx = 1;
    function addConfigRow() {
        const row = `
            <tr class="config-row">
                <td>
                    <select name="configs[${configIdx}][category_id]" class="form-select form-select-sm" required>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </td>
                <td>
                    <select name="configs[${configIdx}][level_id]" class="form-select form-select-sm">
                        <option value="">-- Ngẫu nhiên --</option>
                        @foreach($levels as $lv)
                            <option value="{{ $lv->id }}">{{ $lv->name }}</option>
                        @endforeach
                    </select>
                </td>
                <td><input type="number" name="configs[${configIdx}][question_count]" class="form-control form-control-sm text-center" value="10" required></td>
                <td><input type="number" step="0.1" name="configs[${configIdx}][score_correct]" class="form-control form-control-sm text-center" value="1.0"></td>
                <td><input type="number" step="0.1" name="configs[${configIdx}][score_incorrect]" class="form-control form-control-sm text-center" value="0.0"></td>
                <td class="text-center"><button type="button" class="btn btn-link text-danger p-0" onclick="removeRow(this)"><i class="fas fa-times"></i></button></td>
            </tr>
        `;
        document.getElementById('config-body').insertAdjacentHTML('beforeend', row);
        configIdx++;
    }

    function removeRow(btn) {
        if(document.querySelectorAll('.config-row').length > 1) {
            btn.closest('tr').remove();
        }
    }
</script>
@endsection
