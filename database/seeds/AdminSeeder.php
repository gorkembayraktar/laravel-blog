<?php

use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       DB::table('admins')->insert([
        'name' => 'Görkem Bayraktar',
        'email' => 'gorkembayraktar@gmail.com',
        'password' => bcrypt(124214214)
       ]);
    }
}
