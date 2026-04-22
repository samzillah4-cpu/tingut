<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\WebsiteMenu;

class WebsiteMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $menus = [
            [
                'name' => 'Home',
                'url' => '/',
                'order' => 1,
                'is_active' => true,
                'open_in_new_tab' => false,
            ],
            [
                'name' => 'Products',
                'url' => '/products',
                'order' => 2,
                'is_active' => true,
                'open_in_new_tab' => false,
            ],
            [
                'name' => 'Categories',
                'url' => '/categories',
                'order' => 3,
                'is_active' => true,
                'open_in_new_tab' => false,
            ],
            [
                'name' => 'About',
                'url' => '/about',
                'order' => 4,
                'is_active' => true,
                'open_in_new_tab' => false,
            ],
            [
                'name' => 'Contact',
                'url' => '/contact',
                'order' => 5,
                'is_active' => true,
                'open_in_new_tab' => false,
            ],
        ];

        foreach ($menus as $menu) {
            WebsiteMenu::create($menu);
        }
    }
}
