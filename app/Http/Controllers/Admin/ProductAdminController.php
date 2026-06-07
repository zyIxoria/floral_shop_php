<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductAdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        $products = Product::with('category')->paginate(15);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'stock' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
            'description_images' => 'required|array|min:3',
            'description_images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'description_images.required' => 'Bạn phải tải lên ít nhất 3 hình ảnh mô tả cho sản phẩm.',
            'description_images.min' => 'Bạn phải tải lên ít nhất 3 hình ảnh mô tả cho sản phẩm.',
            'description_images.*.image' => 'Mỗi tập tin mô tả phải là hình ảnh.',
            'description_images.*.mimes' => 'Hình ảnh mô tả chỉ chấp nhận jpeg, png, jpg, gif.',
            'description_images.*.max' => 'Mỗi hình ảnh mô tả không được vượt quá 2MB.',
        ]);

        $imagePath = $request->file('image')->store('products', 'public');

        $validated['slug'] = Str::slug($validated['name']);
        $validated['image'] = $imagePath;

        $product = Product::create($validated);

        if ($request->hasFile('description_images')) {
            foreach ($request->file('description_images') as $index => $file) {
                $path = $file->store('products/gallery', 'public');
                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => $path,
                    'order' => $index,
                ]);
            }
        }

        return redirect()->route('admin.products.index')
                       ->with('success', 'Product created successfully');
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'stock' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
            'description_images' => 'nullable|array',
            'description_images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'description_images.array' => 'Hình ảnh mô tả phải là một mảng.',
            'description_images.*.image' => 'Mỗi tập tin mô tả phải là hình ảnh.',
            'description_images.*.mimes' => 'Hình ảnh mô tả chỉ chấp nhận jpeg, png, jpg, gif.',
            'description_images.*.max' => 'Mỗi hình ảnh mô tả không được vượt quá 2MB.',
        ]);

        // Calculate final description images count
        $currentCount = $product->images()->count();
        $deleteCount = is_array($request->delete_images) ? count($request->delete_images) : 0;
        $uploadedCount = $request->hasFile('description_images') ? count($request->file('description_images')) : 0;
        $finalCount = $currentCount - $deleteCount + $uploadedCount;

        if ($finalCount < 3) {
            return back()->withErrors(['description_images' => 'Sản phẩm phải có ít nhất 3 hình ảnh mô tả. Hiện tại sau khi cập nhật sản phẩm chỉ có ' . $finalCount . ' hình ảnh.'])
                         ->withInput();
        }

        // Delete checked images
        if (is_array($request->delete_images) && count($request->delete_images) > 0) {
            foreach ($request->delete_images as $imgId) {
                $img = ProductImage::find($imgId);
                if ($img) {
                    \Illuminate\Support\Facades\Storage::disk('public')->delete($img->image);
                    $img->delete();
                }
            }
        }

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
            $validated['image'] = $imagePath;
        }

        $validated['slug'] = Str::slug($validated['name']);
        $product->update($validated);

        // Save new description images
        if ($request->hasFile('description_images')) {
            foreach ($request->file('description_images') as $index => $file) {
                $path = $file->store('products/gallery', 'public');
                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => $path,
                    'order' => $product->images()->count(), // Append to the end
                ]);
            }
        }

        return back()->with('success', 'Product updated successfully');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return back()->with('success', 'Product deleted successfully');
    }
}