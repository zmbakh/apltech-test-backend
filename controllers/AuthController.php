<?php

namespace app\controllers;

use app\models\User;
use app\services\Auth\IssueJwtTokenService;
use yii\rest\Controller;
use yii\web\UnauthorizedHttpException;

final class AuthController extends Controller
{
    public function __construct(
        $id,
        $module,
        private readonly IssueJwtTokenService $issueJwtTokenService,
        $config = [],
    ) {
        parent::__construct($id, $module, $config);
    }

    public function actionLogin(): array
    {
        $body = \Yii::$app->request->bodyParams;

        $username = (string) ($body['username'] ?? '');
        $password = (string) ($body['password'] ?? '');

        $user = $username !== '' ? User::findByUsername($username) : null;

        if ($user === null || !$user->validatePassword($password)) {
            throw new UnauthorizedHttpException('Неверный логин или пароль.');
        }

        return [
            'token' => $this->issueJwtTokenService->issueToken($user->getId()),
            'token_type' => 'Bearer',
            'expires_in' => IssueJwtTokenService::TOKEN_EXPIRES_IN,
        ];
    }
}
