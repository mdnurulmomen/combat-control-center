<?php

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class AdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        DB::table('admins')->truncate();

        DB::table('admins')->insert([
            'firstname'=>Str::random(4),
	        'lastname'=>Str::random(4),
	        'username'=>'admin',
	        'password'=>bcrypt('admin'), // secret
	        'remember_token'=> Str::random(10),
	        'email'=>Str::random(6).'@gmail.com',
	        'phone'=>'0'.rand(6, 11),
	        'address'=>'Address',
	        'city'=>'Dhaka',
	        'country'=>'Bangladesh'
        ]);
    }
}
