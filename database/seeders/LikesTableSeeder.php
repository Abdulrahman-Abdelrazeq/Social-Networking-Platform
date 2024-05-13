<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Post;
use App\Models\Like;

class LikesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $posts = Post::all();
        foreach ($posts as $post) {
            $userIds = range(1, 10);
            shuffle($userIds); // Shuffle user IDs for random likes

            foreach ($userIds as $index => $userId) {
                if ($index < 3) { // Create 3 likes per post
                    Like::create([
                        'user_id' => $userId,
                        'post_id' => $post->id,
                    ]);
                }
            }
        }
    }
}
