<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Kind;
use App\Models\Order;
use App\Models\Product;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        User::factory(10)->create();
        Kind::factory(4)->create();
        Product::factory(20)->create()->each(function($Product)
        {
            $ids = array(random_int(1, 4));
            $sliced = array_slice($ids, 0, 1);
            $Product->kindproducts()->attach($sliced);
        });
        Order::factory(50)->create()->each(function($Order)
        {
            $ids = range(1, 20);
            shuffle($ids);//trộn
            $sliced = array_slice($ids, 1, 10);
            $Order->products()->attach($sliced);
            
        });
    }
}
