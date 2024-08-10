<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function meal()
    {
        return $this->belongsTo(Meal::class);
    }

    public function optional() {
        return $this->belongsToMany(Optional::class, 'orderitem_optionals' , 'order_item_id' , 'optional_id');
    }
}
