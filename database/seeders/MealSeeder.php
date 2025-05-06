<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Meal;

class MealSeeder extends Seeder
{
    /**
     * Meals based on screen-shots of Eazy Eats Instagram page.
     */
    public function run(): void
    {
        $meals = [
            [
                'title' => 'Cajun Shrimp & Turkey Sausage Pasta',
                'description' => 'Seasoned Shrimp and Turkey Sausage mixed in a Creamy Cajun Sauce. Served overtop a bed of Pasta and topped with Parmesan Cheese',
                'calories' => 750,
                'fats' => 30,
                'carbs' => 75,
                'proteins' => 40,
                'price' => 12.00,
            ],
            [
                'title' => 'Ground Turkey Tacos',
                'description' => '(2) Tacos filled with Ground Turkey, Peppers and Onions. All topped with Cheese and served with a side of Pico De Gallo and Black Beans',
                'calories' => 600,
                'fats' => 25,
                'carbs' => 50,
                'proteins' => 35,
                'price' => 10.00,
            ],
            [
                'title' => 'Eazy Start Burrito',
                'description' => 'Scrambled Eggs, Ground Turkey, Shredded Cheese and Peppers. Served in a soft Tortilla with a side of Pineapples',
                'calories' => 500,
                'fats' => 20,
                'carbs' => 40,
                'proteins' => 35,
                'price' => 7.00,
            ],
            [
                'title' => 'Bourbon Chicken',
                'description' => 'Chicken Thighs marinated in a rich Bourbon Sauce. Served with a side of Jasmine Rice and Asparagus',
                'calories' => 650,
                'fats' => 25,
                'carbs' => 50,
                'proteins' => 45,
                'price' => 10.00,
            ],
            [
                'title' => 'Chipotle Chicken Burrito Bowl',
                'description' => 'Chipotle marinated Chicken, Cilantro Lime Rice, Black Beans, Corn, fresh Pico De Gallo and Shredded Cheese',
                'calories' => 700,
                'fats' => 20,
                'carbs' => 80,
                'proteins' => 40,
                'price' => 10.00,
            ],
            [
                'title' => 'Morning Delight',
                'description' => 'Scrambled Eggs with Cheese, French Toast Sticks, and Turkey Bacon. Served with a side of Syrup',
                'calories' => 450,
                'fats' => 18,
                'carbs' => 45,
                'proteins' => 25,
                'price' => 7.00,
            ],
            [
                'title' => 'Ground Turkey Spaghetti',
                'description' => '93/7 Ground Turkey tossed in a Roasted Garlic Marinara Sauce. Served overtop Spaghetti Noodles and topped with Parmesan Cheese',
                'calories' => 700,
                'fats' => 15,
                'carbs' => 75,
                'proteins' => 45,
                'price' => 10.00,
            ],
            [
                'title' => 'Power Plate',
                'description' => '93/7 Ground Turkey mixed in a Teriyaki Sauce. Served with Jasmine Rice and Broccoli',
                'calories' => 650,
                'fats' => 20,
                'carbs' => 60,
                'proteins' => 40,
                'price' => 10.00,
            ],
            [
                'title' => 'Morning Power Muffins',
                'description' => '(2) Muffins made with Eggs, Cheese, Turkey Bacon, Spinach, and Green Peppers. Served with 2 Hash Browns',
                'calories' => 450,
                'fats' => 22,
                'carbs' => 35,
                'proteins' => 30,
                'price' => 7.00,
            ],
        ];

        foreach ($meals as $meal) {
            Meal::create($meal);
        }
    }
}
