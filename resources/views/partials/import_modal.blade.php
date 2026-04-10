<div class="modal fade" id="importModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('admin.users.import') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Import Sinh viên hàng loạt</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-info">
                        Sử dụng file mẫu để tránh lỗi định dạng. 
                        <a href="{{ route('admin.users.import-template') }}" class="fw-bold text-decoration-underline">Tải file mẫu tại đây</a>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Chọn file Excel/CSV</label>
                        <input type="file" name="file" class="form-control" accept=".xlsx, .xls, .csv" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-primary">Bắt đầu Import</button>
                </div>
            </div>
        </form>
    </div>
</div>

@if(session()->has('import_errors'))
    <div class="alert alert-danger mt-3">
      <h6>Kết quả Import:</h6>
        <p>Thành công: {{ session('success_count', 0) }} dòng.</p>

        <p>Thất bại: {{ session('failed_count', session('import_errors')->count()) }} dòng lỗi.</p>
        <ul style="max-height: 200px; overflow-y: auto;">
            @foreach(session('import_errors') as $failure)
                <li>
                    Dòng {{ $failure->row() }}: {{ implode(', ', $failure->errors()) }} 
                    <br><small class="text-muted">Dữ liệu: {{ json_encode($failure->values(), JSON_UNESCAPED_UNICODE) }}</small>
                </li>
            @endforeach
        </ul>
    </div>
@endif