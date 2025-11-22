<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderApproved;
use Illuminate\Http\Request;
use App\Models\Cart; // 
use Illuminate\Support\Facades\Auth; 
use App\Models\Bill;
use App\Models\BillDetail;

class CartController extends Controller
{
    public function index()
{
    $cart = session('cart');

    // Giả sử chỉ lấy đơn gần nhất (hoặc sửa logic tùy bạn)
    $bill = Bill::latest()->first();

    return view('admin.cart.index', [
        'cart' => $cart,
        'bill' => $bill, // TRUYỀN BIẾN bills
    ]);
}

    public function clear()
    {
        session()->forget('cart'); // Xóa giỏ hàng khỏi session
        return redirect()->back()->with('success', 'Đã xoá toàn bộ giỏ hàng!');
    }

    // Thêm phương thức cancel vào controller của bạn


   public function canceledOrders($id)
{
    $bill = Bill::find($id);

    if (!$bill) {
        return redirect()->back()->with('error', 'Không tìm thấy đơn hàng.');
    }

    if ($bill->status === 'huy') {
        return redirect()->back()->with('info', 'Đơn hàng đã được huỷ trước đó.');
    }

    $bill->note = 'Đơn hàng đã bị hủy';
    $bill->status = 'đã bị hủy'; // Đổi trạng thái
    $bill->save();

    
    // Gửi email thông báo hủy
    Mail::to(Auth::user()->email)->send(new \App\Mail\OrderCanceled($bill));
    
    session()->forget('cart');
    
    return redirect()->back()->with('success', 'Đơn hàng không được chấp nhận.');
}

public function approvedCount()
{
    $oldCart = session('cart');
    if (!$oldCart) {
        return redirect()->back()->with('error', 'Không có giỏ hàng để duyệt.');
    }

    $cart = new \App\Models\Cart($oldCart);

    // Tạo đơn hàng mới
    $bill = new Bill();
    $bill->date_order = now();
    $bill->total = $cart->totalPrice;
    $bill->payment = 'COD';
    $bill->note = 'Đơn hàng duyệt thủ công';
    $bill->status = 'đã duyệt đơn hàng';

    // Nếu muốn lưu email người đặt hàng
    $bill->save();

    // Gửi email xác nhận
    Mail::to(Auth::user()->email)->send(new OrderApproved($bill));

    // Xóa giỏ hàng sau khi duyệt
    session()->forget('cart');

    return redirect()->route('admin.cart.index')->with('success', 'Đã duyệt đơn hàng thành công.');
}

public function approvedOrders()
{
    $approvedCount = Bill::where('status', 'đã duyệt đơn hàng')
        ->orderBy('date_order', 'desc')
        ->orderBy('created_at', 'desc')
        ->get();

    $canceledOrders = Bill::where('status', 'đã bị hủy')
        ->orderBy('date_order', 'desc')
        ->orderBy('created_at', 'desc')
        ->get();

    return view('admin.approved', compact('approvedCount', 'canceledOrders'));
}




}
