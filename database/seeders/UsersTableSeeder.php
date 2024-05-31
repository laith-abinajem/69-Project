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
                'sub_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Subscriber Two',
                'email' => 'sub2@sub.com',
                'email_verified_at' => Carbon::now(),
                'password' => Hash::make('123'),
                'type' => 'subscriber',
                'status' => 'approved',
                'remember_token' => Str::random(10),
                'sub_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Subscriber Three',
                'email' => 'sub3@sub.com',
                'email_verified_at' => null,
                'password' => Hash::make('123'),
                'type' => 'subscriber',
                'status' => 'rejected',
                'remember_token' => Str::random(10),
                'sub_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);
    }
}
