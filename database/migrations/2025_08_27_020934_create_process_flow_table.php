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
        Schema::create('process_flow', function (Blueprint $table) {
            $table->id();
            $table->foreignId('process_config_id')->constrained('process_config')->onDelete('cascade');
            $table->string('name');
            $table->integer('is_finish');
            $table->string('desc');
            $table->json('action_button');
             $table->integer('is_active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('process_flow');
    }
};
