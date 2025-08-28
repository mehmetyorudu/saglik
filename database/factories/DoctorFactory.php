<?php

namespace Database\Factories;

use App\Models\Doctor;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

class DoctorFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Doctor::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::factory(), // Yeni bir kullanıcı oluştur ve kimliğini kullan
            'name' => $this->faker->name,
            'specialty' => $this->faker->jobTitle,
        ];
    }
}
