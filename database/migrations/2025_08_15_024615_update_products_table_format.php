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
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn([
                'description',
                'price',
                'category',
                'image_url',
                'is_active'
            ]);
            $table->string('sku')->unique()->after('name');
            $table->decimal('cost_price', 10, 2)->after('sku');
            $table->decimal('sell_price', 10, 2)->after('cost_price');
            $table->integer('qty_on_hand')->default(0)->after('sell_price');
            $table->integer('status')->default(1)->after('qty_on_hand');
            $table->string('thumbnail_path')->nullable()->after('status');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Drop new columns
            $table->dropColumn([
                'sku',
                'cost_price',
                'sell_price',
                'qty_on_hand',
                'status',
                'thumbnail_path',
                'deleted_at'
            ]);

            // Restore old columns
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2);
            $table->string('category')->nullable();
            $table->string('image_url')->nullable();
            $table->integer('is_active')->default(1);
        });
    }
};
