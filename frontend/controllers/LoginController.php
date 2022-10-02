<?php

namespace frontend\controllers;

use DateTimeImmutable;
use Yii;
use yii\base\Exception;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use common\models\User;
use common\models\AccessToken;

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
     */
    public function actionIndex()
    {
        $request = Yii::$app->request;

        if ($request->isPost) {
            return $this->login($request);
        } else {
            throw new \yii\web\MethodNotAllowedHttpException;
        }
    }


    /**
     * @throws Exception
     */
    private function login($request) : array {
        $username = $request->post('username');
        $password = $request->post('password');

        if ($password == null || $username == null) {
            throw new \yii\web\ServerErrorHttpException('Username and password should not be empty');
        }

        $user = User::findOne(['username' => $username]);

        if ($user != null) {
            $accessToken = new AccessToken();
            $date = new DateTimeImmutable();

            $accessToken->userId = $user->userId;
            $accessToken->token = Yii::$app->security->generateRandomString() . '_' . time();
            $accessToken->createdAt = $date->getTimestamp();

            $accessToken->save();

            return ['accessToken' => $accessToken->token];
        } else {
            throw new \yii\web\NotFoundHttpException('User not found');
        }
    }

}
