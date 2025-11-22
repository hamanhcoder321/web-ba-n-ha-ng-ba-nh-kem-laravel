@extends('master')

@section('content')
<div class="inner-header">
    <div class="container">
        <div class="pull-left">
            <h6 class="inner-title">Đăng nhập quản trị</h6>
        </div>
        <div class="pull-right">
            <div class="beta-breadcrumb">
                <a href="{{ url('/') }}">Trang chủ</a> / <span>Đăng nhập Admin</span>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
</div>

<div class="container">
    <div id="content">
        <form action="{{ route('admin.login') }}" method="POST" class="beta-form-checkout">
            @csrf

            <div class="row">
                <div class="col-sm-3"></div>

                <div class="col-sm-6">
                    <h4>Đăng nhập Admin</h4>
                    <div class="space20">&nbsp;</div>

                    {{-- Hiển thị lỗi --}}
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            @foreach ($errors->all() as $error)
                                <p>{{ $error }}</p>
                            @endforeach
                        </div>
                    @endif

                    {{-- Hiển thị thông báo flash (nếu có) --}}
                    @if (session('message'))
                        <div class="alert alert-{{ session('flag', 'info') }}">
                            {{ session('message') }}
                        </div>
                    @endif

                    <div class="form-block">
                        <label for="email">Email:</label>
                        <input type="email" name="email" required>
                    </div>

                    <div class="form-block">
                        <label for="password">Mật khẩu:</label>
                        <input type="password" name="password" required>
                    </div>

                    <div class="form-block">
                        <button type="submit" class="btn btn-primary">Đăng nhập</button>
                    </div>
                </div>

                <div class="col-sm-3"></div>
            </div>
        </form>
    </div> <!-- #content -->
</div> <!-- .container -->
@endsection
