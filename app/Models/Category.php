<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Category extends Model
{
     use HasFactory;
    //
       protected $fillable = [
        'code',
        'name',
        'is_active',
    ];

       public function products()
    {
        return $this->hasMany(Product::class, 'category_code', 'code');
    }
}
