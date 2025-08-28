<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Process extends Model
{
    //
    protected $table = 'process';
        protected $fillable = [
        'process_name', 
        'process_decs', 
        'is_active', 
    ];

    public function configs()
    {
        return $this->hasMany(Process_Config::class);
    }

}


