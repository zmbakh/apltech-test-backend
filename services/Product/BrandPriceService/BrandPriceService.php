<?php

declare(strict_types=1);

namespace app\services\Product\BrandPriceService;

readonly class BrandPriceService
{
    /** @var ProductSourceInterface[] */
    protected array $sources;

    public function __construct(ProductSourceInterface ...$sources)
    {
        $this->sources = $sources;
    }

    public function getMinMax(string $brand): ?array
    {
        $items = [];

        foreach ($this->sources as $source) {
            $items = array_merge($items, $source->getByBrand($brand));
        }

        if ($items === []) {
            return null;
        }

        $min = $max = $items[0];

        foreach ($items as $item) {
            if ($item['price'] < $min['price']) {
                $min = $item;
            }
            if ($item['price'] > $max['price']) {
                $max = $item;
            }
        }

        return [
            ['min' => ['id' => $min['id'], 'price' => $min['price']]],
            ['max' => ['id' => $max['id'], 'price' => $max['price']]],
        ];
    }
}
