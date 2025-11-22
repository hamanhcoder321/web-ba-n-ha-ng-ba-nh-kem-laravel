@extends('layouts.admin')

@section('content')
<div class="container">
    <h2>Danh sách người dùng</h2>
    <a href=" {{route('admin.dashboard_5')}}">trở về trang Dashboard</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên</th>
                <th>Email</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->full_name }}</td>
                <td>{{ $user->email }}</td>
                <td>
                    <a href="{{ route('admin.user.edit', $user->id) }}" class="btn btn-sm btn-primary">Sửa</a>
                    <a href="{{ route('admin.user.delete', $user->id) }}" class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc muốn xoá?')">Xoá</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
