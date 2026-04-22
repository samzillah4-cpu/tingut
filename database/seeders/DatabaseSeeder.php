<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleAndPermissionSeeder::class,
            CategorySeeder::class,
            DemoUserSeeder::class,
            ProductSeeder::class,
            BlogSeeder::class,
            HomeSaleSeeder::class,
            WebsiteMenuSeeder::class,
            WebsiteHeroSeeder::class,
            TestimonialSeeder::class,
            SubscriptionPlansSeeder::class,
        ]);
    }
}
