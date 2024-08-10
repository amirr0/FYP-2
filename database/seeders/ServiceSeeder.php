<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;
use Carbon\Carbon;

class ServiceSeeder extends Seeder
{
    public function run()
    {
        $services = [
            [
                'name' => 'Business Profile Setup',
                'icon' => 'fas fa-desktop',
                'status' => 'Active',
                'description' => 'Let our creative team design stunning visuals and branding solutions that represent your brands identity and values.',
                'created_at' => Carbon::now(),
            ], [
                'name' => 'Social Media Managment',
                'icon' => 'fas fa-address-card',
                'status' => 'Active',
                'description' => 'Leave the management of your social media presence to us. Our team will take care of everything from content creation to analytics, ensuring you build a strong brand presence & grow your business.',
                'created_at' => Carbon::now(),
            ]
        ];
        Service::insert($services);
    }
}
