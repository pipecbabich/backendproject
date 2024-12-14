<?php

namespace App\Services\Product;

use App\Enums\AttributeName;
use App\Models\Product;

class ProductService
{
    private Product $product;

    public function update(array $data) 
    {
        $this->product->update($data);

        return $this->product;
    }

    public function create(array $data)
    {
        $product = Product::create($data);
        $this->setProduct($product);
        $this->createAttribute();
        return $product;
    }
    
    public function createAttribute()
    {
        foreach(AttributeName::cases() as $attribute) {
            $this->product->attribute()->create([
                'name' => $attribute,
                'value' => '',
                'product_id' => $this->product->id
            ]);
        }
    }

    public function setProduct(Product $product)
    {
        $this->product = $product;
        
        return $this;
    }
}