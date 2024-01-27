<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserVerifications;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends SeederHelper
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        $users = User::factory(5)->create();
        foreach ($users as $user) {
            $user->userVerifications()->createMany([
                                                       [
                                                           'phoneNumber'     => mt_rand(5000000000, 5999999999),
                                                           'eMailVerify'     => fake()->randomElement([true, false]),
                                                           'phoneVerify'     => fake()->randomElement([true, false]),
                                                           'eMailVerifyDate' => fake()->dateTime(),
                                                           'phoneVerifyDate' => fake()->dateTime(),
                                                           'lastLoginDate'   => fake()->dateTime(),
                                                           'registerDate'    => fake()->dateTime(),
                                                       ],
                                                   ]);
        }

    }
}
