<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'title', 'image', 'description', 'price', 'create_date', 'update_date'
    ];
}
