<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Get existing categories and users
        $categories = Category::all();
        $users = User::where('email', '!=', 'admin@demo.com')->get();

        if ($categories->isEmpty() || $users->isEmpty()) {
            return; // Skip if no categories or users exist
        }

        // Helper function to get random user safely
        $getRandomUserId = function () use ($users) {
            $user = $users->random();

            return $user ? $user->id : $users->first()->id;
        };

        // Helper function to get category ID safely
        $getCategoryId = function ($name) use ($categories) {
            $category = $categories->where('name', $name)->first();

            return $category ? $category->id : $categories->first()->id;
        };



        // Demo products - 3 per category
        $existingProducts = [
            // Electronics (3 products)
            [
                'title' => 'iPhone 15 Pro Max - 512GB',
                'description' => 'Latest iPhone with titanium design, A17 Pro chip, and advanced camera system. Unlocked and in perfect condition with all accessories.',
                'category_id' => $getCategoryId('Electronics'),
                'user_id' => $getRandomUserId(),
                'images' => [
                    'https://picsum.photos/600/400?random=200',
                    'https://picsum.photos/600/400?random=201',
                    'https://picsum.photos/600/400?random=202',
                ],
                'location' => 'Oslo',
                'status' => 'active',
                'listing_type' => 'sale',
                'is_for_sale' => true,
                'sale_price' => 14500.00,
            ],
            [
                'title' => 'MacBook Air M3 - 13" Display',
                'description' => 'Ultra-thin laptop with M3 chip, 16GB RAM, 512GB SSD. Perfect for students and professionals. Includes original charger.',
                'category_id' => $getCategoryId('Electronics'),
                'user_id' => $getRandomUserId(),
                'images' => [
                    'https://picsum.photos/600/400?random=203',
                    'https://picsum.photos/600/400?random=204',
                    'https://picsum.photos/600/400?random=205',
                ],
                'location' => 'Bergen',
                'status' => 'active',
                'listing_type' => 'sale',
                'is_for_sale' => true,
                'sale_price' => 18500.00,
            ],
            [
                'title' => 'Sony WH-1000XM5 Headphones',
                'description' => 'Premium noise-canceling wireless headphones with 30-hour battery life. Crystal clear sound quality and comfortable fit.',
                'category_id' => $getCategoryId('Electronics'),
                'user_id' => $getRandomUserId(),
                'images' => [
                    'https://picsum.photos/600/400?random=206',
                    'https://picsum.photos/600/400?random=207',
                    'https://picsum.photos/600/400?random=208',
                ],
                'location' => 'Trondheim',
                'status' => 'active',
                'listing_type' => 'sale',
                'is_for_sale' => true,
                'sale_price' => 3200.00,
            ],
            // Clothing (3 products)
            [
                'title' => 'Canada Goose Expedition Parka',
                'description' => 'Authentic Canada Goose parka in black, size L. Excellent condition, perfect for Norwegian winters. Includes hood trim and all original features.',
                'category_id' => $categories->where('name', 'Clothing')->first()?->id ?? $categories->first()->id,
                'user_id' => $getRandomUserId(),
                'images' => [
                    'https://picsum.photos/600/400?random=209',
                    'https://picsum.photos/600/400?random=210',
                    'https://picsum.photos/600/400?random=211',
                ],
                'location' => 'Oslo',
                'status' => 'active',
                'listing_type' => 'sale',
                'is_for_sale' => true,
                'sale_price' => 4500.00,
            ],
            [
                'title' => 'Rolex Submariner Date - Steel',
                'description' => 'Classic Rolex Submariner with steel bracelet. Excellent condition with original papers and box. Iconic diving watch design.',
                'category_id' => $categories->where('name', 'Clothing')->first()?->id ?? $categories->first()->id,
                'user_id' => $getRandomUserId(),
                'images' => [
                    'https://picsum.photos/600/400?random=212',
                    'https://picsum.photos/600/400?random=213',
                    'https://picsum.photos/600/400?random=214',
                ],
                'location' => 'Stavanger',
                'status' => 'active',
                'listing_type' => 'sale',
                'is_for_sale' => true,
                'sale_price' => 285000.00,
            ],
            [
                'title' => 'Nike Air Jordan 1 Retro High OG',
                'description' => 'Vintage Nike Air Jordan 1 sneakers in original Chicago colorway. Size 10. Rare collectible sneakers in mint condition.',
                'category_id' => $categories->where('name', 'Clothing')->first()?->id ?? $categories->first()->id,
                'user_id' => $getRandomUserId(),
                'images' => [
                    'https://picsum.photos/600/400?random=215',
                    'https://picsum.photos/600/400?random=216',
                    'https://picsum.photos/600/400?random=217',
                ],
                'location' => 'Bergen',
                'status' => 'active',
                'listing_type' => 'sale',
                'is_for_sale' => true,
                'sale_price' => 1800.00,
            ],
            // Books (3 products)
            [
                'title' => 'Complete Harry Potter Series - First Editions',
                'description' => 'Full set of Harry Potter books, first editions in excellent condition. Perfect for collectors or fans of the magical world.',
                'category_id' => $categories->where('name', 'Books')->first()?->id ?? $categories->first()->id,
                'user_id' => $getRandomUserId(),
                'images' => [
                    'https://picsum.photos/600/400?random=218',
                    'https://picsum.photos/600/400?random=219',
                    'https://picsum.photos/600/400?random=220',
                ],
                'location' => 'Oslo',
                'status' => 'active',
                'listing_type' => 'sale',
                'is_for_sale' => true,
                'sale_price' => 2500.00,
            ],
            [
                'title' => 'Vintage Encyclopedia Britannica Set',
                'description' => 'Complete 1960s Encyclopedia Britannica set with over 20 volumes. Beautiful leather-bound books in excellent condition.',
                'category_id' => $categories->where('name', 'Books')->first()?->id ?? $categories->first()->id,
                'user_id' => $getRandomUserId(),
                'images' => [
                    'https://picsum.photos/600/400?random=221',
                    'https://picsum.photos/600/400?random=222',
                    'https://picsum.photos/600/400?random=223',
                ],
                'location' => 'Trondheim',
                'status' => 'active',
                'listing_type' => 'sale',
                'is_for_sale' => true,
                'sale_price' => 1200.00,
            ],
            [
                'title' => 'Norwegian Literature Collection',
                'description' => 'Curated collection of Norwegian literature including works by Henrik Ibsen, Knut Hamsun, and Sigrid Undset. Perfect for literature enthusiasts.',
                'category_id' => $categories->where('name', 'Books')->first()?->id ?? $categories->first()->id,
                'user_id' => $getRandomUserId(),
                'images' => [
                    'https://picsum.photos/600/400?random=224',
                    'https://picsum.photos/600/400?random=225',
                    'https://picsum.photos/600/400?random=226',
                ],
                'location' => 'Bergen',
                'status' => 'active',
                'listing_type' => 'sale',
                'is_for_sale' => true,
                'sale_price' => 800.00,
            ],
            // Home & Garden (3 products)
            [
                'title' => 'Dyson V15 Detect Vacuum Cleaner',
                'description' => 'Latest Dyson cordless vacuum with laser dust detection. Powerful suction and intelligent cleaning modes. Like new condition.',
                'category_id' => $categories->where('name', 'Home & Garden')->first()?->id ?? $categories->first()->id,
                'user_id' => $getRandomUserId(),
                'images' => [
                    'https://picsum.photos/600/400?random=227',
                    'https://picsum.photos/600/400?random=228',
                    'https://picsum.photos/600/400?random=229',
                ],
                'location' => 'Oslo',
                'status' => 'active',
                'listing_type' => 'sale',
                'is_for_sale' => true,
                'sale_price' => 5500.00,
            ],
            [
                'title' => 'Eames Lounge Chair and Ottoman',
                'description' => 'Iconic mid-century modern lounge chair designed by Charles and Ray Eames. Genuine leather upholstery in excellent condition.',
                'category_id' => $categories->where('name', 'Home & Garden')->first()?->id ?? $categories->first()->id,
                'user_id' => $getRandomUserId(),
                'images' => [
                    'https://picsum.photos/600/400?random=230',
                    'https://picsum.photos/600/400?random=231',
                    'https://picsum.photos/600/400?random=232',
                ],
                'location' => 'Stavanger',
                'status' => 'active',
                'listing_type' => 'sale',
                'is_for_sale' => true,
                'sale_price' => 45000.00,
            ],
            [
                'title' => 'Organic Vegetable Seed Collection',
                'description' => 'Complete set of organic vegetable seeds for Norwegian climate. Includes tomatoes, cucumbers, peppers, herbs, and leafy greens.',
                'category_id' => $categories->where('name', 'Home & Garden')->first()?->id ?? $categories->first()->id,
                'user_id' => $getRandomUserId(),
                'images' => [
                    'https://picsum.photos/600/400?random=233',
                    'https://picsum.photos/600/400?random=234',
                    'https://picsum.photos/600/400?random=235',
                ],
                'location' => 'Kristiansand',
                'status' => 'active',
                'listing_type' => 'sale',
                'is_for_sale' => true,
                'sale_price' => 150.00,
            ],
        ];

        // Create 5 additional products for sale (using existing images)
        $saleProducts = [
            [
                'title' => 'Mountain Bike - Trek Brand',
                'description' => 'Well-maintained mountain bike suitable for trails and city riding. 26-inch wheels. This Trek mountain bike is perfect for both urban commuting and light trail riding. The frame is aluminum for lightweight performance, and it features 21-speed Shimano gears for versatile riding. The tires are in good condition with plenty of tread life remaining. Includes a rear rack for carrying gear.',
                'category_id' => $categories->where('name', 'Sports & Outdoors')->first()?->id ?? $categories->first()->id,
                'user_id' => $getRandomUserId(),
                'images' => [
                    'products/Z8CuAH9yDYGvo0ssnR2pdVlxFCPsyuDAJoT5kHT4.png',
                    'products/CFxiugIKKGGPtlKLI08x6CWt0SGNVI2TpLQChlE4.png',
                    'products/J4yeEryelKz0w1FVfFAJHLaZc6gZCMdMLAaaaoJR.png',
                ],
                'location' => 'Trondheim',
                'status' => 'active',
                'listing_type' => 'sale',
                'is_for_sale' => true,
                'sale_price' => 800.00,
            ],
            [
                'title' => 'Coffee Table Books - Art & Design Collection',
                'description' => 'Set of 5 beautifully illustrated coffee table books on art, photography, and design. This collection includes five stunning coffee table books featuring contemporary art, architectural photography, Scandinavian design, modern interiors, and landscape photography. All books are in excellent condition with dust jackets intact. Perfect for someone who appreciates visual arts and wants to enhance their living space.',
                'category_id' => $categories->where('name', 'Books & Media')->first()?->id ?? $categories->first()->id,
                'user_id' => $getRandomUserId(),
                'images' => [
                    'products/lSZ9IZd1T2kVq5CWvJ6urA1KPTsRkAgaC48E6fzu.jpg',
                    'products/YXcSgQmEkMZW7txC7TF0cRgQdlqrpQrA92b1z9h5.jpg',
                    'products/pxqfuPLOvYpAWqpwVPbGLzGVFHwxHMDH4CfIiveg.jpg',
                ],
                'location' => 'Stavanger',
                'status' => 'active',
                'listing_type' => 'exchange',
                'exchange_categories' => ['Books & Media', 'Electronics'],
            ],
            [
                'title' => 'Garden Tools Set - Complete Package',
                'description' => 'Complete set of gardening tools including shovel, rake, pruners, and gloves. All in great condition. This comprehensive gardening tool set includes everything you need for maintaining a garden: a sturdy shovel, leaf rake, hand pruners, trowel, garden fork, and protective gloves. All tools are made from quality materials and have been well-maintained. Perfect for gardening enthusiasts or anyone looking to start their gardening journey.',
                'category_id' => $categories->where('name', 'Home & Garden')->first()?->id ?? $categories->first()->id,
                'user_id' => $getRandomUserId(),
                'images' => [
                    'products/yN3VJN4os2OeRzfsgonLIQGPeSKESDObzZ3ILH6i.jpg',
                    'products/QTFtXemaVEbub9cXY1nGvu6Dg2qUWEgzuoTxGrQH.jpg',
                    'products/uVPiQMV2nfq9xaKEOtMvXsh04PdP6V2oDKYe3kKC.jpg',
                ],
                'location' => 'Kristiansand',
                'status' => 'active',
            ],
            [
                'title' => 'Designer Handbag - Gucci',
                'description' => 'Elegant black Gucci handbag in pristine condition. Genuine leather with gold hardware. This luxurious designer handbag features the iconic Gucci logo and comes with dust bag and authenticity card. Perfect for special occasions or everyday elegance. The bag is spacious with multiple compartments and a detachable strap.',
                'category_id' => $categories->where('name', 'Clothing')->first()?->id ?? $categories->first()->id,
                'user_id' => $getRandomUserId(),
                'images' => [
                    'products/meIxIOKJVbYQ4McdMWlH2FIZIS5g7TydqFl9EXTD.png',
                    'products/SsX7NKzqqyqJ66pDEvWIBcj5uyxLWFLWs3LVoFJY.jpg',
                    'products/v4izxAMIrkfnDbhuQml1iLoIqOfmGVJ9MvAD0tnT.jpg',
                ],
                'location' => 'Oslo',
                'status' => 'active',
                'listing_type' => 'giveaway',
            ],
            [
                'title' => 'Vintage Vinyl Record Collection',
                'description' => 'Rare collection of 20 vintage vinyl records from the 1960s and 1970s. Includes classic rock and jazz albums. All records are in excellent condition, stored properly and cleaned regularly. Comes with a vintage record player stand. Perfect for music enthusiasts and collectors.',
                'category_id' => $categories->where('name', 'Collectibles')->first()?->id ?? $categories->first()->id,
                'user_id' => $getRandomUserId(),
                'images' => [
                    'products/UkUBuEnsEWurlDVY2hVbCFYS3rI1lVHFAUSrB6iZ.jpg',
                    'products/Z8CuAH9yDYGvo0ssnR2pdVlxFCPsyuDAJoT5kHT4.png',
                    'products/XrsiFctmKQIf2tsEI5wxPDxM5LpWVytykCYgmmSR.jpg',
                ],
                'location' => 'Bergen',
                'status' => 'active',
            ],
            [
                'title' => 'Professional Camera - Canon EOS R5 (Available for Rent)',
                'description' => 'High-end mirrorless camera perfect for photography enthusiasts. Available for rent with all accessories. This professional-grade Canon EOS R5 offers exceptional image quality with a 45MP full-frame sensor. Ideal for portraits, landscapes, and events. Comes with multiple lenses and a sturdy carrying case.',
                'category_id' => $getCategoryId('Electronics'),
                'user_id' => $getRandomUserId(),
                'images' => [
                    'products/P8ay2eYN1LWcNJBIL0nlYAB4WHgeqKbG5Tu4Lfeq.jpg',
                    'products/1y59yaLBhDqYPbZ0eks7TYP7lW8ELnKakmESR5AM.jpg',
                    'products/ijUwKyRsQEyfdWs44CxOzOHILn98sBJuSq0N58on.jpg',
                ],
                'location' => 'Oslo',
                'status' => 'active',
                'is_available_for_rent' => true,
                'rent_price' => 150.00,
                'rent_duration_unit' => 'day',
                'rent_duration_value' => 1,
                'rent_deposit' => 500.00,
                'rent_terms' => 'Camera must be returned in the same condition. Late returns incur additional fees.',
            ],
            [
                'title' => 'Electric Scooter - Urban Commuter (Rent Only)',
                'description' => 'Eco-friendly electric scooter for city commuting. Fast charging and long battery life. Perfect for short trips around town. Features a comfortable seat, LED lights, and smartphone connectivity.',
                'category_id' => $categories->where('name', 'Sports & Outdoors')->first()?->id ?? $categories->first()->id,
                'user_id' => $getRandomUserId(),
                'images' => [
                    'products/FZnLw3cIyhPDEKV17zneKdqV6h4he2bPl4ctxSr2.jpg',
                    'products/gucci-handbag-demo.jpg',
                    'products/uDqrBRFNoK5Fwn7XFD19XNKdOaR6z7AAClZkCG4V.jpg',
                ],
                'location' => 'Bergen',
                'status' => 'active',
                'is_available_for_rent' => true,
                'rent_price' => 25.00,
                'rent_duration_unit' => 'day',
                'rent_duration_value' => 1,
                'rent_deposit' => 100.00,
                'rent_terms' => 'Valid driver\'s license required. Helmet provided. Maximum speed 25km/h.',
            ],
            [
                'title' => 'Luxury Tent - 4-Person Camping Setup (Weekly Rental)',
                'description' => 'Spacious 4-person tent with all camping accessories. Perfect for weekend getaways. Includes sleeping bags, air mattresses, and cooking equipment. Waterproof and easy to set up.',
                'category_id' => $categories->where('name', 'Sports & Outdoors')->first()?->id ?? $categories->first()->id,
                'user_id' => $getRandomUserId(),
                'images' => [
                    'products/ZaYQZmhbqL7HE4tO6FXj4lE3DuKPhsfYg3kDWxgw.jpg',
                    'products/19axSNOqkkLkqaclPlkoTl6BsGpLtsjStZT0DP0Y.jpg',
                    'products/vinyl-records-demo.jpg',
                ],
                'location' => 'Trondheim',
                'status' => 'active',
                'is_available_for_rent' => true,
                'rent_price' => 75.00,
                'rent_duration_unit' => 'week',
                'rent_duration_value' => 1,
                'rent_deposit' => 200.00,
                'rent_terms' => 'Tent must be cleaned before return. Suitable for experienced campers only.',
            ],
        ];

        // Create 5 additional products for sale (using existing images)
        $saleProducts = [
            [
                'title' => 'Apple MacBook Pro 16" M1 Max',
                'description' => 'Powerful MacBook Pro with M1 Max chip, 32GB RAM, 1TB SSD. Perfect for creative professionals, video editing, and development work. This laptop offers exceptional performance with the revolutionary M1 Max chip, featuring 10 CPU cores and 32 GPU cores. The 16-inch Liquid Retina XDR display provides stunning visuals with ProMotion technology. Includes all original accessories and comes in the sleek Space Gray finish.',
                'category_id' => $getCategoryId('Electronics'),
                'user_id' => $getRandomUserId(),
                'images' => [
                    'products/SsX7NKzqqyqJ66pDEvWIBcj5uyxLWFLWs3LVoFJY.jpg',
                    'products/v4izxAMIrkfnDbhuQml1iLoIqOfmGVJ9MvAD0tnT.jpg',
                    'products/UkUBuEnsEWurlDVY2hVbCFYS3rI1lVHFAUSrB6iZ.jpg',
                ],
                'location' => 'Oslo',
                'status' => 'active',
                'listing_type' => 'sale',
                'is_for_sale' => true,
                'sale_price' => 2500.00,
            ],
            [
                'title' => 'Professional DSLR Camera - Nikon D850',
                'description' => 'High-resolution DSLR camera perfect for photography enthusiasts and professionals. 45.7MP sensor, 4K video capability. This Nikon D850 is a professional-grade DSLR camera featuring a 45.7MP full-frame CMOS sensor that delivers exceptional image quality. Perfect for landscape, portrait, and commercial photography. Includes multiple lenses, battery grip, and professional carrying case.',
                'category_id' => $getCategoryId('Electronics'),
                'user_id' => $getRandomUserId(),
                'images' => [
                    'products/P8ay2eYN1LWcNJBIL0nlYAB4WHgeqKbG5Tu4Lfeq.jpg',
                    'products/1y59yaLBhDqYPbZ0eks7TYP7lW8ELnKakmESR5AM.jpg',
                    'products/ijUwKyRsQEyfdWs44CxOzOHILn98sBJuSq0N58on.jpg',
                ],
                'location' => 'Bergen',
                'status' => 'active',
                'is_for_sale' => true,
                'sale_price' => 1800.00,
            ],
            [
                'title' => 'Vintage Rolex Submariner Watch',
                'description' => 'Authentic vintage Rolex Submariner with ceramic bezel and automatic movement. Excellent condition with full service history. This iconic dive watch features a 40mm stainless steel case, ceramic bezel, and the legendary Mercedes hands. Comes with original box, papers, and warranty card. A timeless piece for any watch enthusiast.',
                'category_id' => $categories->where('name', 'Collectibles')->first()?->id ?? $categories->first()->id,
                'user_id' => $getRandomUserId(),
                'images' => [
                    'products/Z8CuAH9yDYGvo0ssnR2pdVlxFCPsyuDAJoT5kHT4.png',
                    'products/CFxiugIKKGGPtlKLI08x6CWt0SGNVI2TpLQChlE4.png',
                    'products/J4yeEryelKz0w1FVfFAJHLaZc6gZCMdMLAaaaoJR.png',
                ],
                'location' => 'Oslo',
                'status' => 'active',
                'is_for_sale' => true,
                'sale_price' => 8500.00,
            ],
            [
                'title' => 'Ergonomic Office Chair - Herman Miller Aeron',
                'description' => 'Premium ergonomic office chair with adjustable height, lumbar support, and breathable mesh back. Perfect for long work sessions. This Herman Miller Aeron chair provides exceptional comfort and support with its signature Pellicle suspension system. The adjustable arms, seat height, and lumbar support ensure proper posture throughout the workday. Ideal for home offices or professional workspaces.',
                'category_id' => $categories->where('name', 'Home & Garden')->first()?->id ?? $categories->first()->id,
                'user_id' => $getRandomUserId(),
                'images' => [
                    'products/yN3VJN4os2OeRzfsgonLIQGPeSKESDObzZ3ILH6i.jpg',
                    'products/QTFtXemaVEbub9cXY1nGvu6Dg2qUWEgzuoTxGrQH.jpg',
                    'products/uVPiQMV2nfq9xaKEOtMvXsh04PdP6V2oDKYe3kKC.jpg',
                ],
                'location' => 'Trondheim',
                'status' => 'active',
                'is_for_sale' => true,
                'sale_price' => 650.00,
            ],
            [
                'title' => 'Electric Guitar - Fender American Ultra II',
                'description' => 'Professional electric guitar with V-Mod II pickups, Ultra Noiseless operation, and modern C-shaped neck profile. Perfect for gigging musicians. This Fender American Ultra II Stratocaster features Ultra Noiseless Vintage Telecaster pickups, Ultra Modern C neck profile, and noiseless operation. Includes deluxe gig bag, strap, and cable. Excellent for studio recording and live performances.',
                'category_id' => $categories->where('name', 'Books & Media')->first()?->id ?? $categories->first()->id,
                'user_id' => $getRandomUserId(),
                'images' => [
                    'products/meIxIOKJVbYQ4McdMWlH2FIZIS5g7TydqFl9EXTD.png',
                    'products/SsX7NKzqqyqJ66pDEvWIBcj5uyxLWFLWs3LVoFJY.jpg',
                    'products/v4izxAMIrkfnDbhuQml1iLoIqOfmGVJ9MvAD0tnT.jpg',
                ],
                'location' => 'Stavanger',
                'status' => 'active',
                'is_for_sale' => true,
                'sale_price' => 1200.00,
            ],
        ];

        // Create new products with the new 3 images
        $newProducts = [
            [
                'title' => 'Modern Sofa Set - Beige',
                'description' => 'Beautiful modern 3-seater sofa in beige color. Excellent condition, very comfortable. Perfect for living rooms. Features high-quality fabric and sturdy wooden legs. Recently cleaned and well-maintained.',
                'category_id' => $categories->where('name', 'Home & Garden')->first()?->id ?? $categories->first()->id,
                'user_id' => $getRandomUserId(),
                'images' => [
                    'products/lSZ9IZd1T2kVq5CWvJ6urA1KPTsRkAgaC48E6fzu.jpg',
                    'products/YXcSgQmEkMZW7txC7TF0cRgQdlqrpQrA92b1z9h5.jpg',
                    'products/pxqfuPLOvYpAWqpwVPbGLzGVFHwxHMDH4CfIiveg.jpg',
                ],
                'location' => 'Oslo',
                'status' => 'active',
                'listing_type' => 'sale',
                'is_for_sale' => true,
                'sale_price' => 450.00,
            ],
            [
                'title' => 'Kids Bicycle - 20 inch',
                'description' => 'Perfect starter bike for kids aged 6-10. Features training wheels, basket, and bell. Recently serviced with new tires. Safe and fun for learning to ride!',
                'category_id' => $categories->where('name', 'Sports & Outdoors')->first()?->id ?? $categories->first()->id,
                'user_id' => $getRandomUserId(),
                'images' => [
                    'products/yN3VJN4os2OeRzfsgonLIQGPeSKESDObzZ3ILH6i.jpg',
                    'products/QTFtXemaVEbub9cXY1nGvu6Dg2qUWEgzuoTxGrQH.jpg',
                    'products/uVPiQMV2nfq9xaKEOtMvXsh04PdP6V2oDKYe3kKC.jpg',
                ],
                'location' => 'Bergen',
                'status' => 'active',
                'listing_type' => 'sale',
                'is_for_sale' => true,
                'sale_price' => 120.00,
            ],
            [
                'title' => 'Bookshelf - White',
                'description' => 'Elegant 5-tier white bookshelf with metal frame. Perfect for displaying books and decor. Easy to assemble and sturdy construction. Great condition with minimal wear.',
                'category_id' => $categories->where('name', 'Home & Garden')->first()?->id ?? $categories->first()->id,
                'user_id' => $getRandomUserId(),
                'images' => [
                    'products/meIxIOKJVbYQ4McdMWlH2FIZIS5g7TydqFl9EXTD.png',
                    'products/SsX7NKzqqyqJ66pDEvWIBcj5uyxLWFLWs3LVoFJY.jpg',
                    'products/v4izxAMIrkfnDbhuQml1iLoIqOfmGVJ9MvAD0tnT.jpg',
                ],
                'location' => 'Trondheim',
                'status' => 'active',
                'listing_type' => 'giveaway',
            ],
        ];

        // Create existing products
        foreach ($existingProducts as $productData) {
            Product::create($productData);
        }

        // Create sale products
        foreach ($saleProducts as $productData) {
            Product::create($productData);
        }

        // Create new products
        foreach ($newProducts as $productData) {
            Product::create($productData);
        }

        // Create 10 additional demo products with new images
        $demoProducts = [
            [
                'title' => 'Smart Watch - Apple Watch Series 8',
                'description' => 'Latest Apple Watch Series 8 in excellent condition. Features GPS, heart rate monitoring, and fitness tracking. Comes with original box and charger. Perfect for tracking your health and staying connected on the go.',
                'category_id' => $getCategoryId('Electronics'),
                'user_id' => $getRandomUserId(),
                'images' => [
                    'products/product-1.jpg',
                    'products/product-2.jpg',
                    'products/product-3.jpg',
                ],
                'location' => 'Oslo',
                'status' => 'active',
                'listing_type' => 'sale',
                'is_for_sale' => true,
                'sale_price' => 350.00,
            ],
            [
                'title' => 'Designer Sunglasses - Ray-Ban Aviator',
                'description' => 'Authentic Ray-Ban Aviator sunglasses with polarized lenses. Classic gold frame with green lenses. Includes original case and cleaning cloth. Perfect for sunny days.',
                'category_id' => $categories->where('name', 'Clothing')->first()?->id ?? $categories->first()->id,
                'user_id' => $getRandomUserId(),
                'images' => [
                    'products/product-4.jpg',
                    'products/product-5.jpg',
                    'products/product-6.jpg',
                ],
                'location' => 'Bergen',
                'status' => 'active',
                'listing_type' => 'exchange',
                'exchange_categories' => ['Clothing', 'Electronics'],
            ],
            [
                'title' => 'Wireless Gaming Mouse - Logitech G Pro',
                'description' => 'Professional wireless gaming mouse with ultra-fast response time. Lightweight design perfect for competitive gaming. RGB lighting and programmable buttons. Barely used, excellent condition.',
                'category_id' => $getCategoryId('Electronics'),
                'user_id' => $getRandomUserId(),
                'images' => [
                    'products/product-7.jpg',
                    'products/product-8.jpg',
                    'products/product-9.jpg',
                ],
                'location' => 'Trondheim',
                'status' => 'active',
                'listing_type' => 'sale',
                'is_for_sale' => true,
                'sale_price' => 89.00,
            ],
            [
                'title' => 'Portable Bluetooth Speaker - JBL Flip 5',
                'description' => 'Waterproof portable speaker with powerful bass. 12 hours of playtime. Perfect for outdoor activities, beach trips, or home use. Great sound quality in a compact package.',
                'category_id' => $getCategoryId('Electronics'),
                'user_id' => $getRandomUserId(),
                'images' => [
                    'products/product-10.jpg',
                    'products/product-1.jpg',
                    'products/product-2.jpg',
                ],
                'location' => 'Stavanger',
                'status' => 'active',
                'listing_type' => 'sale',
                'is_for_sale' => true,
                'sale_price' => 75.00,
            ],
            [
                'title' => 'Yoga Mat - Lululemon Align',
                'description' => 'Premium yoga mat perfect for yoga, pilates, and floor exercises. Non-slip surface with excellent cushioning. 6mm thickness for comfortable practice. Includes carrying strap.',
                'category_id' => $categories->where('name', 'Sports & Outdoors')->first()?->id ?? $categories->first()->id,
                'user_id' => $getRandomUserId(),
                'images' => [
                    'products/product-3.jpg',
                    'products/product-4.jpg',
                    'products/product-5.jpg',
                ],
                'location' => 'Kristiansand',
                'status' => 'active',
                'listing_type' => 'giveaway',
            ],
            [
                'title' => 'Espresso Machine - DeLonghi Magnifica',
                'description' => 'Automatic espresso machine with built-in grinder. Makes delicious espresso, cappuccino, and latte. Easy to use with one-touch recipes. Recently serviced and in perfect working condition.',
                'category_id' => $categories->where('name', 'Home & Garden')->first()?->id ?? $categories->first()->id,
                'user_id' => $getRandomUserId(),
                'images' => [
                    'products/product-6.jpg',
                    'products/product-7.jpg',
                    'products/product-8.jpg',
                ],
                'location' => 'Oslo',
                'status' => 'active',
                'listing_type' => 'sale',
                'is_for_sale' => true,
                'sale_price' => 450.00,
            ],
            [
                'title' => 'Bicycle Helmet - Giro',
                'description' => 'Professional cycling helmet with MIPS safety technology. Excellent ventilation and comfortable fit. Size L fits most adults. Perfect for commuting or weekend rides.',
                'category_id' => $categories->where('name', 'Sports & Outdoors')->first()?->id ?? $categories->first()->id,
                'user_id' => $getRandomUserId(),
                'images' => [
                    'products/product-9.jpg',
                    'products/product-10.jpg',
                    'products/product-1.jpg',
                ],
                'location' => 'Bergen',
                'status' => 'active',
                'listing_type' => 'exchange',
                'exchange_categories' => ['Sports & Outdoors', 'Clothing'],
            ],
            [
                'title' => 'Plant Stand - Modern Metal Design',
                'description' => 'Elegant 3-tier plant stand in brushed metal finish. Perfect for displaying indoor plants. Sturdy construction with rubber feet to protect floors. Adds a modern touch to any room.',
                'category_id' => $categories->where('name', 'Home & Garden')->first()?->id ?? $categories->first()->id,
                'user_id' => $getRandomUserId(),
                'images' => [
                    'products/product-2.jpg',
                    'products/product-3.jpg',
                    'products/product-4.jpg',
                ],
                'location' => 'Trondheim',
                'status' => 'active',
                'listing_type' => 'sale',
                'is_for_sale' => true,
                'sale_price' => 45.00,
            ],
            [
                'title' => 'Cookware Set - Stainless Steel 10-Piece',
                'description' => 'Complete cookware set including pots, pans, and lids. High-quality stainless steel with aluminum core for even heat distribution. Compatible with all stovetops including induction. Includes wooden utensil set.',
                'category_id' => $categories->where('name', 'Home & Garden')->first()?->id ?? $categories->first()->id,
                'user_id' => $getRandomUserId(),
                'images' => [
                    'products/product-5.jpg',
                    'products/product-6.jpg',
                    'products/product-7.jpg',
                ],
                'location' => 'Stavanger',
                'status' => 'active',
                'listing_type' => 'sale',
                'is_for_sale' => true,
                'sale_price' => 180.00,
            ],
            [
                'title' => 'Backpacking Tent - REI Half Dome',
                'description' => 'Lightweight 2-person backpacking tent perfect for weekend adventures. Easy setup with color-coded poles. Waterproof rainfly included. Great ventilation and spacious interior.',
                'category_id' => $categories->where('name', 'Sports & Outdoors')->first()?->id ?? $categories->first()->id,
                'user_id' => $getRandomUserId(),
                'images' => [
                    'products/product-8.jpg',
                    'products/product-9.jpg',
                    'products/product-10.jpg',
                ],
                'location' => 'Kristiansand',
                'status' => 'active',
                'is_available_for_rent' => true,
                'rent_price' => 35.00,
                'rent_duration_unit' => 'day',
                'rent_duration_value' => 1,
                'rent_deposit' => 150.00,
                'rent_terms' => 'Tent must be clean and dry when returned. Guy lines and stakes included.',
            ],
        ];

        // Create demo vehicles
        $vehicleProducts = [
            [
                'title' => 'Toyota Corolla 2018 - Excellent Condition',
                'description' => 'Well-maintained Toyota Corolla with low mileage. Perfect for daily commuting. This reliable sedan offers great fuel efficiency and a comfortable ride. Features air conditioning, power steering, and all standard safety features. Regularly serviced with full service history available.',
                'category_id' => $categories->where('name', 'Vehicles')->first()?->id ?? $categories->first()->id,
                'user_id' => $getRandomUserId(),
                'images' => [
                    'https://picsum.photos/600/400?random=10',
                    'https://picsum.photos/600/400?random=11',
                    'https://picsum.photos/600/400?random=12',
                ],
                'location' => 'Oslo',
                'status' => 'active',
                'listing_type' => 'sale',
                'is_for_sale' => true,
                'sale_price' => 180000.00,
                'vehicle_make' => 'Toyota',
                'vehicle_model' => 'Corolla',
                'vehicle_year' => 2018,
                'vehicle_mileage' => 45000,
                'vehicle_fuel_type' => 'petrol',
                'vehicle_transmission' => 'automatic',
                'vehicle_color' => 'White',
                'vehicle_engine_size' => 1.6,
                'vehicle_power' => 132,
                'vehicle_doors' => 4,
            ],
            [
                'title' => 'BMW X3 xDrive30i - Luxury SUV',
                'description' => 'Stunning BMW X3 with all-wheel drive and premium features. This luxury SUV combines performance with elegance. Equipped with leather seats, navigation system, parking sensors, and a powerful turbocharged engine. Perfect for families who want both comfort and driving dynamics.',
                'category_id' => $categories->where('name', 'Vehicles')->first()?->id ?? $categories->first()->id,
                'user_id' => $getRandomUserId(),
                'images' => [
                    'https://picsum.photos/600/400?random=13',
                    'https://picsum.photos/600/400?random=14',
                    'https://picsum.photos/600/400?random=15',
                ],
                'location' => 'Bergen',
                'status' => 'active',
                'listing_type' => 'sale',
                'is_for_sale' => true,
                'sale_price' => 450000.00,
                'vehicle_make' => 'BMW',
                'vehicle_model' => 'X3 xDrive30i',
                'vehicle_year' => 2020,
                'vehicle_mileage' => 25000,
                'vehicle_fuel_type' => 'petrol',
                'vehicle_transmission' => 'automatic',
                'vehicle_color' => 'Black',
                'vehicle_engine_size' => 2.0,
                'vehicle_power' => 252,
                'vehicle_doors' => 5,
            ],
            [
                'title' => 'Volvo XC60 T8 Twin Engine - Hybrid',
                'description' => 'Eco-friendly Volvo XC60 hybrid with plug-in technology. Excellent fuel economy and low emissions. This premium crossover offers the best of both worlds: electric range for city driving and petrol power for longer trips. Features advanced safety systems and Scandinavian design.',
                'category_id' => $categories->where('name', 'Vehicles')->first()?->id ?? $categories->first()->id,
                'user_id' => $getRandomUserId(),
                'images' => [
                    'https://picsum.photos/600/400?random=16',
                    'https://picsum.photos/600/400?random=17',
                    'https://picsum.photos/600/400?random=18',
                ],
                'location' => 'Trondheim',
                'status' => 'active',
                'listing_type' => 'sale',
                'is_for_sale' => true,
                'sale_price' => 520000.00,
                'vehicle_make' => 'Volvo',
                'vehicle_model' => 'XC60 T8 Twin Engine',
                'vehicle_year' => 2021,
                'vehicle_mileage' => 18000,
                'vehicle_fuel_type' => 'hybrid',
                'vehicle_transmission' => 'automatic',
                'vehicle_color' => 'Blue',
                'vehicle_engine_size' => 2.0,
                'vehicle_power' => 390,
                'vehicle_doors' => 5,
            ],
            [
                'title' => 'Tesla Model 3 Long Range - Electric',
                'description' => 'Cutting-edge Tesla Model 3 with impressive range and autopilot. Zero emissions and low running costs. This electric sedan features over-the-air updates, a minimalist interior, and incredible acceleration. Perfect for environmentally conscious drivers who want modern technology.',
                'category_id' => $categories->where('name', 'Vehicles')->first()?->id ?? $categories->first()->id,
                'user_id' => $getRandomUserId(),
                'images' => [
                    'https://picsum.photos/600/400?random=19',
                    'https://picsum.photos/600/400?random=20',
                    'https://picsum.photos/600/400?random=21',
                ],
                'location' => 'Stavanger',
                'status' => 'active',
                'listing_type' => 'sale',
                'is_for_sale' => true,
                'sale_price' => 380000.00,
                'vehicle_make' => 'Tesla',
                'vehicle_model' => 'Model 3 Long Range',
                'vehicle_year' => 2022,
                'vehicle_mileage' => 15000,
                'vehicle_fuel_type' => 'electric',
                'vehicle_transmission' => 'automatic',
                'vehicle_color' => 'Pearl White',
                'vehicle_power' => 283,
                'vehicle_doors' => 4,
            ],
            [
                'title' => 'Audi A4 Avant - Estate Car',
                'description' => 'Spacious Audi A4 Avant with quattro all-wheel drive. Ideal for families and active lifestyles. This premium estate car offers excellent handling, plenty of cargo space, and Audi\'s signature build quality. Features LED headlights, virtual cockpit, and advanced driver assistance systems.',
                'category_id' => $categories->where('name', 'Vehicles')->first()?->id ?? $categories->first()->id,
                'user_id' => $getRandomUserId(),
                'images' => [
                    'https://picsum.photos/600/400?random=22',
                    'https://picsum.photos/600/400?random=23',
                    'https://picsum.photos/600/400?random=24',
                ],
                'location' => 'Kristiansand',
                'status' => 'active',
                'listing_type' => 'sale',
                'is_for_sale' => true,
                'sale_price' => 320000.00,
                'vehicle_make' => 'Audi',
                'vehicle_model' => 'A4 Avant',
                'vehicle_year' => 2019,
                'vehicle_mileage' => 35000,
                'vehicle_fuel_type' => 'diesel',
                'vehicle_transmission' => 'automatic',
                'vehicle_color' => 'Silver',
                'vehicle_engine_size' => 2.0,
                'vehicle_power' => 190,
                'vehicle_doors' => 5,
            ],
        ];

        // Create demo homes
        $homeProducts = [
            [
                'title' => 'Modern 3-Bedroom Apartment in Oslo Center',
                'description' => 'Beautiful modern apartment with city views. Recently renovated with high-end finishes. This spacious 3-bedroom apartment offers an open floor plan, modern kitchen with stainless steel appliances, and hardwood floors throughout. Located in the heart of Oslo with easy access to public transportation and amenities.',
                'category_id' => $categories->where('name', 'Real Estate')->first()?->id ?? $categories->first()->id,
                'user_id' => $getRandomUserId(),
                'images' => [
                    'products/SsX7NKzqqyqJ66pDEvWIBcj5uyxLWFLWs3LVoFJY.jpg',
                    'products/v4izxAMIrkfnDbhuQml1iLoIqOfmGVJ9MvAD0tnT.jpg',
                    'products/UkUBuEnsEWurlDVY2hVbCFYS3rI1lVHFAUSrB6iZ.jpg',
                ],
                'location' => 'Oslo',
                'status' => 'active',
                'listing_type' => 'sale',
                'is_for_sale' => true,
                'sale_price' => 4500000.00,
                'house_property_type' => 'apartment',
                'house_rooms' => 4,
                'house_bedrooms' => 3,
                'house_bathrooms' => 2,
                'house_living_area' => 85.0,
                'house_plot_size' => null,
                'house_year_built' => 2015,
                'house_energy_rating' => 'b',
                'house_ownership_type' => 'freehold',
                'house_floor' => 4,
                'house_elevator' => true,
                'house_balcony' => true,
                'house_parking' => 'parking_space',
                'house_heating_type' => 'district_heating',
                'house_new_construction' => false,
            ],
            [
                'title' => 'Charming Detached House in Bergen',
                'description' => 'Cozy family home with garden and garage. Perfect for families seeking a peaceful neighborhood. This charming detached house features a bright living room, modern kitchen, three comfortable bedrooms, and a beautiful garden. Includes a garage and parking for two cars. Close to schools and shopping.',
                'category_id' => $categories->where('name', 'Real Estate')->first()?->id ?? $categories->first()->id,
                'user_id' => $getRandomUserId(),
                'images' => [
                    'products/SsX7NKzqqyqJ66pDEvWIBcj5uyxLWFLWs3LVoFJY.jpg',
                    'products/v4izxAMIrkfnDbhuQml1iLoIqOfmGVJ9MvAD0tnT.jpg',
                    'products/UkUBuEnsEWurlDVY2hVbCFYS3rI1lVHFAUSrB6iZ.jpg',
                ],
                'location' => 'Bergen',
                'status' => 'active',
                'listing_type' => 'sale',
                'is_for_sale' => true,
                'sale_price' => 3800000.00,
                'house_property_type' => 'house',
                'house_rooms' => 5,
                'house_bedrooms' => 3,
                'house_bathrooms' => 1,
                'house_living_area' => 120.0,
                'house_plot_size' => 400.0,
                'house_year_built' => 1995,
                'house_energy_rating' => 'c',
                'house_ownership_type' => 'freehold',
                'house_parking' => 'garage',
                'house_heating_type' => 'oil',
                'house_balcony' => false,
                'house_new_construction' => false,
            ],
            [
                'title' => 'Luxury Villa with Sea View in Trondheim',
                'description' => 'Stunning modern villa overlooking the fjord. Premium finishes and expansive outdoor spaces. This architectural masterpiece features floor-to-ceiling windows, an open-concept design, and panoramic sea views. Includes a private dock, swimming pool, and landscaped gardens. Perfect for entertaining and luxury living.',
                'category_id' => $categories->where('name', 'Real Estate')->first()?->id ?? $categories->first()->id,
                'user_id' => $getRandomUserId(),
                'images' => [
                    'products/SsX7NKzqqyqJ66pDEvWIBcj5uyxLWFLWs3LVoFJY.jpg',
                    'products/v4izxAMIrkfnDbhuQml1iLoIqOfmGVJ9MvAD0tnT.jpg',
                    'products/UkUBuEnsEWurlDVY2hVbCFYS3rI1lVHFAUSrB6iZ.jpg',
                ],
                'location' => 'Trondheim',
                'status' => 'active',
                'listing_type' => 'sale',
                'is_for_sale' => true,
                'sale_price' => 8500000.00,
                'house_property_type' => 'villa',
                'house_rooms' => 8,
                'house_bedrooms' => 4,
                'house_bathrooms' => 3,
                'house_living_area' => 250.0,
                'house_plot_size' => 1200.0,
                'house_year_built' => 2020,
                'house_energy_rating' => 'a',
                'house_ownership_type' => 'freehold',
                'house_parking' => 'garage',
                'house_heating_type' => 'heat_pump',
                'house_balcony' => true,
                'house_new_construction' => true,
            ],
            [
                'title' => 'Cozy Townhouse in Stavanger',
                'description' => 'Modern townhouse with rooftop terrace. Ideal for young professionals and small families. This contemporary townhouse offers three levels of living space, a private terrace, and modern amenities. Located in a vibrant neighborhood with restaurants, shops, and cultural attractions nearby.',
                'category_id' => $categories->where('name', 'Real Estate')->first()?->id ?? $categories->first()->id,
                'user_id' => $getRandomUserId(),
                'images' => [
                    'products/SsX7NKzqqyqJ66pDEvWIBcj5uyxLWFLWs3LVoFJY.jpg',
                    'products/v4izxAMIrkfnDbhuQml1iLoIqOfmGVJ9MvAD0tnT.jpg',
                    'products/UkUBuEnsEWurlDVY2hVbCFYS3rI1lVHFAUSrB6iZ.jpg',
                ],
                'location' => 'Stavanger',
                'status' => 'active',
                'listing_type' => 'sale',
                'is_for_sale' => true,
                'sale_price' => 3200000.00,
                'house_property_type' => 'townhouse',
                'house_rooms' => 6,
                'house_bedrooms' => 3,
                'house_bathrooms' => 2,
                'house_living_area' => 95.0,
                'house_plot_size' => 80.0,
                'house_year_built' => 2018,
                'house_energy_rating' => 'b',
                'house_ownership_type' => 'freehold',
                'house_parking' => 'parking_space',
                'house_heating_type' => 'electric',
                'house_balcony' => true,
                'house_elevator' => false,
                'house_new_construction' => false,
            ],
            [
                'title' => 'Scandinavian Cottage in Kristiansand',
                'description' => 'Traditional Norwegian cottage with modern updates. Surrounded by nature and tranquility. This charming cottage combines traditional Norwegian architecture with modern comforts. Features a wood-burning stove, exposed beams, and a peaceful garden. Perfect for those seeking a retreat from city life.',
                'category_id' => $categories->where('name', 'Real Estate')->first()?->id ?? $categories->first()->id,
                'user_id' => $getRandomUserId(),
                'images' => [
                    'products/SsX7NKzqqyqJ66pDEvWIBcj5uyxLWFLWs3LVoFJY.jpg',
                    'products/v4izxAMIrkfnDbhuQml1iLoIqOfmGVJ9MvAD0tnT.jpg',
                    'products/UkUBuEnsEWurlDVY2hVbCFYS3rI1lVHFAUSrB6iZ.jpg',
                ],
                'location' => 'Kristiansand',
                'status' => 'active',
                'listing_type' => 'sale',
                'is_for_sale' => true,
                'sale_price' => 2800000.00,
                'house_property_type' => 'cottage',
                'house_rooms' => 4,
                'house_bedrooms' => 2,
                'house_bathrooms' => 1,
                'house_living_area' => 75.0,
                'house_plot_size' => 600.0,
                'house_year_built' => 1985,
                'house_energy_rating' => 'd',
                'house_ownership_type' => 'freehold',
                'house_parking' => 'none',
                'house_heating_type' => 'wood',
                'house_balcony' => false,
                'house_elevator' => false,
                'house_new_construction' => false,
            ],
        ];

        // Create demo products
        foreach ($demoProducts as $productData) {
            Product::create($productData);
        }

        // Create vehicle products
        foreach ($vehicleProducts as $productData) {
            Product::create($productData);
        }

        // Create home products
        foreach ($homeProducts as $productData) {
            Product::create($productData);
        }
    }
}
