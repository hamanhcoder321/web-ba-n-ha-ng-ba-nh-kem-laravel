<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductType;

class CategoryController extends Controller
{
    // Danh sách danh mục
    public function index()
    {
        $categories = ProductType::all();
        return view('admin.categories.index', compact('categories'));
    }

    // Hiển thị form thêm danh mục
    public function create()
    {
        return view('admin.categories.create');
    }

    // Lưu danh mục mới
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'description' => 'nullable|string',
        ]);

        $category = new ProductType();
        $category->name = $request->name;
        $category->description = $request->description;
        $category->save();

        return redirect()->route('admin.categories.index')->with('success', 'Thêm danh mục thành công!');
    }

    // Hiển thị form chỉnh sửa
    public function edit($id)
    {
        $category = ProductType::findOrFail($id);
        return view('admin.categories.edit', compact('category'));
    }

    // Cập nhật danh mục
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|max:255',
            'description' => 'nullable|string',
        ]);

        $category = ProductType::findOrFail($id);
        $category->name = $request->name;
        $category->description = $request->description;
        $category->save();

        return redirect()->route('admin.categories.index')->with('success', 'Cập nhật danh mục thành công!');
    }

    // Xoá danh mục
    public function destroy($id)
    {
        $category = ProductType::findOrFail($id);
        $category->delete();

        return redirect()->route('admin.categories.index')->with('success', 'Xoá danh mục thành công!');
    }
}
