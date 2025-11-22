@extends('layouts.admin')

@section('content')
<div class="container">
    <h2>Thêm danh mục mới</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.categories.store' ) }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Tên danh mục:</label>
            <input type="text" name="name" class="form-control" placeholder="Nhập tên danh mục" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Mô tả:</label>
            <textarea name="description" class="form-control" rows="4" placeholder="Mô tả chi tiết (tuỳ chọn)"></textarea>
        </div>
        <button type="submit" class="btn btn-success">Thêm</button>
        <!-- Sửa lại liên kết Quay lại -->
        <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Quay lại</a>
    </form>
</div>
@endsection
