<?php

use Illuminate\Database\Seeder;
use App\Follower;

class FollowerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Follower::class,200)->create();
    }
}
