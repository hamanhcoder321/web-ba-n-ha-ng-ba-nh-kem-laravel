<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function cancelOrder(Request $request)
    {
        // Xóa giỏ hàng trong session
        $request->session()->forget('cart');

        // Nếu bạn lưu đơn hàng trong database, bạn có thể cập nhật trạng thái đơn là "đã hủy" ở đây

        // Thông báo hủy đơn thành công
        return redirect()->back()->with('thongbao', 'Đơn hàng đã được hủy thành công.');
    }
}

