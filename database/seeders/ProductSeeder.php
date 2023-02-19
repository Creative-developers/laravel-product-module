<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Product;
use App\Models\User;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Create the random first user
        User::create([
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'password' => bcrypt('password'),
        ]);

        // Create a product and assigned the first user id
        Product::create([
            'name' => 'Product 1',
            'price' => 5.99,
            'user_id' => User::first()->id,
            'status' => 'available',
            'type' => 'item',
        ]);
    }
}
