<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
    
        Schema::create('application', function (Blueprint $table) {
            $table->id();
             $table->foreignId('application_flow_id')->constrained('application_flow')->onDelete('cascade');
             $table->foreignId('process_config_id')->constrained('process_config')->onDelete('cascade');
            $table->timestamps();
        });
   
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('application');
    }
};
