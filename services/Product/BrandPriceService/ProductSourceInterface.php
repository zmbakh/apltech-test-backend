<?php

declare(strict_types=1);

namespace app\services\Product\BrandPriceService;

interface ProductSourceInterface
{
    /**
     * @param string $brand
     * @return array<array{id: int, price: int}>
     */
    public function getByBrand(string $brand): array;
}
