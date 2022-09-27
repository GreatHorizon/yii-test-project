<?php

namespace frontend\controllers;

use common\models\User;
use yii\rest\ActiveController;

class UserController extends ActiveController
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

    public $modelClass = 'common\models\User';

    public function actionIndex(): string
    {
        return $this->render('index');
    }

    public function actionView($id)
    {
        return User::findIdentity($id);
    }

}
