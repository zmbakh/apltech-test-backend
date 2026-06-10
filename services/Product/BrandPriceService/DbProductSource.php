<?php

declare(strict_types=1);

namespace app\services\Product\BrandPriceService;

use app\models\Product;

readonly class DbProductSource implements ProductSourceInterface
{
    /**
     * @inheritDoc
     */
    public function getByBrand(string $brand): array
    {
        $products = $this->getProducts($brand);

        return array_map(
            static fn(array $r): array => ['id' => (int) $r['id'], 'price' => (int) $r['price']],
            $products,
        );
    }

    private function getProducts(string $brand): array
    {
        return Product::find()
            ->select(['id', 'price'])
            ->where(['brand_name' => $brand])
            ->asArray()
            ->all();
    }
}
