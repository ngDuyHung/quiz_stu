<form method="GET" class="row mb-3">
    <input type="text" name="keyword" placeholder="Tìm kiếm..." class="form-control col-md-3">

    <select name="faculty_id" class="form-control col-md-2">
        <option value="">Khoa</option>
        @foreach($faculties as $f)
            <option value="{{ $f->id }}">{{ $f->name }}</option>
        @endforeach
    </select>

    <button class="btn btn-primary">Lọc</button>
</form>

<table class="table table-bordered">
    <tr>
        <th>MSSV</th>
        <th>Họ tên</th>
        <th>Email</th>
        <th>Lớp</th>
        <th>Khoa</th>
        <th>Nhóm</th>
        <th>Trạng thái</th>
        <th>Action</th>
    </tr>

    @foreach($users as $u)
    <tr>
        <td>{{ $u->student_code }}</td>
        <td>{{ $u->first_name }} {{ $u->last_name }}</td>
        <td>{{ $u->email }}</td>
        <td>{{ $u->class_name }}</td>
        <td>{{ $u->faculty_name }}</td>
        <td>{{ $u->group_name }}</td>

        <td>
            <button class="btn toggle-status"
                    data-id="{{ $u->id }}">
                {{ $u->status ? 'Active' : 'Inactive' }}
            </button>
        </td>

        <td>
            <a href="{{ route('admin.users.edit', $u->id) }}">Sửa</a>
        </td>
    </tr>
    @endforeach
</table>
<script>
document.querySelectorAll('.toggle-status').forEach(btn => {
    btn.onclick = function() {
        fetch('/admin/users/toggle-status', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ id: this.dataset.id })
        })
        .then(res => res.json())
        .then(data => {
            this.innerText = data.status ? 'Active' : 'Inactive';
        });
    }
});
</script>