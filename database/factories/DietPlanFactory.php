<?php

namespace Database\Factories;

use App\Models\DietPlan;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Doctor;

class DietPlanFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = DietPlan::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'doctor_id' => Doctor::factory(),
            'user_id' => User::factory(),
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'start_date' => $this->faker->date,
            'end_date' => $this->faker->date,
            'is_template' => $this->faker->boolean,
            'target_calories' => $this->faker->numberBetween(1500, 3000),
            'status' => $this->faker->randomElement(['draft', 'active', 'archived']),
        ];
    }
}
