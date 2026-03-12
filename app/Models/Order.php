<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'product_id',
        'buyer_id',
        'status',
        'status_description',
    ];

    /**
     * Get the product that belongs to the order.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the buyer (user) that owns the order.
     */
    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    /**
     * Get the review for the order.
     */
    public function review()
    {
        return $this->hasOne(Review::class);
    }

    /**
     * Get the credit transactions for the order.
     */
    public function creditTransactions()
    {
        return $this->hasMany(CreditTransaction::class);
    }
}
