<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\User;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        User::create([
            'username' => $faker->firstNameMale,
            'email' => $faker->unique()->safeEmail,
            'password' => bcrypt('secret'),
            'cardnumber' => '22345678901234567890',
            'balance' => 432,
        ]);
        User::create([
            'username' => $faker->firstNameMale,
            'email' => $faker->unique()->safeEmail,
            'password' => bcrypt('secret'),
            'cardnumber' => '52345678901234567890',
            'balance' => 12,
        ]);
        User::create([
            'username' => $faker->firstNameMale,
            'email' => $faker->unique()->safeEmail,
            'password' => bcrypt('secret'),
            'cardnumber' => '22345678901234567897',
            'balance' => 0,
        ]);
        User::create([
            'username' => $faker->firstNameMale,
            'email' => $faker->unique()->safeEmail,
            'password' => bcrypt('secret'),
            'cardnumber' => '25345678901234567890',
            'balance' => 50,
        ]);
    }
}
