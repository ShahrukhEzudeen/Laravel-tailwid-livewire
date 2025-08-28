<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    //

      protected $table = 'application';
        protected $fillable = [
        'process_config_id', 
        'is_active', 
    ];

    public function appflow()
    {
        return $this->hasMany(Application_Flow::class,'application_id');
    }

     public function config()
    {
        return $this->belongsTo(Process_config::class,'process_config_id');
    }
}
