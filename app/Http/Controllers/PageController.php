<?php

namespace App\Http\Controllers;
use App\Models\Slide;
use App\Models\Product;
use App\Models\ProductType;
use App\Models\Cart;
use Session;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Bill;
use App\Models\BillDetail;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{
    public function getIndex()
    {
        $slide = Slide::all();
        
        $new_product = Product::where('new',1)->paginate(4);

        $sanpham_khuyenmai = Product::where('promotion_price', '<>', 0)->paginate(8);
        
        return view('Page.trangchu',compact('slide', 'new_product', 'sanpham_khuyenmai')); 
    }
    public function getLoaiSp($type){
        $sp_theoloai = Product::where('id_type', $type)->get();
        $sp_khac = Product::where('id_type', '<>', $type)->paginate(3);
        $loai = ProductType::all();
        return view('Page.loai_sanpham', compact('sp_theoloai', 'sp_khac', 'loai'));
    }

    public function getChitiet(Request $req){ //Request $req->id lấy id sản phẩm từ request.
        $sanpham = Product::where('id', $req->id)->first(); //  Dùng where('id', $req->id)->first() để tìm sản phẩm theo ID.
        $sp_tuongtu = Product::where('id_type', $sanpham->id_type)->paginate(6);
        return view('Page.chitiet_sanpham', compact('sanpham', 'sp_tuongtu'));
    }

    public function getLienhe(){
        return view('Page.lienhe');
    }

    public function getGioithieu(){
        return view('Page.gioithieu');
    }

    // Add sản phẩm
    public function getAddtoCart(Request $req,$id){
        $product = Product::find($id);
        $oldCart = Session('cart')?Session::get('cart'):null;
        $cart = new Cart($oldCart);
        $cart->add($product, $id);
        $req->session()->put('cart', $cart);
        
         // Thêm thông báo
        session()->flash('success', 'Thêm sản phẩm vào giỏ hàng thành công!');
        return redirect()->back();
    }


    // xóa sản phẩm giỏ hàng
    public function getDelItemCart($id) {
        if (!Session::has('cart')) { // !Session::has Kiểm tra xem session có tồn tại key 'cart' hay không.
            return redirect()->back()->with('error', 'Giỏ hàng trống!');
        }
    
        $oldCart = Session::get('cart');
        if (!isset($oldCart->items[$id])) { // !isset ktra xem có sản phẩm hay không
            return redirect()->back()->with('error', 'Sản phẩm không tồn tại trong giỏ hàng!');
        }
    
        $cart = new Cart($oldCart);
        
        if ($cart->items[$id]['qty'] > 1) {
            // Trường hợp có nhiều sản phẩm cùng loại, giảm số lượng xuống 1
            $cart->reduceByOne($id);
            session()->flash('success', 'Đã xóa 1 sản phẩm khỏi giỏ hàng!');
        } else {
            // Trường hợp chỉ có 1 sản phẩm, xóa hẳn khỏi giỏ hàng
            $cart->removeItem($id);
            session()->flash('success', 'Đã xóa sản phẩm khỏi giỏ hàng!');
        }
    
        // Cập nhật giỏ hàng trong session
        if (!empty($cart->items)) { // !empty kiểm tra có dữ liệu không
            Session::put('cart', $cart);
        } else {
            Session::forget('cart');
        }
    
        return redirect()->back();
    }

    public function getCheckout(){
        if(Session('cart')){
            $oldCart = Session::get('cart');
            $cart = new Cart($oldCart);
            return view('Page.dat_hang', 
            ['product_cart'=>$cart->items, 
            'totalPrice'=>$cart->totalPrice,'totalQty'=>$cart->totalQty]);
        }

        else{
           return view('Page.dat_hang');
        }
    }

    public function postCheckout(Request $req){
    $cart = Session::get('cart');

    $customer = new Customer;
    $customer->id = $req->id;
    $customer->name = $req->full_name;
    // $customer->gender = $req->gender;
    // $customer->email = $req->email;
    $customer->address = $req->address;
    $customer->phone_number = $req->phone;
    $customer->note = $req->notes;
    $customer->save();

    $bill = new Bill;
    $bill->id_customer = $customer->id;
    $bill->date_order = date('Y-m-d');
    $bill->total = $cart->totalPrice;
    $bill->payment = $req->payment_method;
    $bill->note = $req->notes;
    $bill->status = 'chờ duyệt'; // Thêm trạng thái là 'pending'
    $bill->save();

    foreach($cart->items as $key=>$value){
        $bill_detail = new BillDetail;
        $bill_detail->id_bill = $bill->id;
        $bill_detail->id_product = $key;
        $bill_detail->quantity = $value['qty'];
        $bill_detail->unit_price = $value['price']/$value['qty'];
        $bill_detail->save();
    }

    // Session::forget('cart');
    return redirect()->back()->with('thongbao', 'Đặt hàng thành công, chờ duyệt!');
}

    public function getLogin(){
        return view('page.dangnhap');
    }
    
    public function getRegister(){
        return view('page.dangky');
    }

    public function postRegister(Request $req){
        $this->validate($req,
            [
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:6|max:20',
                'fullname' => 'required',
                're_password' => 'required|same:password',
                'address' => 'required' // thêm dòng này
            ],
            [
                'email.required' => 'Vui lòng nhập email',
                'email.email' => 'không đúng định dạng email',
                'email.unique' => 'email đã tồn tại',
                'password.required'=> 'vui lòng nhập mật khẩu',
                're_password.same'=> 'Mật khẩu không giống nhau',
                'password.min'=> 'mật khẩu ít nhất 6 kí tự',
                'address.required' => 'Vui lòng nhập địa chỉ' // thêm dòng này
            ]
        );
    
        $user = new User();
        $user->full_name = $req->fullname;
        $user->email = $req->email;
        $user->password = Hash::make($req->password);
        $user->phone = $req->phone;
        $user->address = $req->address; // gán address
        $user->save();
    
        return redirect()->back()->with('thanhcong', 'Tạo tài khoản thành công');
    }    
    
    public function postLogin(Request $req){
        $this->validate( $req,
            [
                'email'=>'required|email',
                'password'=>'required|min:6|max:20'
            ],
            [
                'email.required'=>'vui lòng nhập email',
                'email.email'=>'vui lòng nhập đúng định dạng email',
                'password.required'=>'vui lòng nhập password',
                'password.min'=>'mật khẩu ít nhất 6 kí tự',
                'password.max'=>'mật khẩu không quá 20 kí tự'
            ]
        );
        $credentials = array('email'=>$req->email,'password'=>$req->password);
        if(Auth::attempt($credentials)){
            return redirect()->route('index')->with(['flag'=>'success','message'=>'Đăng nhập thành công']);
        }else{
            return redirect()->back()->with(['flag'=>'danger','message'=>'Đăng nhập thất bại']);
        }
    }

    public function postLogout(){
        Auth::logout();
        Session::forget('cart');
        return redirect()->route('index')->with(['flag'=>'success','message'=>'Đăng nhập thành công']);
         
    }

    public function getSearch(Request $req){
        $product = Product::where('name', 'like','%'.$req->key.'%')
        ->orWhere('unit_price', $req->key)
        ->get();
        return view('page.search', compact('product'));
    }
    
}
