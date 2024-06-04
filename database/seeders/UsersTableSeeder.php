<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

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
            [
                'name' => 'Super Admin',
                'email' => 'admin@admin.com',
                'email_verified_at' => Carbon::now(),
                'password' => Hash::make('123'),
                'type' => 'super_admin',
                'status' => 'approved',
                'remember_token' => Str::random(10),
                'sub_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Subscriber One',
                'email' => 'sub@sub.com',
                'email_verified_at' => Carbon::now(),
                'password' => Hash::make('123'),
                'type' => 'subscriber',
                'status' => 'pending',
                'remember_token' => Str::random(10),
                'sub_id' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
        DB::table('subscriptions')->insert([
            [
                'user_id' => 1,
                'payment_status' => 'success',
                'package_type' => 3,
                'price' => 100,
                'end_date' => '2024-07-04',
                'start_date' => '2024-06-04',
            ],
        ]);
    }
}
