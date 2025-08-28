<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Test;
use App\Models\Question;
use App\Models\Answer;
use App\Models\User;

class TestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::all();

        // 3 adet test oluşturma
        Test::factory()->count(3)->create([
            'user_id' => $users->random()->id
        ])->each(function ($test) {
            // Her test için 5 soru oluşturma
            Question::factory()->count(5)->create([
                'test_id' => $test->id
            ])->each(function ($question) {
                // Her soru için 4 cevap oluşturma
                Answer::factory()->count(3)->create([
                    'question_id' => $question->id,
                    'is_correct' => false,
                ]);
                // Bir adet doğru cevap oluşturma
                Answer::factory()->create([
                    'question_id' => $question->id,
                    'is_correct' => true,
                ]);
            });
        });
    }
}
