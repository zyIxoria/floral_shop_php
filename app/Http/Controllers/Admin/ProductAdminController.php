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
            'image' => 'required_without:image_url|nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'image_url' => 'required_without:image|nullable|url',
            'stock' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
            'description_images' => 'required_without:description_images_urls|nullable|array',
            'description_images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'description_images_urls' => 'required_without:description_images|nullable|string',
        ], [
            'description_images.required_without' => 'Bạn phải chọn tải lên ít nhất 3 hình ảnh mô tả hoặc điền link ảnh online.',
            'description_images_urls.required_without' => 'Bạn phải chọn tải lên ít nhất 3 hình ảnh mô tả hoặc điền link ảnh online.',
            'description_images.*.image' => 'Mỗi tập tin mô tả phải là hình ảnh.',
            'description_images.*.mimes' => 'Hình ảnh mô tả chỉ chấp nhận jpeg, png, jpg, gif.',
            'description_images.*.max' => 'Mỗi hình ảnh mô tả không được vượt quá 2MB.',
        ]);

        // Validate and process gallery images
        $galleryImages = [];
        if ($request->hasFile('description_images')) {
            if (count($request->file('description_images')) < 3) {
                return back()->withErrors(['description_images' => 'Bạn phải tải lên ít nhất 3 hình ảnh mô tả.'])->withInput();
            }
            foreach ($request->file('description_images') as $file) {
                $galleryImages[] = $file->store('products/gallery', 'public');
            }
        } elseif ($request->filled('description_images_urls')) {
            $urls = array_filter(array_map('trim', explode("\n", $request->input('description_images_urls'))));
            if (count($urls) < 3) {
                return back()->withErrors(['description_images_urls' => 'Bạn phải nhập ít nhất 3 đường dẫn hình ảnh mô tả.'])->withInput();
            }
            foreach ($urls as $url) {
                if (!filter_var($url, FILTER_VALIDATE_URL)) {
                    return back()->withErrors(['description_images_urls' => 'Đường dẫn hình ảnh không hợp lệ: ' . $url])->withInput();
                }
                $galleryImages[] = $url;
            }
        } else {
            return back()->withErrors(['description_images' => 'Bạn phải chọn tải lên hình ảnh hoặc điền link ảnh online.'])->withInput();
        }

        // Handle main image
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        } else {
            $imagePath = $request->input('image_url');
        }

        $validated['slug'] = Str::slug($validated['name']);
        $validated['image'] = $imagePath;

        // Strip validation variables not present in DB
        unset($validated['image_url']);
        unset($validated['description_images_urls']);

        $product = Product::create($validated);

        // Store gallery images
        foreach ($galleryImages as $index => $path) {
            ProductImage::create([
                'product_id' => $product->id,
                'image' => $path,
                'order' => $index,
            ]);
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
            'image_url' => 'nullable|url',
            'stock' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
            'description_images' => 'nullable|array',
            'description_images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'description_images_urls' => 'nullable|string',
        ], [
            'description_images.array' => 'Hình ảnh mô tả phải là một mảng.',
            'description_images.*.image' => 'Mỗi tập tin mô tả phải là hình ảnh.',
            'description_images.*.mimes' => 'Hình ảnh mô tả chỉ chấp nhận jpeg, png, jpg, gif.',
            'description_images.*.max' => 'Mỗi hình ảnh mô tả không được vượt quá 2MB.',
        ]);

        // Process new gallery images
        $newGalleryImages = [];
        if ($request->hasFile('description_images')) {
            foreach ($request->file('description_images') as $file) {
                $newGalleryImages[] = $file->store('products/gallery', 'public');
            }
        }
        if ($request->filled('description_images_urls')) {
            $urls = array_filter(array_map('trim', explode("\n", $request->input('description_images_urls'))));
            foreach ($urls as $url) {
                if (!filter_var($url, FILTER_VALIDATE_URL)) {
                    return back()->withErrors(['description_images_urls' => 'Đường dẫn hình ảnh không hợp lệ: ' . $url])->withInput();
                }
                $newGalleryImages[] = $url;
            }
        }

        // Calculate final description images count
        $currentCount = $product->images()->count();
        $deleteCount = is_array($request->delete_images) ? count($request->delete_images) : 0;
        $uploadedCount = count($newGalleryImages);
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
                    if (!Str::startsWith($img->image, ['http://', 'https://'])) {
                        \Illuminate\Support\Facades\Storage::disk('public')->delete($img->image);
                    }
                    $img->delete();
                }
            }
        }

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
            $validated['image'] = $imagePath;
        } elseif ($request->filled('image_url')) {
            $validated['image'] = $request->input('image_url');
        }

        $validated['slug'] = Str::slug($validated['name']);
        
        // Strip validation variables not present in DB
        unset($validated['image_url']);
        unset($validated['description_images_urls']);

        $product->update($validated);

        // Save new description images
        foreach ($newGalleryImages as $index => $path) {
            ProductImage::create([
                'product_id' => $product->id,
                'image' => $path,
                'order' => $product->images()->count(), // Append to the end
            ]);
        }

        return back()->with('success', 'Product updated successfully');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return back()->with('success', 'Product deleted successfully');
    }
}