<?php

namespace Database\Seeders;

use database;
use Carbon\Carbon;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        $adminRole = Role::where('name', 'Admin')->first();
        $vendorRole = Role::where('name', 'Vendor')->first();
        $clientRole = Role::where('name', 'Client')->first();

        $users = [
            [
                'first_name' => 'Admin',
                'last_name' => '',
                'profile_picture' => "",
                'email' => 'admin@gmail.com',
                'password' => Hash::make('123'),
                'status' => 'Active',
                'created_at' => Carbon::now(),
                'role_id' => $adminRole->id,


            ], [
                'first_name' => 'Jon',
                'last_name' => 'Jones',
                'profile_picture' => "",
                'email' => 'jonjones@gmail.com',
                'password' => Hash::make('123'),
                'status' => 'Active',
                'created_at' => Carbon::now(),
                'role_id' => $vendorRole->id,


            ], [
                'first_name' => 'Muhammad',
                'last_name' => 'Hassan',
                'profile_picture' => "",
                'email' => 'mhassan@gmail.com',
                'password' => Hash::make('123'),
                'status' => 'Active',
                'created_at' => Carbon::now(),
                'role_id' => $vendorRole->id,


            ], [
                'first_name' => 'Sara',
                'last_name' => 'Khan',
                'profile_picture' => "",
                'email' => 'sarakhan@gmail.com',
                'password' => Hash::make('123'),
                'status' => 'Active',
                'created_at' => Carbon::now(),
                'role_id' => $vendorRole->id,


            ],
            [
                'first_name' => 'Mick',
                'last_name' => 'Blue',
                'profile_picture' => "",
                'email' => 'mickblue@gmail.com',
                'password' => Hash::make('123'),
                'status' => 'Active',
                'created_at' => Carbon::now(),
                'role_id' => $clientRole->id,

            ],
            [
                'first_name' => 'Baz',
                'last_name' => 'Shah',
                'profile_picture' => "",
                'email' => 'bazshah@gmail.com',
                'password' => Hash::make('123'),
                'status' => 'Active',
                'created_at' => Carbon::now(),
                'role_id' => $clientRole->id,

            ],
        ];
        User::insert($users);
    }
}
