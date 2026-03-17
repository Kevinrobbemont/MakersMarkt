<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    public const STATUS_PENDING = 'pending';
    public const STATUS_IN_PRODUCTION = 'in_productie';
    public const STATUS_SHIPPED = 'verzonden';
    public const STATUS_REJECTED = 'geweigerd';
    public const STATUS_COMPLETED = 'completed';
    public const STATUS_CANCELLED = 'cancelled';
    public const STATUS_IN_PROGRESS = 'in_progress';

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
     * Get the available status options.
     *
     * @return array<string, string>
     */
    public static function statusOptions(): array
    {
        return [
            self::STATUS_PENDING => 'In afwachting',
            self::STATUS_IN_PRODUCTION => 'In productie',
            self::STATUS_SHIPPED => 'Verzonden',
            self::STATUS_REJECTED => 'Geweigerd',
            self::STATUS_COMPLETED => 'Afgerond',
            self::STATUS_CANCELLED => 'Geannuleerd',
            self::STATUS_IN_PROGRESS => 'In behandeling',
        ];
    }

    /**
     * Get the human readable status label.
     */
    public function getStatusLabel(): string
    {
        return self::statusOptions()[$this->status] ?? ucfirst(str_replace('_', ' ', (string) $this->status));
    }

    /**
     * Determine whether the order is rejected.
     */
    public function isRejected(): bool
    {
        return $this->status === self::STATUS_REJECTED;
    }

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