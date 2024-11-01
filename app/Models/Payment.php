<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = ['order_id', 'amount', 'status'];

    /**
     * Each payment belongs to one order.
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Mark the payment as successful.
     *
     * @return void
     */
    public function markAsSuccessful()
    {
        $this->status = 'successful';
        $this->save();
    }

    /**
     * Mark the payment as failed.
     *
     * @return void
     */
    public function markAsFailed()
    {
        $this->status = 'failed';
        $this->save();
    }
}
