<?php

namespace Database\Factories;

use App\Models\Appointment;
use App\Models\User;
use App\Models\Doctor;
use Illuminate\Database\Eloquent\Factories\Factory;

class AppointmentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Appointment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            // Geçerli user_id ve doctor_id değerlerini sağlamak için var olan kullanıcı ve doktorları kullanalım
            'user_id' => User::inRandomOrder()->first()->id,
            'doctor_id' => Doctor::inRandomOrder()->first()->id,
            'appointment_date' => $this->faker->date(),
            'appointment_time' => $this->faker->time('H:i:s'),
            'description' => $this->faker->sentence,
            'is_approved' => $this->faker->boolean,
            'is_completed' => $this->faker->boolean,
        ];
    }
}
