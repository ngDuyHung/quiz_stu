@extends('admin.dashboard')

@section('title', 'Chỉnh sửa Bài thi')

@section('content')
<div class="container-fluid mt-4">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-dark text-white">
            <h5 class="mb-0"><i class="fas fa-edit me-2"></i>Chỉnh sửa: {{ $quiz->name }}</h5>
        </div>
        <div class="card-body">

            <form action="{{ route('admin.quizzes.update', $quiz->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Tên bài thi</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', $quiz->name) }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Mô tả</label>
                            <textarea name="description" class="form-control" rows="3">{{ old('description', $quiz->description) }}</textarea>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Thời gian bắt đầu</label>
                                <input type="datetime-local" name="start_date" class="form-control" value="{{ old('start_date', $quiz->start_date ? $quiz->start_date->format('Y-m-d\TH:i') : '') }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Thời gian kết thúc</label>
                                <input type="datetime-local" name="end_date" class="form-control" value="{{ old('end_date', $quiz->end_date ? $quiz->end_date->format('Y-m-d\TH:i') : '') }}" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold">Thời gian làm bài (phút)</label>
                                <input type="number" name="duration_minutes" class="form-control" value="{{ old('duration_minutes', $quiz->duration_minutes) }}" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold">Số lần làm bài tối đa</label>
                                <input type="number" name="max_attempts" class="form-control" value="{{ old('max_attempts', $quiz->max_attempts) }}" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold">Phần trăm đạt (%)</label>
                                <input type="number" name="pass_percent" class="form-control" value="{{ old('pass_percent', $quiz->pass_percent) }}" required>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card bg-light border-0">
                            <div class="card-body">
                                <h6 class="fw-bold mb-3 border-bottom pb-2">Cấu hình nâng cao</h6>
                                
                                <div class="form-check form-switch mb-3">
                                    <input class="form-check-input" type="checkbox" name="show_answer" id="show_answer" {{ old('show_answer', $quiz->show_answer) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="show_answer">Hiện đáp án sau khi nộp</label>
                                </div>

                                <div class="form-check form-switch mb-3">
                                    <input class="form-check-input" type="checkbox" name="require_camera" id="require_camera" {{ old('require_camera', $quiz->require_camera) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="require_camera">Yêu cầu bật Camera</label>
                                </div>

                                <div class="form-check form-switch mb-3">
                                    <input class="form-check-input" type="checkbox" name="shuffle_questions" id="shuffle_questions" {{ old('shuffle_questions', $quiz->shuffle_questions) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="shuffle_questions">Tráo câu hỏi</label>
                                </div>

                                <div class="form-check form-switch mb-3">
                                    <input class="form-check-input" type="checkbox" name="require_login" id="require_login" {{ old('require_login', $quiz->require_login) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="require_login">Yêu cầu đăng nhập</label>
                                </div>

                                <div class="form-check form-switch mb-3">
                                    <input class="form-check-input" type="checkbox" name="is_demo" id="is_demo" {{ old('is_demo', $quiz->is_demo) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_demo">Bài thi thử nghiệm (Demo)</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <hr>
                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.quizzes.index') }}" class="btn btn-secondary">Quay lại</a>
                    <button type="submit" class="btn btn-primary px-4">Cập nhật Bài thi</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
