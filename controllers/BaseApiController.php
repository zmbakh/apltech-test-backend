<?php

declare(strict_types=1);

namespace app\controllers;

use yii\filters\Cors;
use yii\rest\Controller;

abstract class BaseApiController extends Controller
{
    public function behaviors(): array
    {
        $behaviors = parent::behaviors();

        $origin = \Yii::$app->params['corsOrigin'];
        if ($origin !== '') {
            $behaviors['corsFilter'] = [
                'class' => Cors::class,
                'cors' => [
                    'Origin' => [$origin],
                    'Access-Control-Request-Method' => ['GET', 'POST', 'PATCH', 'OPTIONS'],
                    'Access-Control-Request-Headers' => ['*'],
                ],
            ];
        }

        return $behaviors;
    }

    public function actionPreflight(): void {}
}
