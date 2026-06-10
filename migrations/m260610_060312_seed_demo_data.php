<?php

use yii\db\Migration;

class m260610_060312_seed_demo_data extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert('{{%user}}', [
            'username' => 'admin',
            'password_hash' => Yii::$app->security->generatePasswordHash('admin123'),
            'created_at' => time(),
            'updated_at' => time(),
        ]);

        $faker = Faker\Factory::create();

        $brands = ['Dell', 'Lenovo', 'Apple', 'Samsung', 'HP', 'Asus'];
        $categories = ['Laptops', 'Smartphones', 'Tablets', 'Monitors', 'Accessories'];

        $rows = [];
        for ($i = 0; $i < 50; $i++) {
            $price = $faker->numberBetween(10, 2500) * 100; // never 0, round-ish numbers
            $rows[] = [
                $faker->words(3, true),                       // name
                $faker->randomElement($categories),           // category_name
                $faker->randomElement($brands),               // brand_name
                $price,                                       // price
                (int) round($price * $faker->randomFloat(2, 1.05, 1.25)), // rrp_price > price
                $faker->boolean(75) ? 1 : 2,                  // status: ~75% in stock
            ];
        }

        $this->batchInsert(
            '{{%product}}',
            ['name', 'category_name', 'brand_name', 'price', 'rrp_price', 'status'],
            $rows
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
    }
}
