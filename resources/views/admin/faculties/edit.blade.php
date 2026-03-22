@extends('admin.dashboard')

@section('title', 'Sửa Khoa')

@section('content')
<div style="background: white; padding: 25px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); max-width: 500px;">
    <h2>✏️ Chỉnh sửa Khoa</h2>
    <hr style="margin: 15px 0; border: 0; border-top: 1px solid #eee;">

    <form action="{{ route('admin.faculties.update', $faculty->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div style="margin-bottom: 15px;">
            <label style="display: block; margin-bottom: 5px; font-weight: bold;">Mã Khoa:</label>
            <input type="text" value="{{ $faculty->id }}" disabled style="width: 100%; padding: 10px; background: #f9f9f9; border: 1px solid #ddd; border-radius: 4px;">
        </div>

        <div style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 5px; font-weight: bold;">Tên Khoa mới:</label>
            <input type="text" name="name" value="{{ $faculty->name }}" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">
        </div>

        <button type="submit" style="padding: 10px 20px; background: #27ae60; color: white; border: none; border-radius: 4px; cursor: pointer;">Cập nhật</button>
        <a href="{{ route('admin.faculties.index') }}" style="margin-left: 10px; text-decoration: none; color: #666;">Hủy bỏ</a>
    </form>
</div>
@endsection