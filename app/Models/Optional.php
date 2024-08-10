<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Optional extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function meal()
    {
        return $this->belongsTo(Meal::class);
    }

    public function orderItems() {
        return $this->belongsToMany(OrderItem::class, 'orderitem_optionals', 'optional_id', 'order_item_id');
    }

}
