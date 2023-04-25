<?php
namespace App\Services;

use App\Models\Product;
use App\Models\Employee;
use Illuminate\Support\Facades\DB;
  
class ProductService
{
    public function store(array $req)
    {
        Id_code('products', $req['product_id']);
        Product::create($req);
    }

    public function update(array $req, Product $product)
    {
        $product->update($req);
    }
    public function destroy(Product $product)
    {
        DB::transaction(function () use ($product) {
            $product->delete();
            $product->UserAssignProducts()->delete();

        });
    }

}