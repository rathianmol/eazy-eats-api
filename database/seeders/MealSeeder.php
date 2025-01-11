<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Meal;

class MealSeeder extends Seeder
{
    /**
     * Meals based on screen-shots of Eazy Eats instagram page.
     */
    public function run(): void
    {
        $meals = [
            [
                'name' => 'Cajun Shrimp & Turkey Sausage Pasta',
                'description' => 'Seasoned Shrimp and Turkey Sausage mixed in a Creamy Cajun Sauce. Served overtop a bed of Pasta and topped with Parmesan Cheese',
                'price' => 12.00,
                'category' => 'lunch',
                'is_available' => true,
            ],
            [
                'name' => 'Ground Turkey Tacos',
                'description' => '(2) Tacos filled with Ground Turkey, Peppers and Onions. All topped with Cheese and served with a side of Pico De Gallo and Black Beans',
                'price' => 10.00,
                'category' => 'lunch',
                'is_available' => true,
            ],
            [
                'name' => 'Eazy Start Burrito',
                'description' => 'Scrambled Eggs, Ground Turkey, Shredded Cheese and Peppers. Served in a soft Tortilla with a side of Pineapples',
                'price' => 7.00,
                'category' => 'breakfast',
                'is_available' => true,
            ],
            [
                'name' => 'Bourbon Chicken',
                'description' => 'Chicken Thighs marinated in a rich Bourbon Sauce. Served with a side of Jasmine Rice and Asparagus',
                'price' => 10.00,
                'category' => 'lunch',
                'is_available' => true,
            ],
            [
                'name' => 'Chipotle Chicken Burrito Bowl',
                'description' => 'Chipotle marinated Chicken, Cilantro Lime Rice, Black Beans, Corn, fresh Pico De Gallo and Shredded Cheese',
                'price' => 10.00,
                'category' => 'lunch',
                'is_available' => true,
            ],
            [
                'name' => 'Morning Delight',
                'description' => 'Scrambled Eggs with Cheese, French Toast Sticks, and Turkey Bacon. Served with a side of Syrup',
                'price' => 7.00,
                'category' => 'breakfast',
                'is_available' => true,
            ],
            [
                'name' => 'Ground Turkey Spaghetti',
                'description' => '93/7 Ground Turkey tossed in a Roasted Garlic Marinara Sauce. Served overtop Spaghetti Noodles and topped with Parmesan Cheese',
                'price' => 10.00,
                'category' => 'lunch',
                'is_available' => true,
            ],
            [
                'name' => 'Power Plate',
                'description' => '93/7 Ground Turkey mixed in a Teriyaki Sauce. Served with Jasmine Rice and Broccoli',
                'price' => 10.00,
                'category' => 'lunch',
                'is_available' => true,
            ],
            [
                'name' => 'Morning Power Muffins',
                'description' => '(2) Muffins made with Eggs, Cheese, Turkey Bacon, Spinach and Green Peppers. Served with 2 Hash Browns',
                'price' => 7.00,
                'category' => 'breakfast',
                'is_available' => true,
            ],
        ];

        foreach ($meals as $meal) {
            Meal::create($meal);
        }
    }
}
