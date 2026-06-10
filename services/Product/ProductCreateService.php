<?php

declare(strict_types=1);

namespace app\services\Product;

use app\models\Product;

readonly class ProductCreateService
{
    public function create(array $data): Product
    {
        $product = new Product();
        $product->load($data, '');
        $product->save();

        return $product;
    }
}
