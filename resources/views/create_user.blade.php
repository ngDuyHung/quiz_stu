<h2>Thêm người dùng mới</h2>
<form action="{{ route('user.store') }}" method="POST">
        @csrf
    <div>
        <label>Name:</label>
        <input type="text" name="name" required>
    </div>
    <div>
        <label>Email:</label>
        <input type="email" name="email" required>
    </div>
    <div>
        <label>Password:</label>
        <input type="password" name="password" required>
    </div>
    <button type="submit">Lưu người dùng</button>
</form>