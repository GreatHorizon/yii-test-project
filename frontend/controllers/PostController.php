<?php

namespace frontend\controllers;

use yii\rest\ActiveController;
use yii\web\Response;

class PostController extends ActiveController
{
    public $modelClass = 'backend\models\Post';

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


    public function actionIndex(): string
    {
        return $this->render('index');
    }



}
