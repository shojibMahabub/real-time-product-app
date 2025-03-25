<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name', 
        'description', 
        'price', 
        'category', 
        'image', 
        'rating_rate', 
        'rating_count'
    ];
}
