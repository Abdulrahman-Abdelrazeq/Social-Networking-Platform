<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Post;
use App\Models\Comment;
use Faker\Factory;


class CommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Factory::create();
        $posts = Post::all();
        foreach($posts as $post){
            $userIds = range(0, 10);
            shuffle($userIds);

            foreach($userIds as $index => $userId){
                if($index < 3) {
                    Comment::create([
                        'user_id' => $userId,
                        'post_id' => $post->id,
                        'content' => $faker->sentence()
                    ]);
                }
            }
        }
    }
}
