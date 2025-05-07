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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->string('type'); // 'order', 'product', 'status', etc.
            $table->string('title');
            $table->text('message');
            $table->text('data')->nullable(); // JSON data
            $table->string('icon')->default('info'); // Material icon name
            $table->string('color')->default('blue'); // Color for the notification
            $table->string('link')->nullable(); // Where clicking the notification leads
            $table->boolean('is_read')->default(false);
            $table->boolean('is_admin')->default(false); // Whether it's for admin
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
