<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%product}}`.
 */
class m260610_060310_create_product_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%product}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull(),
            'category_name' => $this->string(128)->null(),
            'brand_name' => $this->string(128)->null(),
            'price' => $this->integer()->unsigned()->notNull(),
            'rrp_price' => $this->integer()->unsigned()->null(),
            'status' => $this->tinyInteger()->notNull()->defaultValue(1),
        ]);

        $this->createIndex('idx-product-brand_name', '{{%product}}', 'brand_name');
        $this->createIndex('idx-product-brand_price', '{{%product}}', ['brand_name', 'price']);
        $this->createIndex('idx-product-status', '{{%product}}', 'status');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%product}}');
    }
}
