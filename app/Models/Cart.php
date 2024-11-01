<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = ['user_id'];

    /**
     * Each cart belongs to one user.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * A cart can have multiple cart items.
     */
    public function items()
    {
        return $this->hasMany(CartItem::class);
    }

    /**
     * Add an item to the cart.
     *
     * @param int $productId
     * @param int $quantity
     * @param float $price
     * @return CartItem
     */
    public function addItem($productId, $quantity = 1, $price)
    {
        // Check if the product is already in the cart
        $cartItem = $this->items()->where('product_id', $productId)->first();

        if ($cartItem) {
            // Update the quantity if the item already exists
            $cartItem->quantity += $quantity;
            $cartItem->save(); // Save the updated quantity
        } else {
            // Create a new cart item if it does not exist
            $cartItem = $this->items()->create([
                'product_id' => $productId,
                'quantity' => $quantity,
                'price' => $price,
            ]);
        }

        return $cartItem;
    }

    /**
     * Remove an item from the cart.
     *
     * @param int $productId
     * @return bool
     */
    public function removeItem($productId)
    {
        // Delete the item with the specified product_id from the cart
        return $this->items()->where('product_id', $productId)->delete();
    }

    /**
     * Calculate the total price of items in the cart.
     *
     * @return float
     */
    public function calculateTotal()
    {
        // Calculate the total by summing the price * quantity for each item
        return $this->items->sum(function ($item) {
            return $item->price * $item->quantity;
        });
    }

    /**
     * Clear all items from the cart.
     *
     * @return void
     */
    public function clear()
    {
        // Remove all items from the cart
        $this->items()->delete();
    }
}
