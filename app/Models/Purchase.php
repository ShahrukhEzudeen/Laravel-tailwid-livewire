<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Purchase extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'invoice_no',
        'purchase_date',
        'total_cost',
        'status',
    ];

    public function items()
    {
        return $this->hasMany(PurchaseItem::class);
    }
}
