<?php

use Illuminate\Database\Seeder;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $faker = Faker\Factory::create();
        for ($i=0; $i < 100; $i++) {
            App\User::create([
                'name' => $faker->name,
                'email' => $faker->email,
                'password' => Hash::make('password'),
                'role_id' => $faker->numberBetween(1, 4)
            ]);
        }
        for ($i=0; $i < 300; $i++) {
            App\Post::create([
                'body' => $faker->realText(120),
                'category_id' => $faker->numberBetween(1, 30),
                'user_id' => $faker->numberBetween(1, 100)
            ]);
        }
        
        for ($i=0; $i < 450; $i++) {
            App\Comment::create([
                'comment' => $faker->realText(120),
                'user_id' => $faker->numberBetween(1, 100),
                'post_id' => $faker->numberBetween(1, 300)
            ]);
        }
        for ($i=0; $i < 500; $i++) {
            App\Like::create([
                'like' => $faker->boolean($chanceOfGettingTrue = 50),
                'user_id' => $faker->numberBetween(1, 100),
                'post_id' => $faker->numberBetween(1, 300)
            ]);
        }
    }
}
