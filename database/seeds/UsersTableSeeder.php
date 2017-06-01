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
        	'name'      => 'Manager',
        	'username'  => 'manager',
        	'email'     => 'manager@inventory.com',
        	'password'  =>  bcrypt('test'),
        	'role_id'   =>  1,
        	'status_id' => 1,
            'created_at' => date('Y-m-d H:i:s')
         ]);
    }
}
