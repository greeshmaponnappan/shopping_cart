<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CouponSeeder extends Seeder
{
    public function run()
    {
        DB::table('coupons')->insert([
            [
                'code' => 'WELCOME10',
                'type' => 'percent',
                'value' => 10,
                'min_purchase' => 500,
                'max_discount' => 200,
                'expires_at' => Carbon::now()->addMonths(2),
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'FLAT50',
                'type' => 'fixed',
                'value' => 50,
                'min_purchase' => 0,
                'max_discount' => null,
                'expires_at' => Carbon::now()->addMonths(1),
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'NEWUSER20',
                'type' => 'percent',
                'value' => 20,
                'min_purchase' => 1000,
                'max_discount' => 300,
                'expires_at' => Carbon::now()->addMonths(3),
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
