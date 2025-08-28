<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Process_flow extends Model
{
    //
    protected $table = 'process_flow'; 

    protected $fillable = [
        'process_config_id',
        'name',
        'is_finish',
        'desc',
        'action_button',
        'is_active',
    ];

 public function config()
    {
        return $this->belongsTo(Process_Config::class);
    }

}
