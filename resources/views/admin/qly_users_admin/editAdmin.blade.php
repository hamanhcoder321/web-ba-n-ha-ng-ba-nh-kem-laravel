@extends('layouts.admin')

@section('content')
<div class="container">
    <h2>Sửa Admin: {{ $admins->name }}</h2>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form method="POST" action="{{ route('admin.updateAdmin', $admins->id) }}">
        @csrf
        <div class="form-group">
            <label>Tên</label>
            <input type="text" name="name" class="form-control" value="{{ $admins->name }}" required>
        </div>

        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="{{ $admins->email }}" required>
        </div>

        <div class="form-group">
            <label>Phân quyền</label>
            <select name="role" class="form-control" required id="roleSelect">
                <option value="admin" {{ $admins->role === 'admin' ? 'selected' : '' }}>Admin (Toàn quyền)</option>
                <option value="super_admin" {{ $admins->role === 'super_admin' ? 'selected' : '' }}>Super Admin (Quản lý nhiều cấp)</option>
                <option value="operator" {{ $admins->role === 'operator' ? 'selected' : '' }}>Operator (Hạn chế)</option>
            </select>
        </div>

        <div class="form-group mt-3" id="menuPermissionSection">
            <label>Cấp quyền menu sidebar:</label>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="permissions[]" value="user"
                        {{ in_array('user', $permissions ?? []) ? 'checked' : '' }}>
                    <label class="form-check-label">Quản trị viên</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="permissions[]" value="cart"
                        {{ in_array('cart', $permissions ?? []) ? 'checked' : '' }}>
                    <label class="form-check-label">Quản lý giỏ hàng</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="permissions[]" value="categories"
                        {{ in_array('categories', $permissions ?? []) ? 'checked' : '' }}>
                    <label class="form-check-label">Danh mục</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="permissions[]" value="products"
                        {{ in_array('products', $permissions ?? []) ? 'checked' : '' }}>
                    <label class="form-check-label">Sản phẩm</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="permissions[]" value="approved"
                        {{ in_array('approved', $permissions ?? []) ? 'checked' : '' }}>
                    <label class="form-check-label">Thống kê</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="permissions[]" value="users"
                        {{ in_array('users', $permissions ?? []) ? 'checked' : '' }}>
                    <label class="form-check-label">quản lý người dùng</label>
                </div>

            <!-- Bạn có thể thêm các mục khác tùy ý -->
        </div>


        <button type="submit" class="btn btn-success mt-2">Cập nhật</button>
    </form>
</div>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const roleSelect = document.getElementById('roleSelect');
        const permissionSection = document.getElementById('menuPermissionSection');

        function togglePermissionSection() {
            const role = roleSelect.value;

            // Cho phép chỉnh nếu là super_admin hoặc operator
            if (role === 'super_admin' || role === 'operator') {
                permissionSection.classList.remove('permission-disabled');
            } else {
                permissionSection.classList.add('permission-disabled');
            }

            permissionSection.style.display = 'block'; 
        }

        roleSelect.addEventListener('change', togglePermissionSection);
        togglePermissionSection();
    });
</script>

@endpush

