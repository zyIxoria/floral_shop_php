<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Product;
use App\Models\Category;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

// Public API Routes
Route::get('/products', function () {
    return response()->json(Product::where('status', 'active')->with('category')->get());
});

Route::get('/categories', function () {
    return response()->json(Category::withCount('products')->get());
});

Route::get('/products/{id}', function ($id) {
    $product = Product::with(['category', 'reviews.user'])->find($id);
    if (!$product) {
        return response()->json(['message' => 'Product not found'], 404);
    }
    return response()->json($product);
});

// Exchange Rate API from external source with caching (12 hours)
Route::get('/exchange-rate', function () {
    $usdRate = Cache::remember('usd_exchange_rate', 3600 * 12, function () {
        try {
            $response = Http::get('https://open.er-api.com/v6/latest/VND');
            if ($response->successful()) {
                return $response->json()['rates']['USD'] ?? 0.000041;
            }
        } catch (\Exception $e) {
            \Log::error('Exchange Rate API Error: ' . $e->getMessage());
        }
        return 0.000041; // Fallback: 1 USD = ~24,400 VND
    });

    return response()->json(['usd_rate' => $usdRate]);
});

// Authenticated User Route (Requires Sanctum tokens)
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
