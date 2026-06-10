<?php

declare(strict_types=1);

namespace app\services\Product\BrandPriceService;

readonly class JsonApiProductSource implements ProductSourceInterface
{
    public function __construct(
        private string $url,
    ) {
    }

    /**
     * @inheritDoc
     */
    public function getByBrand(string $brand): array
    {
        $items = $this->getItems();

        $result = [];

        foreach ((array) $items as $item) {
            if (
                isset($item['id'], $item['price'], $item['brand_name'])
                && strcasecmp((string) $item['brand_name'], $brand) === 0
            ) {
                $result[] = ['id' => (int) $item['id'], 'price' => (int) $item['price']];
            }
        }

        return $result;
    }

    protected function getItems()
    {
        try {
            $items = json_decode($this->readJsonFile(), true, 512, JSON_THROW_ON_ERROR);
        } catch (\JsonException $e) {
            \Yii::warning("External product API returned invalid JSON: {$e->getMessage()}", __METHOD__);
            return [];
        }

        return $items;
    }

    protected function readJsonFile(): string
    {
        $json = @file_get_contents($this->url);

        if ($json === false) {
            \Yii::warning("External product API unavailable: {$this->url}", __METHOD__);
            return '';
        }

        return $json;
    }
}
