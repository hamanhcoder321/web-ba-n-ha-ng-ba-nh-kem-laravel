@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Tổng quan quản trị</h2>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>Chào mừng, {{ Auth::guard('admins')->user()->name }} 👋</h4>
        <form action="{{ route('admin.logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-danger">Đăng xuất</button>
        </form>
    </div>

    <div class="row">
        @if (hasPermission('dashboard_5'))
            <div class="col-md-4 mb-3">
                <a href="{{ route('admin.qly_users_admin.user') }}" class="text-decoration-none">
                    <div class="card text-white bg-warning">
                        <div class="card-body">
                            <h5 class="card-title">Admin</h5>
                            <p class="card-text">{{ $adminCount }} quản trị viên</p>
                        </div>
                    </div>
                </a>
            </div>
        @endif

        @if (hasPermission('categories'))
            <div class="col-md-4 mb-3">
                <a href="{{ route('admin.categories.index') }}" class="text-decoration-none">
                    <div class="card text-white bg-warning">
                        <div class="card-body">
                            <h5 class="card-title">Danh mục</h5>
                            <p class="card-text">{{ $categoryCount }} danh mục</p>
                        </div>
                    </div>
                </a>
            </div>
        @endif

        @if (hasPermission('products'))
            <div class="col-md-4 mb-3">
                <a href="{{ route('admin.products') }}" class="text-decoration-none">
                    <div class="card text-white bg-success">
                        <div class="card-body">
                            <h5 class="card-title">Sản phẩm</h5>
                            <p class="card-text">{{ $productCount }} sản phẩm</p>
                        </div>
                    </div>
                </a>
            </div>
        @endif
        @if (hasPermission('thongke'))
            <div class="col-md-4 mb-3">
                <a href="{{ route('admin.approved') }}" class="text-decoration-none">
                    <div class="card text-white bg-success">
                        <div class="card-body">
                            <h5 class="card-title">thống kê</h5>
                            <p class="card-text">{{ $approvedCount }} duyệt đơn</p>
                            <p class="card-text">{{ $canceledOrders }} hủy đơn</p>
                        </div>
                    </div>
                </a>
            </div>
        @endif

        @if (hasPermission('orders'))
            <div class="col-md-4 mb-3">
                <a href="{{ route('admin.cart.index') }}" class="text-decoration-none">
                    <div class="card text-white bg-warning">
                        <div class="card-body">
                            <h5 class="card-title">Giỏ hàng</h5>
                            <p class="card-text">{{ $cartCount }} sản phẩm</p>
                        </div>
                    </div>
                </a>
            </div>
        @endif

        @if (hasPermission('users'))
            <div class="col-md-4 mb-3">
                <a href="{{ route('admin.users') }}" class="text-decoration-none">
                    <div class="card text-white bg-primary">
                        <div class="card-body">
                            <h5 class="card-title">Người dùng</h5>
                            <p class="card-text">{{ $userCount }} người dùng</p>
                        </div>
                    </div>
                </a>
            </div>
        @endif
    </div>
</div>

@endsection


