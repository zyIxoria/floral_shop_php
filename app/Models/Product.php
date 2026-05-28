<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'image',
        'stock',
        'price',
        'sale_price',
        'rating',
        'review_count',
        'status',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'sale_price' => 'decimal:2',
        'rating' => 'decimal:2',
    ];

    // Relationships
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class)->orderBy('order');
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }

    // Helper methods
    public function getCurrentPrice(): float
    {
        return $this->sale_price ?? $this->price;
    }

    public function getDiscount(): ?float
    {
        if ($this->sale_price) {
            return round(((($this->price - $this->sale_price) / $this->price) * 100), 0);
        }
        return null;
    }

    public function isInStock(): bool
    {
        return $this->stock > 0;
    }

    public function isOnSale(): bool
    {
        return $this->sale_price !== null;
    }

    public function getAverageRating(): float
    {
        return $this->rating;
    }
}
