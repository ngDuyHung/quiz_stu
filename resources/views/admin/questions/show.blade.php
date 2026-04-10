@extends('admin.dashboard')

@section('title', 'Xem chi tiết câu hỏi')

@section('content')

<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-lg-10 mx-auto">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-eye me-2"></i>Chi tiết câu hỏi
                    </h5>
                    <div>
                        <a href="{{ route('admin.questions.edit', $question->id) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit me-2"></i>Sửa
                        </a>
                        <a href="{{ route('admin.questions.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left me-2"></i>Quay lại
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    {{-- Question Metadata --}}
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <div class="card border-0 bg-light">
                                <div class="card-body">
                                    <small class="text-muted d-block">Danh mục</small>
                                    <strong class="text-primary">{{ $question->category->name }}</strong>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card border-0 bg-light">
                                <div class="card-body">
                                    <small class="text-muted d-block">Mức độ</small>
                                    <strong class="text-warning">{{ $question->level->name }}</strong>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card border-0 bg-light">
                                <div class="card-body">
                                    <small class="text-muted d-block">Loại câu hỏi</small>
                                    <strong class="text-success">
                                        @if($question->type === 'single')
                                            Một đáp án
                                        @elseif($question->type === 'multiple')
                                            Nhiều đáp án
                                        @else
                                            Ghép cặp
                                        @endif
                                    </strong>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card border-0 bg-light">
                                <div class="card-body">
                                    <small class="text-muted d-block">Tổng đáp án</small>
                                    <strong class="text-info">{{ $question->options->count() }}</strong>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Question Content --}}
                    <div class="mb-4">
                        <h6 class="text-muted">Nội dung câu hỏi</h6>
                        <div class="bg-light p-3 rounded border">
                            {!! $question->content !!}
                        </div>
                    </div>

                    {{-- Description --}}
                    @if($question->description)
                    <div class="mb-4">
                        <h6 class="text-muted">Ghi chú / Giải thích</h6>
                        <div class="bg-light p-3 rounded border">
                            {{ $question->description }}
                        </div>
                    </div>
                    @endif

                    {{-- Statistics --}}
                    <div class="mb-4">
                        <h6 class="text-muted mb-3">Thống kê sử dụng</h6>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="card border-success">
                                    <div class="card-body text-center">
                                        <h5 class="card-title text-success">{{ $question->times_served }}</h5>
                                        <p class="card-text mb-0 small">Lần phục vụ</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card border-info">
                                    <div class="card-body text-center">
                                        <h5 class="card-title text-info">{{ $question->times_correct }}</h5>
                                        <p class="card-text mb-0 small">Lần trả lời đúng</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card border-danger">
                                    <div class="card-body text-center">
                                        <h5 class="card-title text-danger">{{ $question->times_incorrect }}</h5>
                                        <p class="card-text mb-0 small">Lần trả lời sai</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Options/Answers --}}
                    <div class="mb-4">
                        <h6 class="text-muted mb-3">Đáp án</h6>

                        @if($question->type === 'single')
                            <div class="list-group">
                                @foreach($question->options as $option)
                                <div class="list-group-item">
                                    <div class="d-flex gap-2">
                                        <div>
                                            @if($option->is_correct)
                                                <span class="badge bg-success">✓ Đúng</span>
                                            @else
                                                <span class="badge bg-light text-dark">○</span>
                                            @endif
                                        </div>
                                        <div style="flex: 1;">
                                            {{ $option->content }}
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>

                        @elseif($question->type === 'multiple')
                            <div class="list-group">
                                @foreach($question->options as $option)
                                <div class="list-group-item">
                                    <div class="d-flex gap-2">
                                        <div>
                                            @if($option->is_correct)
                                                <span class="badge bg-success">✓ Đúng</span>
                                            @else
                                                <span class="badge bg-light text-dark">□</span>
                                            @endif
                                        </div>
                                        <div style="flex: 1;">
                                            {{ $option->content }}
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>

                        @else {{-- Match type --}}
                            <div class="row">
                                <div class="col-md-6">
                                    <h6 class="small text-muted">Bên trái</h6>
                                    <div class="list-group">
                                        @foreach($question->options as $option)
                                        <div class="list-group-item">{{ $option->content }}</div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <h6 class="small text-muted">Bên phải (Ghép lại)</h6>
                                    <div class="list-group">
                                        @foreach($question->options as $option)
                                        <div class="list-group-item">{{ $option->match_text }}</div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>

                    {{-- Timeline --}}
                    <div class="mt-4 pt-3 border-top">
                        <small class="text-muted">
                            <i class="fas fa-clock me-1"></i>Tạo: {{ $question->created_at->format('d/m/Y H:i') }}
                            @if($question->updated_at != $question->created_at)
                                | Cập nhật: {{ $question->updated_at->format('d/m/Y H:i') }}
                            @endif
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
