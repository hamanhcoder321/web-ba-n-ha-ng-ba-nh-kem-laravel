<?php
namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Product;
use App\Models\Admin;
use App\Models\Cart;
use App\Models\Bill;
use App\Models\ProductType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Notifiable;


class AdminController extends Controller
{
    public function dashboard()
    {
        $userCount = User::count();
        $productCount = Product::count();
        $adminCount = Admin::count(); // hoặc dùng User::where('role', 'admin')->count();
        $categoryCount = ProductType::count();
        // Đảm bảo lấy giỏ hàng từ session
        $cart = session()->get('cart', null);

        // Nếu có giỏ hàng, đếm số lượng items trong giỏ hàng
        $cartCount = $cart ? count($cart->items) : 0; 
        // đơn hàng duyệt
        $approvedCount = Bill::where('status', 'đã duyệt đơn hàng')->count();
        $canceledOrders = Bill::where('status', 'đã bị hủy')->count(); 

        return view('admin.dashboard_5', compact('userCount', 'productCount', 'adminCount', 'categoryCount', 'cartCount', 'approvedCount', 'canceledOrders'));
    }


    // Quản lý user
    public function getUsers() {
        $users = User::all();
        return view('admin.users', compact('users'));
    }

    public function deleteUser($id) {
        User::destroy($id);
        return redirect()->back()->with('success', 'Xoá user thành công!');
    }

    public function editUser($id)
    {
        $user = User::find($id);
        if (!$user) {
            return redirect()->back()->with('error', 'Người dùng không tồn tại.');
        }
        return view('admin.edit_user', compact('user'));
    }


    public function updateUser(Request $req, $id) {
        // Kiểm tra dữ liệu đầu vào
        $req->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255'
        ]);
    
        $user = User::find($id);
    
        // Kiểm tra nếu user không tồn tại
        if (!$user) {
            return redirect()->back()->with('error', 'User không tồn tại!');
        }
    
        // Cập nhật dữ liệu
        $user->full_name = $req->input('full_name');
        $user->email = $req->input('email');
        $user->save();
    
        return redirect()->route('admin.users')->with('success', 'Cập nhật user thành công!');
    }
    

    // Quản lý sản phẩm
    public function getProducts() {
        $products = Product::all();
         $type_products = ProductType::all();
        return view('admin.products', compact('products','type_products'));
    }

    public function deleteProduct($id) {
        Product::destroy($id);
        return redirect()->back()->with('success', 'Xoá sản phẩm thành công!');
    }

    public function editProduct($id) {
        $product = Product::find($id);
        return view('admin.edit_product', compact('product'));
    }

    public function updateProduct(Request $req, $id) {
        $product = Product::find($id);

    if (!$product) {
        return redirect()->route('admin.products')->with('error', 'Sản phẩm không tồn tại!');
    }

    $product->name = $req->name;    
    $product->description = $req->description;    
    $product->id_type = $req->id_type;
    $product->unit_price = $req->unit_price;
    // $product->promotion_price = $req->promotion_price;

    // Kiểm tra nếu có file ảnh mới được upload
    if ($req->hasFile('image')) {
        $image = $req->file('image');
        $imageName = time() . '_' . $image->getClientOriginalName();

        // Lưu ảnh vào thư mục public/source/image/product
        $image->move(public_path('source/image/product'), $imageName);

        // Cập nhật tên ảnh mới vào database
        $product->image = $imageName;
    }

    $product->save();

    return redirect()->route('admin.products')->with('success', 'Cập nhật sản phẩm thành công!');
    }
    public function create()
{
    $type_products = ProductType::all(); // Chú ý: đúng tên model là ProductType
    return view('admin.product.create', compact('type_products'));
}

    public function createProduct(Request $req) {
        $product = new Product();
        $product->name = $req->name;
        $product->description = $req->description;    
        $product->id_type = $req->id_type;
        $product->unit_price = $req->unit_price;
        // $product->promotion_price = $req->promotion_price;
    
        if ($req->hasFile('image')) {
            $image = $req->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
    
            $image->move(public_path('source/image/product'), $imageName);
    
            $product->image = $imageName;
        }
    
        $product->save();
    
        return redirect()->route('admin.products')->with('success', 'Thêm sản phẩm thành công!');
    }


    // login cho ADMIN
    public function showLoginForm()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::guard('admins')->attempt($credentials)) {
            $admin = Auth::guard('admins')->user();

            // Nếu cột permissions là JSON trong DB, Laravel đã tự giải mã
            $permissions = $admin->permissions ?? [];

            session(['admin_permissions' => $permissions]);

            return redirect()->route('admin.dashboard_5');
        }

        return redirect()->route('admin.login')->withErrors([
            'email' => 'Email hoặc mật khẩu không đúng hoặc bạn không có quyền truy cập.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::guard('admins')->logout(); // Đúng guard
        return redirect()->route('admin.login');
    }

    public function userList()
    {
        $admins = Admin::all();
        return view('admin.qly_users_admin.user', compact('admins'));
    }
    public function logoutAdmin(Request $request)
    {
        Auth::guard('admins')->logout(); // dùng đúng guard
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login')->with('success', 'Bạn đã đăng xuất thành công!');
    }


    // sửa, xóa, delete Admin
    
    public function getAdminUsers() {
        $admins = Admin::all(); // Lấy toàn bộ danh sách admin
        return view('admin.qly_users_admin.user', compact('admins'));
    }

    public function editAdmin($id)
    {
        
        $admins = Admin::findOrFail($id);
        $permissions = $admins->permissions ?? [];

        return view('admin.qly_users_admin.editAdmin', compact('admins', 'permissions'));
    }
    public function updateAdmin(Request $request, $id)
    {
        $admins = Admin::findOrFail($id);

        $admins->name = $request->name;
        $admins->email = $request->email;
        $admins->role = $request->role;
        $admins->permissions = $request->input('permissions', []); // Laravel tự chuyển thành JSON nếu đã cast

        $admins->save();

        return redirect()->route('admin.editAdmin', $admins->id)->with('success', 'Cập nhật thành công!');
    }

    public function deleteAdmin($id) {
        // Tìm admin theo ID. Nếu không tìm thấy, sẽ tự động báo lỗi 404.
        $admins = Admin::findOrFail($id);

        // Xóa admin tìm được khỏi cơ sở dữ liệu
        $admins->delete();

        // Chuyển hướng người dùng về trang danh sách user (admin.users)
        // và gửi kèm một thông báo thành công.
        return redirect()->route('admin.users')->with('success', 'Xoá thành công!');
    }

}
