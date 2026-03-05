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
        'material',
        'production_time',
        'complexity',
        'sustainability',
        'unique_features',
        'is_approved',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_approved' => 'boolean',
    ];

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
     * Get the reports for the product.
     */
    public function reports()
    {
        return $this->hasMany(Report::class);
    }
}
