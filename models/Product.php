<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "product".
 *
 * @property int $id
 * @property string $name
 * @property string|null $category_name
 * @property string|null $brand_name
 * @property int $price
 * @property int|null $rrp_price
 * @property int $status
 */
class Product extends ActiveRecord
{
    public const int STATUS_IN_STOCK = 1;
    public const int STATUS_ON_ORDER = 2;

    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%product}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'price'], 'required'],
            [['name'], 'string', 'max' => 255],
            [['category_name', 'brand_name'], 'string', 'max' => 128],

            ['price', 'integer', 'min' => 1],
            ['rrp_price', 'integer', 'min' => 1],

            ['status', 'in', 'range' => [self::STATUS_IN_STOCK, self::STATUS_ON_ORDER]],
            ['status', 'default', 'value' => self::STATUS_IN_STOCK],
        ];
    }
}
