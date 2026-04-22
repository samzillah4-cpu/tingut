<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DemoUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'System Administrator',
                'email' => 'admin@demo.com',
                'password' => Hash::make('admin123'),
                'email_verified_at' => now(),
                'location' => 'Oslo',
            ],
            [
                'name' => 'John Doe',
                'email' => 'john@demo.com',
                'password' => Hash::make('demo123'),
                'email_verified_at' => now(),
                'location' => 'Bergen',
            ],
            [
                'name' => 'Jane Smith',
                'email' => 'jane@demo.com',
                'password' => Hash::make('demo123'),
                'email_verified_at' => now(),
                'location' => 'Trondheim',
            ],
            [
                'name' => 'Mike Johnson',
                'email' => 'mike@demo.com',
                'password' => Hash::make('demo123'),
                'email_verified_at' => now(),
                'location' => 'Stavanger',
            ],
            [
                'name' => 'Sarah Wilson',
                'email' => 'sarah@demo.com',
                'password' => Hash::make('demo123'),
                'email_verified_at' => now(),
                'location' => 'Kristiansand',
            ],
            [
                'name' => 'Demo Customer',
                'email' => 'customer@demo.com',
                'password' => Hash::make('demo123'),
                'email_verified_at' => now(),
                'location' => 'Tromsø',
            ],
        ];

        foreach ($users as $userData) {
            User::updateOrCreate(
                ['email' => $userData['email']],
                $userData
            );
        }

        // Assign admin role to admin user
        $admin = User::where('email', 'admin@demo.com')->first();
        if ($admin) {
            $admin->assignRole('Admin');
        }

        // Assign seller role to demo users (except customer)
        $demoUsers = User::where('email', '!=', 'admin@demo.com')
            ->where('email', '!=', 'customer@demo.com')
            ->get();
        foreach ($demoUsers as $user) {
            $user->assignRole('Seller');
        }

        // Assign customer role to demo customer
        $customer = User::where('email', 'customer@demo.com')->first();
        if ($customer) {
            $customer->assignRole('Customer');
        }
    }
}
