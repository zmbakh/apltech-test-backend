<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'container' => [
        'singletons' => [
            \yii\mail\MailerInterface::class => [
                'class' => \yii\symfonymailer\Mailer::class,
                // send all mails to a file by default.
                'useFileTransport' => true,
                'viewPath' => '@app/mail',
            ],
        ],
        'definitions' => [
            \app\services\Auth\IssueJwtTokenService::class => static fn() => new \app\services\Auth\IssueJwtTokenService(
                \Yii::$app->params['jwtSecret'],
            ),
            \app\services\Auth\ExtractJwtUserService::class => static fn() => new \app\services\Auth\ExtractJwtUserService(
                \Yii::$app->params['jwtSecret'],
            ),
            \app\services\Product\BrandPriceService\BrandPriceService::class => static fn() => new \app\services\Product\BrandPriceService\BrandPriceService(
                new \app\services\Product\BrandPriceService\DbProductSource(),
                new \app\services\Product\BrandPriceService\JsonApiProductSource(\Yii::$app->params['externalProductsUrl']),
            ),
        ],
    ],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'ftL3lR8Mb4LLOG2I9wmaJtf8v-x95fyJ',
            'parsers' => [
                'application/json' => \yii\web\JsonParser::class,
            ],
        ],
        'cache' => [
            'class' => \yii\caching\FileCache::class,
        ],
        'user' => [
            'identityClass' => \app\models\User::class,
            'enableAutoLogin' => false,
            'enableSession' => false,
            'loginUrl' => null,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => \yii\mail\MailerInterface::class,
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => \yii\log\FileTarget::class,
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                ['pattern' => 'api/<path:.*>', 'route' => 'auth/preflight', 'verb' => ['OPTIONS']],
                'POST api/auth/login' => 'auth/login',
                'GET api/products' => 'product/index',
                'GET api/product/brand/<name:[^\/]+>' => 'product/brand',
                'GET api/product/<id:\d+>' => 'product/view',
                'POST api/product/create' => 'product/create',
                'PATCH api/product/update/<id:\d+>' => 'product/update',
            ],
        ],
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => \yii\debug\Module::class,
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => \yii\gii\Module::class,
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
