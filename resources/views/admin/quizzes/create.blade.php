@extends('admin.dashboard')

@section('title', 'Tạo Bài thi mới')

@section('content')
<div class="container-fluid mt-4">
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
                            <textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
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
                    </div>

                    <div class="col-md-4">
                        <div class="card bg-light border-0">
                            <div class="card-body">
                                <h6 class="fw-bold mb-3 border-bottom pb-2">Cấu hình nâng cao</h6>
                                
                                <div class="form-check form-switch mb-3">
                                    <input class="form-check-input" type="checkbox" name="show_answer" id="show_answer" {{ old('show_answer') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="show_answer">Hiện đáp án sau khi nộp</label>
                                </div>

                                <div class="form-check form-switch mb-3">
                                    <input class="form-check-input" type="checkbox" name="require_camera" id="require_camera" {{ old('require_camera') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="require_camera">Yêu cầu bật Camera</label>
                                </div>

                                <div class="form-check form-switch mb-3">
                                    <input class="form-check-input" type="checkbox" name="shuffle_questions" id="shuffle_questions" {{ old('shuffle_questions') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="shuffle_questions">Tráo câu hỏi</label>
                                </div>

                                <div class="form-check form-switch mb-3">
                                    <input class="form-check-input" type="checkbox" name="require_login" id="require_login" checked {{ old('require_login', true) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="require_login">Yêu cầu đăng nhập</label>
                                </div>

                                <div class="form-check form-switch mb-3">
                                    <input class="form-check-input" type="checkbox" name="is_demo" id="is_demo" {{ old('is_demo') ? 'checked' : '' }}>
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
@endsection
