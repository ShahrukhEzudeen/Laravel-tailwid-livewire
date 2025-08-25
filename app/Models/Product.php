<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Product extends Model
{
    //
        protected $fillable = [
        'name', 
        'sku', 
        'cost_price', 
        'sell_price', 
        'qty_on_hand',
        'status',
        'thumbnail_path',
    ];

  public function items()
    {
        return $this->hasMany(PurchaseItem::class);
    }

      public function cat()
    {
        return $this->hasMany(Category::class);
    }
    
}
