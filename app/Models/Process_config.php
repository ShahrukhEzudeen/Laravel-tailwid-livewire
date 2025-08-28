<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Process_config extends Model
{
    //
      protected $table = 'process_config'; 
      protected $fillable = [
        'process_id',
        'is_multiple',
        'sequence',
        'name',
        'desc',
        'is_complete',
    ];

     public function process()
    {
        return $this->belongsTo(Process::class);
    }

      public function flows()
    {
        return $this->hasMany(Process_flow::class,'process_config_id');
    }
}
