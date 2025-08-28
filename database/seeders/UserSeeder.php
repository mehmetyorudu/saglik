<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Yönetici kullanıcı oluşturma
        User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('password'),
            'is_admin' => true,
        ]);

        // Doktor kullanıcı oluşturma
        User::create([
            'name' => 'Dr. Ahmet Yılmaz',
            'email' => 'ahmet.yilmaz@doktor.com',
            'password' => Hash::make('password'),
            'is_admin' => false,
        ]);

        // 10 normal kullanıcı oluşturma
        User::factory()->count(10)->create();
    }
}
