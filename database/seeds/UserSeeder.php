<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=1; $i < 40; $i++) { 
        	 DB::table('users')->insert([
	            'username' => str_random(10),
	            'password' => Hash::make(123456),
	            'auth'     => '1',
	            'profile'  => '/upload/15386245102741.png'
        	]);
        }
    }
}
