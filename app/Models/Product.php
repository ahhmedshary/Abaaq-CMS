<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'category_id', 'name', 'slug', 'description', 'price', 'compare_price',
        'image', 'gallery', 'stock', 'is_featured', 'is_on_offer', 'is_published', 'sort_order',
    ];

    protected $casts = [
        'gallery' => 'array',
        'is_featured' => 'boolean',
        'is_on_offer' => 'boolean',
        'is_published' => 'boolean',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Prices are stored as integers (smallest currency unit) to avoid float rounding bugs.
    public function getPriceFormattedAttribute(): string
    {
        return number_format($this->price) . ' ' . config('store.currency_label', 'ر.س');
    }

    public function getComparePriceFormattedAttribute(): ?string
    {
        return $this->compare_price
            ? number_format($this->compare_price) . ' ' . config('store.currency_label', 'ر.س')
            : null;
    }

    public function getDiscountPercentAttribute(): ?int
    {
        if (! $this->compare_price || $this->compare_price <= $this->price) return null;
        return (int) round((($this->compare_price - $this->price) / $this->compare_price) * 100);
    }
}
