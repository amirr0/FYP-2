<?php

namespace Database\Seeders;

use App\Models\Package;
use Illuminate\Database\Seeder;
use App\Models\PackageItem;
use Carbon\Carbon;

class ItemSeeder extends Seeder
{
    public function run()
    {


        $items = [
            [
                'package_id' => 1,
                'name' => 'Google Business',
                'price' => 200,
                'status' => 'Active',
                'created_at' => Carbon::now(),
            ],
            [
                'package_id' => 1,
                'name' => 'Youtube',
                'price' => 200,
                'status' => 'Active',
                'created_at' => Carbon::now(),
            ],
            [
                'package_id' => 1,
                'name' => 'BLogger',
                'price' => 300,
                'status' => 'Active',
                'created_at' => Carbon::now(),
            ],
            [
                'package_id' => 1,
                'name' => 'Google AddSense',
                'price' => 400,
                'status' => 'Active',
                'created_at' => Carbon::now(),
            ]
        ];

        PackageItem::insert($items);
    }
}
