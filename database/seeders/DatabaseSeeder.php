<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Doctor;
use App\Models\ForumPost;
use App\Models\Test;
use App\Models\Product;
use App\Models\DietPlan;
use App\Models\DietMeal;
use App\Models\Appointment; // Appointment modelini ekledik

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Önceki seeder'ları temizlemek için veritabanını boşaltalım (önemli)
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('users')->truncate();
        DB::table('doctors')->truncate();
        DB::table('forum_posts')->truncate();
        DB::table('tests')->truncate();
        DB::table('products')->truncate();
        DB::table('diet_plans')->truncate();
        DB::table('diet_meals')->truncate();
        DB::table('appointments')->truncate(); // Randevular için yeni tablo eklendi
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // 1. Belirli bir yönetici (admin) kullanıcısı oluşturalım.
        User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('password'),
            'is_admin' => true,
        ]);

        // 2. Belirli bir doktor (Emel Özkara) için özel bir kullanıcı hesabı ve doktor kaydı oluşturalım.
        $emelUser = User::create([
            'name' => 'Emel Özkara',
            'email' => 'emel.ozkara@saglik.com',
            'password' => Hash::make('12345678'),
            'is_admin' => false,
        ]);

        Doctor::create([
            'user_id' => $emelUser->id,
            'name' => 'Emel Özkara',
            'specialty' => 'Çocuk Sağlığı ve Hastalıkları',
        ]);

        // 3. Faker kullanarak diğer rastgele verileri oluşturalım.
        User::factory()->count(7)->create();
        Doctor::factory()->count(3)->create();
        ForumPost::factory()->count(4)->create();
        Test::factory()->count(2)->create();
        Product::factory()->count(14)->create();

        // 4. Diyet planları ve öğünler için seeder işlemini gerçekleştirelim.
        DietPlan::factory()
            ->has(DietMeal::factory()->count(4))
            ->count(10)
            ->create();

        // 5. Yeni eklenen randevuları oluşturalım.
        Appointment::factory()->count(12)->create();

        // Diğer seeder'ları da buraya çağırabilirsiniz.
        // $this->call(OtherSeederClass::class);
    }
}
