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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Links to the user who placed the order
            $table->json('meals'); // A JSON column to store meal IDs and quantities like {meal_id: quantity, ...}
            $table->decimal('total_price', 8, 2); // The total price of the order
            $table->enum('status', ['pending', 'in_progress', 'completed', 'cancelled'])->default('pending'); // Order status
            $table->timestamps(); // created_at and updated_at timestamps
            $table->softDeletes(); // Soft deletes: deleted_at column
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
