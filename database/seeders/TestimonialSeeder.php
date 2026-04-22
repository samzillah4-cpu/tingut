<?php

namespace Database\Seeders;

use App\Models\Testimonial;
use Illuminate\Database\Seeder;

class TestimonialSeeder extends Seeder
{
    public function run(): void
    {
        $testimonials = [
            [
                'customer_name' => 'Sarah Johnson',
                'customer_position' => 'Marketing Director',
                'testimony' => 'TingUt.no has completely transformed how I exchange items. The platform is incredibly user-friendly and trustworthy. I\'ve successfully exchanged several high-value items without any issues. The community is amazing and the verification process gives me peace of mind.',
                'profile_picture' => 'testimonials/FKj7qDCjV9ZW5jwkw8EcPfKa95FYRJxsbXbaHy3B.jpg',
                'is_active' => true,
                'order' => 1,
            ],
            [
                'customer_name' => 'Marcus Chen',
                'customer_position' => 'Software Engineer',
                'testimony' => 'As someone who\'s always looking for unique tech gadgets, TingUt.no has been a game-changer. I\'ve found rare vintage cameras and modern accessories that I couldn\'t find anywhere else. The exchange process is smooth and secure.',
                'profile_picture' => 'testimonials/FPC1rVFUYVLQV8grNut70KmPZ64nVFF7FYIK85mm.jpg',
                'is_active' => true,
                'order' => 2,
            ],
            [
                'customer_name' => 'Emma Larsson',
                'customer_position' => 'Fashion Designer',
                'testimony' => 'The quality of items on TingUt.no is outstanding. I\'ve exchanged designer clothing pieces and received items in perfect condition. The platform\'s focus on sustainability aligns perfectly with my values. Highly recommended!',
                'profile_picture' => 'testimonials/mXh8Be2tdYY1mreJm5DsPGQtQAcrIHvbDLRNQhq7.png',
                'is_active' => true,
                'order' => 3,
            ],
            [
                'customer_name' => 'David Rodriguez',
                'customer_position' => 'Small Business Owner',
                'testimony' => 'TingUt.no helped me upgrade my entire home office setup. From ergonomic chairs to high-quality monitors, I found everything I needed through exchanges. The savings compared to buying new are incredible, and I\'ve made some great connections in the process.',
                'profile_picture' => null,
                'is_active' => true,
                'order' => 4,
            ],
            [
                'customer_name' => 'Anna Kowalski',
                'customer_position' => 'Environmental Consultant',
                'testimony' => 'I love how TingUt.no promotes sustainable consumption. Instead of buying new items, I can exchange what I no longer need for something useful. It\'s not just economical, it\'s also good for the planet. The platform makes it so easy to participate.',
                'profile_picture' => null,
                'is_active' => true,
                'order' => 5,
            ],
        ];

        foreach ($testimonials as $testimonialData) {
            Testimonial::create($testimonialData);
        }
    }
}
