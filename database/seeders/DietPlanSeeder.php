<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DietPlan;
use App\Models\Doctor;
use App\Models\User;

class DietPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::all();
        $doctors = Doctor::all();

        if ($users->isEmpty() || $doctors->isEmpty()) {
            return;
        }

        DietPlan::factory()->count(5)->create([
            'user_id' => $users->random()->id,
            'doctor_id' => $doctors->random()->id,
        ]);
    }
}
