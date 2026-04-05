@extends('layouts.admin') {{-- Hoặc tên file layout bạn Duy đặt --}}

@section('title', 'Quản lý Khoa')

@section('content')
<div style="background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
    <h2 style="margin-bottom: 20px;">🏢 Danh sách Khoa</h2>

    @if(session('success'))
        <div style="color: green; margin-bottom: 15px; font-weight: bold;">{{ session('success') }}</div>
    @endif

    <div style="margin-bottom: 30px; padding-bottom: 20px; border-bottom: 1px solid #eee;">
        <form action="{{ route('admin.faculties.store') }}" method="POST">
            @csrf
            <input type="text" name="id" placeholder="Mã khoa (VD: CNTT)" required style="padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
            <input type="text" name="name" placeholder="Tên khoa" required style="padding: 8px; border: 1px solid #ddd; border-radius: 4px; width: 250px;">
            <button type="submit" style="padding: 8px 15px; background: #3498db; color: white; border: none; border-radius: 4px; cursor: pointer;">➕ Thêm mới</button>
        </form>
    </div>

    <table border="1" width="100%" style="border-collapse: collapse; text-align: left;">
        <thead style="background: #f8f9fa;">
            <tr>
                <th style="padding: 12px; border: 1px solid #ddd;">Mã Khoa</th>
                <th style="padding: 12px; border: 1px solid #ddd;">Tên Khoa</th>
                <th style="padding: 12px; border: 1px solid #ddd; text-align: center;">Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($faculties as $faculty)
            <tr>
                <td style="padding: 12px; border: 1px solid #ddd;"><strong>{{ $faculty->id }}</strong></td>
                <td style="padding: 12px; border: 1px solid #ddd;">{{ $faculty->name }}</td>
                <td style="padding: 12px; border: 1px solid #ddd; text-align: center;">
                    <a href="{{ route('admin.faculties.edit', $faculty->id) }}" style="color: orange; text-decoration: none; margin-right: 10px;">Sửa</a>
                    <form action="{{ route('admin.faculties.destroy', $faculty->id) }}" method="POST" style="display:inline;">
                        @csrf @method('DELETE')
                        <button type="submit" onclick="return confirm('Xóa thật không?')" style="color: red; border: none; background: none; cursor: pointer;">Xóa</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
>>>>>>> b87d2df6076e3f60e1d227967b848754b06c76b2
@endsection