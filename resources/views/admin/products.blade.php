@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4 font-weight-bold">📦 Danh sách sản phẩm</h2>
    
    <a href=" {{route('admin.dashboard_5')}}">trở về trang Dashboard</a>

        <div class="table-responsive shadow-sm rounded">
            <table class="table table-striped table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">#ID</th>
                        <th scope="col">Tên sản phẩm</th>
                        <th scope="col">Ảnh</th>
                        <th scope="col">Giá</th>
                        <th scope="col">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $p)
                    <tr>
                        <td>{{ $p->id }}</td>
                        <td>{{ $p->name }}</td>
                        <td>
                            @if($p->image)
                                <img src="{{ asset('source/image/product/' . $p->image) }}" width="60" height="60" style="object-fit: cover;">
                            @else
                                <span class="text-muted">Không có ảnh</span>
                            @endif
                        </td>
                        <td>{{ number_format($p->unit_price) }} đ</td>
                        <td>
                            <a href="{{ route('admin.product.edit', $p->id) }}" class="btn btn-sm btn-warning">Sửa</a>
                            <a href="{{ route('admin.product.delete', $p->id) }}" class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc muốn xoá?')">Xoá</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    <form method="POST" action="{{ route('admin.product.create') }}" enctype="multipart/form-data" class="mb-4 p-3 bg-light rounded shadow-sm">
            @csrf
            <div class="form-row">
                <div class="col-md-3 mb-2">
                    <input type="text" name="name" class="form-control" placeholder="Tên sản phẩm" required>
                </div>
                <div class="col-md-2 mb-2">
                    <select name="id_type" class="form-control" required>
                        @foreach($type_products as $type)
                            <option value="{{ $type->id }}">{{ $type->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 mb-2">
                    <textarea name="description" id=""></textarea>
                </div>
                <div class="col-md-2 mb-2">
                    <input type="number" name="unit_price" class="form-control" placeholder="Giá sản phẩm" required>
                </div>
                <!-- <div class="col-md-2 mb-2">
                    <input type="number" name="promotion_price" class="form-control" placeholder="Giá khuyến mãi">
                </div> -->
                <div class="col-md-3 mb-2">
                    <input type="file" name="image" class="form-control-file">
                </div>
                <div class="col-md-2 mb-2">
                    <button type="submit" class="btn btn-success btn-block">+ Thêm sản phẩm</button>
                </div>
            </div>
        </form>
</div>
@endsection
