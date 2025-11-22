@extends('layouts.admin')

@section('content')
<div class="container">
    <h2>Sửa sản phẩm</h2>
    <form method="POST" action="{{ route('admin.product.update', $product->id) }}" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label>Tên sản phẩm</label>
            <input type="text" name="name" class="form-control" value="{{ $product->name }}" required>
        </div>
        <div class="form-group">
            <label>Mô tả sản phẩm</label>
            <textarea name="description" class="form-control" rows="4">{{ $product->description }}</textarea>
        </div>
        <div class="form-group">
            <label>Giá gốc</label>
            <input type="number" name="unit_price" class="form-control" value="{{ $product->unit_price }}" required>
        </div>
        <!-- <div class="form-group">
            <label>Giá khuyến mãi</label>
            <input type="number" name="promotion_price" class="form-control" value="{{ $product->promotion_price }}">
        </div> -->
        <div class="form-group">
            <label>Ảnh sản phẩm</label>
            <input type="file" name="image" class="form-control">
            @if($product->image)
                <p>Ảnh hiện tại:</p>
                <img src="{{ asset('source/image/product/' . $product->image) }}" alt="Product Image" width="100">
            @endif
        </div>
        <button type="submit" class="btn btn-success mt-2">Cập nhật</button>
    </form>
</div>
@endsection
