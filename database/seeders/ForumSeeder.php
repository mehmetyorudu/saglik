<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ForumPost;
use App\Models\Comment;
use App\Models\User;

class ForumSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::all();

        // 10 forum gönderisi oluşturma
        ForumPost::factory()->count(10)->create()->each(function ($post) use ($users) {
            // Her gönderi için 1-5 arası yorum oluşturma
            $users->random(rand(1, 5))->each(function ($user) use ($post) {
                Comment::factory()->create([
                    'forum_post_id' => $post->id,
                    'user_id' => $user->id,
                ]);
            });
        });
    }
}
