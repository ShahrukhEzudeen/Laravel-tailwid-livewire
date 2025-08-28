<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('process', function (Blueprint $table) {
            $table->id();
            $table->string('flowid')->unique();
            $table->uuid('secret_key')->unique();
            $table->string('process_name');
            $table->string('process_decs');
            $table->integer('is_active')->default(1);
            $table->timestamps();
        });
        DB::unprepared('
            CREATE TRIGGER before_insert_process
            BEFORE INSERT ON process
            FOR EACH ROW
            BEGIN
                DECLARE new_id VARCHAR(10);
                REPEAT
                    SET new_id = UPPER(SUBSTRING(MD5(RAND()), 1, 10));
                UNTIL NOT EXISTS (SELECT 1 FROM process WHERE flowid = new_id)
                END REPEAT;
                SET NEW.flowid = new_id;

                -- Generate UUID for secret_key
                SET NEW.secret_key = UUID();
            END
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('process');
    }
};
