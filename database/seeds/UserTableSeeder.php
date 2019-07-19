<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Post;
use App\PostReply;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(User::class,50)->create()->each(function($user){
        	$user->posts()->saveMany(factory(Post::class, rand(5,15))->create()->each(function($post){
                $post->replies()->saveMany(factory(PostReply::class, rand(5,15))->make());
            })->make());

            $user->following()->saveMany(factory(App\Follower::class,rand(10,30)))->make();
        });
    }
}
