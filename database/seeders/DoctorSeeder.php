<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Doctor;
use App\Models\User;
use Faker\Factory as Faker;

class DoctorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('tr_TR');

        // Daha önce oluşturulan doktor kullanıcısını bul
        $doctorUser = User::where('email', 'ahmet.yilmaz@doktor.com')->first();
        if ($doctorUser) {
            Doctor::create([
                'user_id' => $doctorUser->id,
                'name' => $doctorUser->name, // Bu satırı ekledik
                'specialty' => 'Kardiyoloji',
            ]);
        }

        // Rastgele 2 doktor daha oluştur ve kullanıcılarla eşleştir
        User::factory()->count(2)->create()->each(function ($user) use ($faker) {
            Doctor::factory()->create([
                'user_id' => $user->id,
                'name' => $faker->name, // Bu satırı ekledik
                'specialty' => $faker->jobTitle,
            ]);
        });
    }
}
