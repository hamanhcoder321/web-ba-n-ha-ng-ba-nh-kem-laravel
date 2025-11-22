@extends('layouts.admin')
@section('content')
    <h1>Danh sách đơn hàng đã duyệt</h1>

    @if($approvedCount->isEmpty())
        <p>Hiện chưa có đơn hàng nào được duyệt.</p>
    @else
        <table border="1" cellpadding="10" cellspacing="0" style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Ngày đặt</th>
                    <th>Tổng tiền</th>
                    <th>Phương thức thanh toán</th>
                    <th>Ghi chú</th>
                    <th>Trạng thái</th>
                    <th>Ngày tạo</th>
                    <th>Ngày cập nhật</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($approvedCount as $bill)
                    <tr>
                        <td>{{ $bill->id }}</td>
                        <td>{{ \Carbon\Carbon::parse($bill->date_order)->format('d/m/Y') }}</td>
                        <td>{{ number_format($bill->total, 0, ',', '.') }}₫</td>
                        <td>{{ $bill->payment }}</td>
                        <td>{{ $bill->note }}</td>
                        <td>{{ ucfirst($bill->status) }}</td>
                        <td>{{ $bill->created_at }}</td>
                        <td>{{ $bill->updated_at }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <h1>Danh sách đơn hàng đã hủy</h1>

    @if($canceledOrders->isEmpty())
        <p>Hiện chưa có đơn hàng nào được hủy.</p>
    @else
        <table border="1" cellpadding="10" cellspacing="0" style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Ngày đặt</th>
                    <th>Tổng tiền</th>
                    <th>Phương thức thanh toán</th>
                    <th>Ghi chú</th>
                    <th>Trạng thái</th>
                    <th>Ngày tạo</th>
                    <th>Ngày cập nhật</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($canceledOrders as $bill)
                    <tr>
                        <td>{{ $bill->id }}</td>
                        <td>{{ \Carbon\Carbon::parse($bill->date_order)->format('d/m/Y') }}</td>
                        <td>{{ number_format($bill->total, 0, ',', '.') }}₫</td>
                        <td>{{ $bill->payment }}</td>
                        <td>{{ $bill->note }}</td>
                        <td>{{ ucfirst($bill->status) }}</td>
                        <td>{{ $bill->created_at }}</td>
                        <td>{{ $bill->updated_at }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@endsection


