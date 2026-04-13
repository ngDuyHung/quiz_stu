<div class="modal fade" id="importModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        @php
            $importRoute = Route::has('admin.students.import') && request()->routeIs('admin.students.*') 
                           ? route('admin.students.import') 
                           : route('admin.users.import');
            $templateRoute = Route::has('admin.students.import-template') && request()->routeIs('admin.students.*') 
                             ? route('admin.students.import-template') 
                             : route('admin.users.import-template');
        @endphp
        <form action="{{ $importRoute }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Import Sinh viên hàng loạt</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-info">
                        Sử dụng file mẫu để tránh lỗi định dạng. 
                        <a href="{{ $templateRoute }}" class="fw-bold text-decoration-underline">Tải file mẫu tại đây</a>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-dark fw-bold">Chọn file Excel/CSV</label>
                        <input type="file" name="file" class="form-control" accept=".xlsx, .xls, .csv" required>
                        <small class="text-muted italic">Hỗ trợ các định dạng: .csv, .xlsx, .xls (Tối đa 10MB)</small>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy bỏ</button>
                    <button type="submit" class="btn btn-primary shadow-sm">
                        <i class="fas fa-upload me-1"></i> Bắt đầu Import
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
