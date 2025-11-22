<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Trạng thái đơn hàng</title>
</head>
<body>
    <h2>Xin chào Bạn!</h2>

    @if ($bill->status === 'approved')
        <p>Đơn hàng của bạn đã được <strong>duyệt thành công</strong>.</p>
    @elseif ($bill->status === 'approved')
        <p>Đơn hàng của bạn đã <strong>bị huỷ</strong>.</p>
    @else
        <p>Đơn hàng của bạn đang ở trạng thái: <strong>{{ $bill->status }}</strong>.</p>
    @endif

    <h4>Thông tin đơn hàng:</h4>
    <ul>
        <li>Mã đơn hàng: {{ $bill->id }}</li>
        <li>Ngày đặt: {{ $bill->date_order }}</li>
        <li>Tổng tiền: {{ number_format($bill->total, 0, ',', '.') }} VND</li>
        <li>Phương thức thanh toán: {{ $bill->payment }}</li>
        <li>Ghi chú: {{ $bill->note }}</li>
    </ul>

    <p>Cảm ơn bạn đã sử dụng dịch vụ của chúng tôi!</p>
</body>
</html>
