<?php

namespace frontend\controllers;

use common\models\User;
use Yii;
use yii\web\Controller;
use yii\web\MethodNotAllowedHttpException;
use yii\web\ServerErrorHttpException;

class UserController extends Controller
{

    public function behaviors(): array
    {
        $behaviors = parent::behaviors();
        $behaviors['contentNegotiator'] = [
            'class' => 'yii\filters\ContentNegotiator',
            'formats' => [
                'application/json' => \yii\web\Response::FORMAT_JSON,
            ]
        ];

        return $behaviors;
    }


    /**
     * @throws MethodNotAllowedHttpException
     * @throws ServerErrorHttpException
     */
    public function actionIndex(): array
    {
        $request = Yii::$app->request;

        if ($request->isGet) {
            return $this->getAllUsers($request);
        } else {
            throw new MethodNotAllowedHttpException;
        }
    }


    /**
     * @throws ServerErrorHttpException
     */
    private function getAllUsers($request) : array {
        $accessToken = $request->get('accessToken');

        if ($accessToken == null) {
            throw new ServerErrorHttpException('AccessToken should not be empty');
        }

        $users = [];

        $searchResult = User::find()->all();

        if (empty($searchResult)) {
          return [];
        }

        foreach ($searchResult as $user) {
            ///Potentially polymorphic call. ActiveRecord does not have members in its hierarchy
            $users[] = $user->serialize();
        }

        return $users;
    }


}
