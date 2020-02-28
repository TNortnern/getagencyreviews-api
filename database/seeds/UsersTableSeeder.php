<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       App\User::create([
           'name' => 'John Smith',
           'email' => 'johnsmith@gmail.com',
           'password' => Hash::make(12345678),
           'phone_number' => mt_rand(10000000, 99999999)
       ]);
       factory('App\UserProfile')->create();
    }
}
