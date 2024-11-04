<?php

namespace Database\Seeders;

use App\Models\Role;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleUserDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // admin
        $adminRole = Role::create([
            'name' => 'admin',
            'description' => 'Admin',
        ]);
        $admin = User::create([
            'name' => '{ JEBC-DeV }',
            'email' => 'admin@admin.com',
            'email_verified_at' => Carbon::now(),
            'password' => Hash::make('12345678'),
            'role_id' => $adminRole->id,
        ]);

        $admin->userDetail()->create([
            'lastname' => 'Admin',
            'phone' => '123456789',
            'image' => null,
        ]);

        // consultant
        $consultantRole = Role::create([
            'name' => 'consultant',
            'description' => 'Consultant',
        ]);

        for ($i = 1; $i <= 5; $i++) {
            $consultant = User::create([
                'name' => 'Consultant ' . $i,
                'email' => 'consultant' . $i . '@consultant.com',
                'email_verified_at' => Carbon::now(),
                'password' => Hash::make('12345678'),
                'role_id' => $consultantRole->id,
            ]);

            $consultant->userDetail()->create([
                'lastname' => 'Consultant ' . $i,
                'phone' => fake()->phoneNumber,
                'image' => null,
            ]);
        }

        // user
        $userRole = Role::create([
            'name' => 'user',
            'description' => 'User',
        ]);

        for ($i = 1; $i <= 20; $i++) {
            $user = User::create([
                'name' => 'User' . $i,
                'email' => 'user' . $i . '@user.com',
                'email_verified_at' => Carbon::now(),
                'password' => Hash::make('12345678'),
                'role_id' => $userRole->id,
            ]);

            $user->userDetail()->create([
                'lastname' => 'User' . $i,
                'phone' => fake()->phoneNumber,
                'image' => null,
            ]);
        }
    }
}
