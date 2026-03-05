<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'product_id',
        'reported_by',
        'reason',
    ];

    /**
     * Get the product that belongs to the report.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the user that reported the product.
     */
    public function reporter()
    {
        return $this->belongsTo(User::class, 'reported_by');
    }
}
