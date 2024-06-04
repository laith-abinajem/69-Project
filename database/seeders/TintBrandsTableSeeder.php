<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class TintBrandsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tint_brands')->insert([
            [
                'user_id' => 1, // Assuming user with ID 1 exists
                'tint_brand' => 'Brand A',
                'tint_description' => 'Description for Brand A',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_id' => 2, // Assuming user with ID 2 exists
                'tint_brand' => 'Brand B',
                'tint_description' => 'Description for Brand B',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
