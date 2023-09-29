<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use DB;
use Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
           
            'name'            => 'Rahul Pandit',
            'email'           => 'rhpandit0011b@gmail.com',
            'password'        => Hash::make('12345678'),
            'created_at'      => Carbon::now(),
            'updated_at'      => Carbon::now()
        ]);
    }
}
