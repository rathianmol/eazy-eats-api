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
        /**
         * Corresponding Seeder file exists: Database\Seeders\MealSeeder.
         * The seeder file mentioned above will populate the meals table with the necessary existing meals.
         *
         * *** NOTE ***: Upon fresh migration, or re-migration, it is crucial to run the corresponding MealSeeder file as well.
         */
        Schema::create('meals', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Meal name
            $table->text('description'); // Meal description
            $table->decimal('price', 8, 2); // Meal price
            $table->string('category')->nullable(); // Meal category (e.g., breakfast, lunch)
            $table->boolean('is_available')->default(true); // Availability status
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meals');
    }
};
