<?php

namespace Database\Factories;

use App\Models\DietMeal;
use Illuminate\Database\Eloquent\Factories\Factory;

class DietMealFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = DietMeal::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->word,
            'notes' => $this->faker->paragraph, // 'description' sütunu 'notes' olarak güncellendi.
            'meal_type' => $this->faker->randomElement(['breakfast', 'snack', 'lunch', 'snack2', 'dinner', 'supper', 'other']),
        ];
    }
}
