<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Package;
use Carbon\Carbon;

class PackageSeeder extends Seeder
{
    public function run()
    {
        $packages = [

            [
                'service_id' => 1,
                'name' => 'Google Services',
                'price' => 100,
                'status' => 'Active',
                'created_at' => Carbon::now(),
            ]

        ];

        Package::insert($packages);
    }
}
