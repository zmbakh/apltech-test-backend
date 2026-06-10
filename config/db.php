<?php

return [
    'class' => \yii\db\Connection::class,
    'dsn' => 'mysql:host=db;dbname=product_api',
    'username' => 'yii',
    'password' => 'secret',
    'charset' => 'utf8mb4',

    // Schema cache options (for production environment)
    //'enableSchemaCache' => true,
    //'schemaCacheDuration' => 60,
    //'schemaCache' => 'cache',
];
