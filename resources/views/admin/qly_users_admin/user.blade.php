@extends('layouts.admin')

@section('content')
<div class="container">

    <h2>Danh sách admin</h2>
    <a href=" {{route('admin.dashboard_5')}}">trở về trang Dashboard</a>


    {{-- FORM BULK ACTION --}}
    <form action="{{ route('admin.bulkAction') }}" method="POST" id="bulk-form">
        @csrf
        {{-- BẢNG DỮ LIỆU --}}
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th><input type="checkbox" id="checkAll"></th>
                    <th>ID</th>
                    <th>Tên</th>
                    <th>Email</th>
                    <th>Vai trò</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach($admins as $admin)
                    <tr>
                        <td><input type="checkbox" name="selected_ids[]" value="{{ $admin->id }}"></td>
                        <td>{{ $admin->id }}</td>
                        <td>{{ $admin->name }}</td>
                        <td>{{ $admin->email }}</td>
                        <td>{{ $admin->role ?? 'admin' }}</td>
                        <td>
                            <a href="{{ route('admin.editAdmin', $admin->id) }}" class="btn btn-sm btn-primary">Sửa</a>
                            <a href="{{ route('admin.deleteAdmin', $admin->id) }}" class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc muốn xoá?')">Xoá</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </form>
</div>

{{-- Script check all --}}
<script>
    document.getElementById('checkAll').addEventListener('change', function(e) {
        const checkboxes = document.querySelectorAll('input[name="selected_ids[]"]');
        checkboxes.forEach(cb => cb.checked = e.target.checked);
    });
</script>
@endsection
