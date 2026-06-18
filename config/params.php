<?php

return [
    'adminEmail' => 'admin@example.com',
    'senderEmail' => 'noreply@example.com',
    'senderName' => 'Example.com mailer',
    'jwtSecret' => getenv('JWT_SECRET') ?: '220da0a2a5a9938888342e0e1a0cb8e0e91c3a7f7dd8124b04c2373221559b3c',
    'externalProductsUrl' => 'http://localhost/external-api/products.json',
    'corsOrigin' => getenv('CORS_ORIGIN') ?: '',
];
