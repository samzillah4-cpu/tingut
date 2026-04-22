<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CheckSaleProducts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-sale-products';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check products available for sale';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $saleProducts = \App\Models\Product::where('is_for_sale', true)->get();

        $this->info('Products available for sale: ' . $saleProducts->count());

        if ($saleProducts->count() > 0) {
            $this->table(
                ['ID', 'Title', 'Price (NOK)', 'Seller'],
                $saleProducts->map(function ($product) {
                    return [
                        $product->id,
                        $product->title,
                        number_format($product->sale_price, 2),
                        $product->user->name ?? 'Unknown'
                    ];
                })->toArray()
            );
        } else {
            $this->warn('No products are currently marked for sale.');
        }
    }
}
