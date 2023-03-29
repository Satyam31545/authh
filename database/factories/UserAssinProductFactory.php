<?php

namespace Database\Factories;
use App\Models\UserAssinProduct;
use App\Models\Product;

use Illuminate\Database\Eloquent\Factories\Factory;

class UserAssinProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'product_id' => Product::all()->random()->id,
            'quantity' => 15,
        ];
    }
}
