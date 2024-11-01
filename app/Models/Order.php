<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'total_price', 'status'];

    /**
     * Each order belongs to a user.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * An order can have multiple items.
     */
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * An order can have one payment.
     */
    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    /**
     * Calculate the total price of the order by summing item costs.
     *
     * @return float
     */
    public function calculateTotal()
    {
        return $this->items->sum(function ($item) {
            return $item->totalCost();
        });
    }

    /**
     * Mark the order as completed.
     *
     * @return void
     */
    public function markAsCompleted()
    {
        $this->status = 'completed';
        $this->save();
    }

    /**
     * Mark the order as pending.
     *
     * @return void
     */
    public function markAsPending()
    {
        $this->status = 'pending';
        $this->save();
    }
}
