<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'maker_id',
        'category_id',
        'name',
        'description',
        'price',
        'material',
        'production_time',
        'complexity',
        'sustainability',
        'unique_features',
        'is_approved',
        'has_external_links',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_approved' => 'boolean',
        'has_external_links' => 'boolean',
        'price' => 'decimal:2',
    ];

    /**
     * Detect if the product has external links in its text fields.
     */
    public static function detectExternalLinks(?string $text): bool
    {
        if (empty($text)) {
            return false;
        }

        $pattern = '/https?:\/\/|www\./i';

        return preg_match($pattern, $text) === 1;
    }

    /**
     * Check if the product has external links in any of its text fields.
     */
    public function checkForExternalLinks(): bool
    {
        $fieldsToCheck = [
            'description',
            'unique_features',
            'sustainability',
            'material',
        ];

        foreach ($fieldsToCheck as $field) {
            if (self::detectExternalLinks($this->{$field})) {
                return true;
            }
        }

        return false;
    }

    /**
     * Get the maker (user) that owns the product.
     */
    public function maker()
    {
        return $this->belongsTo(User::class, 'maker_id');
    }

    /**
     * Get the category that owns the product.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the orders for the product.
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Get all reviews for this product via orders.
     */
    public function reviews()
    {
        return $this->hasManyThrough(
            Review::class,
            Order::class,
            'product_id',
            'order_id',
            'id',
            'id'
        );
    }

    /**
     * Get the reports for the product.
     */
    public function reports()
    {
        return $this->hasMany(Report::class);
    }
}