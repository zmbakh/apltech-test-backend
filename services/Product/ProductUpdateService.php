<?php

declare(strict_types=1);

namespace app\services\Product;

use app\models\Product;

readonly class ProductUpdateService
{
    public function update(Product $product, array $data): Product
    {
        $product->load($data, '');
        $product->save();

        return $product;
    }
}
