<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
   
    public function index()
    {
        $categories = Category::withCount('posts')->get();
        return view('admin.categories.index', compact('categories'));
    }

   
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:categories,name|max:255',
        ]);

        Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        return back()->with('success', 'Đã thêm chuyên mục mới!');
    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    
    public function update(Request $request, Category $category)
    {
        $request->validate([
            // Tên bắt buộc, không trùng (nhưng trừ chính nó ra)
            'name' => 'required|max:255|unique:categories,name,' . $category->id,
        ]);

        $category->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name), // Cập nhật luôn slug mới
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Đã cập nhật tên chuyên mục!');
    }

   
    public function destroy(Category $category)
    {
        // Nếu chuyên mục có bài viết thì không cho xóa để tránh lỗi
        if ($category->posts()->count() > 0) {
            return back()->withErrors(['error' => 'Không thể xóa chuyên mục này vì đang có bài viết!']);
        }

        $category->delete();
        return back()->with('success', 'Đã xóa chuyên mục.');
    }
}