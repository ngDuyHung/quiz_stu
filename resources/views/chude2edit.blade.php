<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sửa User</title>
</head>
<body>

<h2>Sửa user</h2>

<form action="/chude2/{{$user->id}}" method="POST">

    @csrf
    @method('PUT')

    <div>
        <label>Name:</label>
        <input type="text" name="name" value="{{$user->name}}">
    </div>

    <br>

    <div>
        <label>Email:</label>
        <input type="email" name="email" value="{{$user->email}}">
    </div>

    <br>

    <button type="submit">Cập nhật</button>

</form>

<br>

<a href="/chude2">Quay lại danh sách</a>

</body>
</html>