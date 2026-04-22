<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\WebsiteHero;

class WebsiteHeroSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        WebsiteHero::create([
            'background_image' => null, // Will be uploaded by admin
            'heading' => 'Welcome to TingUt.no',
            'paragraph' => 'Discover amazing products from local sellers. Exchange, trade, and find great deals on items you love. Join our community of buyers and sellers today!',
            'button1_text' => 'Browse Products',
            'button1_url' => '/products',
            'button2_text' => 'Become a Seller',
            'button2_url' => '/register',
            'is_active' => true,
        ]);
    }
}
