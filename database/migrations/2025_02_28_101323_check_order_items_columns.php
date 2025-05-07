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
        Schema::table('order_items', function (Blueprint $table) {
            // Check if columns exist, if not add them
            if (!Schema::hasColumn('order_items', 'order_id')) {
                $table->foreignId('order_id')->constrained()->onDelete('cascade');
            }
            if (!Schema::hasColumn('order_items', 'product_id')) {
                $table->foreignId('product_id')->constrained();
            }
            if (!Schema::hasColumn('order_items', 'quantity')) {
                $table->integer('quantity');
            }
            if (!Schema::hasColumn('order_items', 'price')) {
                $table->decimal('price', 10, 2);
            }
            if (!Schema::hasColumn('order_items', 'created_at')) {
                $table->timestamps();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No need for down method as we're just checking/adding columns
    }
};
