@extends('layouts.admin')

@section('content')
<div class="container">
    <h2>Sửa người dùng</h2>
    <form method="POST" action="{{ route('admin.user.update', $user->id) }}">
        @csrf
        <div class="form-group">
            <label>Tên</label>
            <input type="text" name="full_name" value="{{ $user->full_name }}" required>
        </div>
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
        </div>
        <button type="submit" class="btn btn-success mt-2">Cập nhật</button>
    </form>
</div>
@endsection
