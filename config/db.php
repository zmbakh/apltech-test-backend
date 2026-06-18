<?php

return [
    'class' => \yii\db\Connection::class,
    'dsn' => 'mysql:host=' . (getenv('DB_HOST') ?: 'db') . ';dbname=' . (getenv('DB_NAME') ?: 'product_api'),
    'username' => getenv('DB_USER') ?: 'yii',
    'password' => getenv('DB_PASSWORD') ?: 'secret',
    'charset' => 'utf8mb4',

    // Schema cache options (for production environment)
    //'enableSchemaCache' => true,
    //'schemaCacheDuration' => 60,
    //'schemaCache' => 'cache',
];
