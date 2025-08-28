<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Application_Flow extends Model
{
     protected $table = 'application_flow';
        protected $fillable = [
        'process_config_id', 
        'application_id', 
        'user_id', 
    ];

    public function application()
    {
        return $this->belongsTo(Application::class);
    }

     public function config()
    {
        return $this->belongsTo(Process_config::class);
    }




}
