<?php

namespace Database\Seeders;

use App\Models\HomeSale;
use App\Models\User;
use Illuminate\Database\Seeder;

class HomeSaleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get or create a demo seller user
        $seller = User::where('email', 'seller@demo.com')->first();
        if (! $seller) {
            $seller = User::create([
                'name' => 'Demo Seller',
                'email' => 'seller@demo.com',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
            ]);
            $seller->assignRole('Seller');
        }

        // Use new home sale images
        $homeSaleImages = [
            'home-sales/home-sale-1.jpg',
            'home-sales/home-sale-2.jpg',
            'home-sales/home-sale-3.jpg',
            'hero-images/6Vu1F5VGx3TKd3QGWZqkxm45tcDrEAU4XIhpfTIQ.jpg',
            'hero-images/z9SL3ALffhOJIU5rebVGCyzpyZulVNUILWr5wYuN.jpg',
            'testimonials/FPC1rVFUYVLQV8grNut70KmPZ64nVFF7FYIK85mm.jpg',
        ];

        // Demo Home Sale 1
        $homeSale1 = HomeSale::create([
            'user_id' => $seller->id,
            'title' => 'Modern Apartment Moving Sale - Oslo',
            'description' => 'Moving out of our beautiful modern apartment! Selling high-quality furniture, electronics, and home decor. Everything in excellent condition. Come find great deals on designer items!',
            'images' => [
                'https://picsum.photos/800/600?random=100',
                'https://picsum.photos/800/600?random=101',
                'https://picsum.photos/800/600?random=102',
            ],
            'sale_date_from' => now()->addDays(2)->format('Y-m-d'),
            'sale_date_to' => now()->addDays(4)->format('Y-m-d'),
            'available_items' => 'Modern sectional sofa, Glass dining table with 6 chairs, 65" Samsung 4K TV, KitchenAid stand mixer, Designer lamps, Queen size bed frame, Area rugs, Wall art, Stainless steel appliances',
            'location' => 'Oslo',
            'address' => '123 Karl Johans Gate, Sentrum',
            'city' => 'Oslo',
            'status' => 'active',
            'is_featured' => true,
        ]);

        // Demo Home Sale 2
        $homeSale2 = HomeSale::create([
            'user_id' => $seller->id,
            'title' => 'Scandinavian Style Home Sale - Bergen',
            'description' => 'Estate sale in a stunning Scandinavian-style home. Featuring mid-century modern furniture, Norwegian design pieces, and collectibles. Perfect items for your dream home!',
            'images' => [
                'https://picsum.photos/800/600?random=103',
                'https://picsum.photos/800/600?random=104',
                'https://picsum.photos/800/600?random=105',
            ],
            'sale_date_from' => now()->addDays(5)->format('Y-m-d'),
            'sale_date_to' => now()->addDays(6)->format('Y-m-d'),
            'available_items' => 'Danish teak dining set, Norwegian wool rugs, Mid-century armchair, Ceramic vase collection, Silver cutlery set, Crystal glassware, Oil paintings by local artists, Vintage record player, Bookshelf speakers',
            'location' => 'Bergen',
            'address' => '456 Bryggen Wharf, Bryggen',
            'city' => 'Bergen',
            'status' => 'active',
            'is_featured' => true,
        ]);

        // Demo Home Sale 3
        $homeSale3 = HomeSale::create([
            'user_id' => $seller->id,
            'title' => 'Family Home Downsizing Sale - Trondheim',
            'description' => 'Family of 4 downsizing to a smaller home. Selling gently used furniture, kids items, and household goods. Everything priced to sell quickly!',
            'images' => [
                'https://picsum.photos/800/600?random=106',
                'https://picsum.photos/800/600?random=107',
                'https://picsum.photos/800/600?random=108',
            ],
            'sale_date_from' => now()->addDays(7)->format('Y-m-d'),
            'sale_date_to' => now()->addDays(8)->format('Y-m-d'),
            'available_items' => 'Kids bunk beds, Toy storage units, Baby crib, High chairs, Stroller, Children\'s books, Family board games, Outdoor play equipment, Patio dining set, Garden tools, Indoor plants',
            'location' => 'Trondheim',
            'address' => '789 Nidaros Cathedral View, Midtbyen',
            'city' => 'Trondheim',
            'status' => 'active',
            'is_featured' => true,
        ]);

        // Demo Home Sale 4
        $homeSale4 = HomeSale::create([
            'user_id' => $seller->id,
            'title' => 'Luxury Condo Estate Sale - Stavanger',
            'description' => 'Luxury condo estate sale featuring high-end furnishings, artwork, and luxury items. Everything from this sophisticated urban home available for purchase.',
            'images' => [
                'https://picsum.photos/800/600?random=109',
                'https://picsum.photos/800/600?random=110',
                'https://picsum.photos/800/600?random=111',
            ],
            'sale_date_from' => now()->addDays(10)->format('Y-m-d'),
            'sale_date_to' => now()->addDays(12)->format('Y-m-d'),
            'available_items' => 'Italian leather sofa, Marble dining table, Abstract art collection, Designer chandelier, Persian silk rug, Wine refrigerator, Espresso machine, Home gym equipment, Smart home devices, Luxury bedding set',
            'location' => 'Stavanger',
            'address' => '321 Petroleum Road, Tjensvoll',
            'city' => 'Stavanger',
            'status' => 'active',
            'is_featured' => true,
        ]);

        $this->command->info('Demo home sales created successfully!');
        $this->command->info('Home Sale 1: Modern Apartment Moving Sale - Oslo');
        $this->command->info('Home Sale 2: Scandinavian Style Home Sale - Bergen');
        $this->command->info('Home Sale 3: Family Home Downsizing Sale - Trondheim');
        $this->command->info('Home Sale 4: Luxury Condo Estate Sale - Stavanger');
    }
}
