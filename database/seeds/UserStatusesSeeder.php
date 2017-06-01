<?php

use Illuminate\Database\Seeder;

class UserStatusesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_statuses')->insert([
        	['name' => 'Pending Activation'],
        	['name' => 'Active'],
        	['name' => 'Inactive']
        ]);
    }
}
