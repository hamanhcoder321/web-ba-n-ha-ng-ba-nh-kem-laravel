@extends('master')

@section('content')
<div class="inner-header">
    <div class="container">
        <div class="pull-left">
            <h6 class="inner-title">Đặt hàng</h6>
        </div>
        <div class="pull-right">
            <div class="beta-breadcrumb">
                <a href="{{ route('index') }}">Home</a> / <span>Đặt hàng</span>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
</div>

<div class="container">
    <div id="content">
        @if(Session::has('thongbao'))
            <div class="alert alert-success">{{ Session::get('thongbao') }}</div>
        @endif

        <!-- FORM ĐẶT HÀNG -->
        <form action="{{ route('dathang') }}" method="POST" class="beta-form-checkout">
            @csrf
            <div class="row">
                <!-- THÔNG TIN KHÁCH HÀNG -->
                <div class="col-sm-6">
                    <h4>Thông tin khách hàng</h4>
                    <div class="space20">&nbsp;</div>

                    <div class="form-block">
                        <label>Họ tên*</label>
                        <input type="text" name="full_name" required placeholder="Nhập họ tên của bạn">
                    </div>

                    <!-- <div class="form-block">
                        <label>Giới tính</label>
                        <input type="radio" name="gender" value="Nam" checked style="width: 10%"> Nam
                        <input type="radio" name="gender" value="Nữ" style="width: 10%"> Nữ
                    </div> -->

                    <div class="form-block">
                        <label>Địa chỉ*</label>
                        <input type="text" name="address" required placeholder="Nhập địa chỉ">
                    </div>

                    <!-- <div class="form-block">
                        <label>Email*</label>
                        <input type="email" name="email" required placeholder="example@gmail.com">
                    </div> -->

                    <div class="form-block">
                        <label>Điện thoại*</label>
                        <input type="text" name="phone" required placeholder="Số điện thoại">
                    </div>

                    <div class="form-block">
                        <label>Ghi chú</label>
                        <textarea name="notes" placeholder="Ghi chú (nếu có)"></textarea>
                    </div>
                </div>

                <!-- THÔNG TIN ĐƠN HÀNG -->
                <div class="col-sm-6">
                    <div class="your-order">
                        <div class="your-order-head"><h5>Đơn hàng của bạn</h5></div>
                        <div class="your-order-body">
                            <div class="your-order-item">
                                <div>
                                    @if(Session::has('cart'))
                                        @foreach($product_cart as $cart)
                                        <div class="media">
                                            <img width="35%" src="source/image/product/{{ $cart['item']['image'] }}" alt="" class="pull-left">
                                            <div class="media-body">
                                                <p class="font-large">{{ $cart['item']['name'] }}</p>
                                                <span class="color-gray your-order-info">Số lượng: {{ $cart['qty'] }}</span>
                                                <span class="color-gray your-order-info">Đơn giá: {{ number_format($cart['price'] / $cart['qty']) }} Đồng</span>
                                            </div>
                                        </div>
                                        @endforeach
                                    @endif
                                </div>
                                <div class="clearfix"></div>
                            </div>

                            <div class="your-order-item">
                                <div class="pull-left"><p class="your-order-f18">Tổng thanh toán:</p></div>
                                <div class="pull-right">
                                    <h5 class="color-black">
                                        @if(Session::has('cart'))
                                            {{ number_format($totalPrice) }}
                                        @else
                                            0
                                        @endif
                                        Đồng
                                    </h5>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>

                        <!-- HÌNH THỨC THANH TOÁN -->
                        <div class="your-order-head"><h5>Hình thức thanh toán</h5></div>
                        <div class="your-order-body">
                            <ul class="payment_methods methods">
                                <li class="payment_method_bacs">
                                    <input id="payment_cod" type="radio" class="input-radio" name="payment_method" value="COD" checked>
                                    <label for="payment_cod">Thanh toán trực tiếp</label>
                                    <div class="payment_box payment_method_bacs" style="display: block;">
                                        Giao hàng đến nhà rồi thanh toán cho nhân viên giao hàng.
                                    </div>
                                </li>

                                <li class="payment_method_cheque">
                                    <input id="payment_atm" type="radio" class="input-radio" name="payment_method" value="ATM">
                                    <label for="payment_atm">Chuyển khoản</label>
                                    <div class="payment_box payment_method_cheque" style="display: none;">
                                        Chủ tài khoản: NGUYEN VAN A<br>
                                        Số tài khoản: 1234567890<br>
                                        Ngân hàng: Vietcombank
                                    </div>
                                </li>
                            </ul>
                        </div>

                        <!-- NÚT ĐẶT HÀNG -->
                        <div class="text-center" style="margin-top: 20px;">
                            <button type="submit" class="beta-btn primary">Đặt hàng <i class="fa fa-chevron-right"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <!-- FORM HUỶ ĐƠN (nằm ngoài form chính) -->
        <div class="text-center" style="margin-top: 30px;">
            <form action="{{ route('order.cancel') }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn huỷ đơn hàng này không?');">
                @csrf
                <button type="submit" class="beta-btn danger" style="background-color: #e74c3c; color: white;">
                    Huỷ đơn <i class="fa fa-times-circle"></i>
                </button>
            </form>
        </div>

    </div>
</div>
@endsection
