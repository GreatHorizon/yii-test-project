<?php

namespace frontend\controllers;

use DateTimeImmutable;
use Yii;
use yii\base\Exception;
use yii\web\Controller;
use yii\web\MethodNotAllowedHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use common\models\User;
use common\models\AccessToken;
use yii\web\ServerErrorHttpException;

class LoginController extends Controller
{
    public $enableCsrfValidation = false;

    public function behaviors(): array
    {
        $behaviors = parent::behaviors();
        $behaviors['contentNegotiator'] = [
            'class' => 'yii\filters\ContentNegotiator',
            'formats' => [
                'application/json' => Response::FORMAT_JSON,
            ]
        ];

        return $behaviors;
    }

    /**
     * @throws NotFoundHttpException
     * @throws Exception
     */
    public function actionIndex()
    {
        $request = Yii::$app->request;

        if ($request->isPost) {
            return $this->login($request);
        } else {
            throw new MethodNotAllowedHttpException;
        }
    }

    /**
     * @throws Exception
     */
    private function login($request): array
    {
        $username = $request->post('username');
        $password = $request->post('password');

        if ($password == null || $username == null) {
            throw new ServerErrorHttpException('Username and password should not be empty');
        }

        $user = User::findOne(['username' => $username]);

        if ($user == null || !$user->validatePassword($password)) {
            throw new NotFoundHttpException('User not found');
        }

        $accessToken = $this->createAccessToken($user->userId);
        $accessToken->save();

        return ['accessToken' => $accessToken->token];
    }

    /**
     * @throws Exception
     */
    private static function createAccessToken(int $userId): AccessToken
    {
        $accessToken = new AccessToken();
        $date = new DateTimeImmutable();

        $accessToken->userId = $userId;
        $accessToken->token = AccessToken::generateToken();
        $accessToken->createdAt = $date->getTimestamp();

        return $accessToken;
    }
}
