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
       DB::table('users')->insert([
           'name' => 'John Smith',
           'email' => 'johnsmith@gmail.com',
           'password' => Hash::make(12345678)
       ]);
       Db::table('agents')->insert([
        'user' => 1
       ]);
    }
}
