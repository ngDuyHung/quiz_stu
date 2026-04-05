@extends('layouts.admin')

@section('title', 'Chi tiết sinh viên')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Thông tin chi tiết sinh viên</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> Chỉnh sửa
                        </a>
                        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Quay lại
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="text-center">
                                @if($user->photo)
                                    <img src="{{ asset('storage/' . $user->photo) }}" alt="Ảnh đại diện"
                                         class="img-circle elevation-2" style="width: 150px; height: 150px; object-fit: cover;">
                                @else
                                    <div class="img-circle elevation-2 d-flex align-items-center justify-content-center bg-light"
                                         style="width: 150px; height: 150px;">
                                        <i class="fas fa-user fa-3x text-muted"></i>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-9">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Mã số sinh viên:</label>
                                        <p class="form-control-plaintext">{{ $user->student_code }}</p>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Email:</label>
                                        <p class="form-control-plaintext">{{ $user->email }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Họ và tên:</label>
                                        <p class="form-control-plaintext">{{ $user->first_name }} {{ $user->last_name }}</p>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Số điện thoại:</label>
                                        <p class="form-control-plaintext">{{ $user->phone ?: 'Chưa cập nhật' }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Ngày sinh:</label>
                                        <p class="form-control-plaintext">
                                            {{ $user->birthdate ? $user->birthdate->format('d/m/Y') : 'Chưa cập nhật' }}
                                        </p>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Khoa:</label>
                                        <p class="form-control-plaintext">{{ $user->faculty ? $user->faculty->name : 'Chưa cập nhật' }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Lớp:</label>
                                        <p class="form-control-plaintext">{{ $user->schoolClass ? $user->schoolClass->id : 'Chưa cập nhật' }}</p>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Nhóm:</label>
                                        <p class="form-control-plaintext">{{ $user->userGroup ? $user->userGroup->name : 'Chưa cập nhật' }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Năm học:</label>
                                        <p class="form-control-plaintext">{{ $user->academic_year ?: 'Chưa cập nhật' }}</p>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Loại bằng:</label>
                                        <p class="form-control-plaintext">{{ $user->degree_type ?: 'Chưa cập nhật' }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Trạng thái:</label>
                                        <p class="form-control-plaintext">
                                            <span class="badge badge-{{ $user->status ? 'success' : 'danger' }}">
                                                {{ $user->status ? 'Hoạt động' : 'Không hoạt động' }}
                                            </span>
                                        </p>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Ngày tạo:</label>
                                        <p class="form-control-plaintext">{{ $user->created_at->format('d/m/Y H:i') }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Cập nhật lần cuối:</label>
                                        <p class="form-control-plaintext">{{ $user->updated_at->format('d/m/Y H:i') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection