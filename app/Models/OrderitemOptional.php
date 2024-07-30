<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderitemOptional extends Model
{
    use HasFactory;

    protected $table = "orderitem_optionals";

    protected $guarded = ['id'];

}
