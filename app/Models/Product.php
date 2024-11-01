<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'description',
        'price',
        'stock',
        'image',
        'expiration_date',
        'ingredients'
    ];

    /**
     * Get the category that the product belongs to.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

      /**
     * Get the user who added the product.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function cartItems()
{
    return $this->hasMany(CartItem::class);
}

}
