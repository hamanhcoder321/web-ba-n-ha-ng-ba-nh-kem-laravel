@extends('layouts.admin')

@section('content')
<a href="{{ route('admin.dashboard_5') }}">← Trở về trang Dashboard</a>

<h2>Quản lý Giỏ hàng khách hàng</h2>

{{-- Thông báo thành công --}}
@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

{{-- Thông tin người đặt hàng --}}
<div class="mb-3">
    <h5>Thông tin người đặt hàng:</h5>

    @if(Auth::check())
        <p><strong>Họ tên:</strong> {{ Auth::user()->full_name }}</p>
        <p><strong>Email:</strong> {{ Auth::user()->email }}</p>

        @if(session('user_info'))
            <p><strong>Địa chỉ:</strong> {{ session('user_info.address') }}</p>
            <p><strong>Email:</strong> {{ session('user_info.email') }}</p>
        @endif

    @elseif(session()->has('user_info'))
        <p><strong>Họ tên:</strong> {{ session('user_info.full_name') }}</p>
        <p><strong>SĐT:</strong> {{ session('user_info.phone') }}</p>
    @else
        <p><em>Không có thông tin người đặt hàng.</em></p>
    @endif
</div>


{{-- Giỏ hàng --}}
@if($cart && count($cart->items) > 0)
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Tên sản phẩm</th>
                <th>Giá</th>
                <th>Số lượng</th>
                <th>Tổng</th>
            </tr>
        </thead>
        <tbody>
            @foreach($cart->items as $item)
                <tr>
                    <td>{{ $item['item']['name'] }}</td>
                    <td>{{ number_format($item['item']['unit_price'], 0, ',', '.') }}đ</td>
                    <td>{{ $item['qty'] }}</td>
                    <td>{{ number_format($item['price'], 0, ',', '.') }}đ</td>
                </tr>
            @endforeach
            <tr>
                <td colspan="2"><strong>Tổng số lượng:</strong> {{ $cart->totalQty }}</td>
                <td colspan="2">
                    <strong>Tổng tiền:</strong> {{ number_format($cart->totalPrice, 0, ',', '.') }}đ

                    {{-- Nút thao tác --}}
                    <div class="mt-2">
                        <!-- Huỷ đơn -->
                        <a href="{{ route('admin.cart.cancel', ['id' => $bill->id]) }}" class="btn btn-danger">Huỷ đơn</a>

                        <!-- Xoá giỏ hàng -->
                        <a href="{{ route('admin.cart.clear') }}" class="btn btn-danger btn-sm ml-2">Xoá giỏ hàng</a>

                        <!-- Duyệt đơn: dùng form POST -->
                        <form action="{{ route('admin.cart.approve') }}" method="GET" style="display:inline-block;">
                            @csrf
                            <button type="submit" class="btn btn-success">Duyệt đơn</button>
                        </form>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
@else
    <p>Giỏ hàng trống.</p>
@endif
@endsection
