@php
    $permissions = session('admin_permissions', []);
@endphp

{{-- Debug: Hiển thị quyền (chỉ nên dùng khi phát triển) --}}

@if (Auth::guard('admins')->check())
    <nav class="navbar-default navbar-static-side" role="navigation">
        <div class="sidebar-collapse">
            <ul class="nav metismenu" id="side-menu">
                <li class="nav-header"></li>
                <li class="active">
                    <a href="index.html"><i class="fa fa-th-large"></i> 
                        <span class="nav-label">Dashboards</span> 
                        <span class="fa arrow"></span>
                    </a>
                    <ul class="nav nav-second-level">
                        @if(hasPermission('user'))
                            <li class="active"><a href="{{ route('admin.qly_users_admin.user') }}">Quản trị viên</a></li>
                        @endif

                        @if(hasPermission('cart'))
                            <li class="active"><a href="{{ route('admin.cart.index') }}">Quản lý giỏ hàng</a></li>
                        @endif

                        @if(hasPermission('categories'))
                            <li class="active"><a href="{{ route('admin.categories.index') }}">Danh mục</a></li>
                        @endif

                        @if(hasPermission('products'))
                            <li class="active"><a href="{{ route('admin.products') }}">Sản phẩm</a></li>
                        @endif

                        @if(hasPermission('approved'))
                            <li class="active"><a href="{{ route('admin.approved') }}">Thống kê</a></li>
                        @endif

                        @if(hasPermission('users'))
                            <li class="active"><a href="{{ route('admin.users') }}">quản lý người dùng</a></li>
                        @endif
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
@endif
