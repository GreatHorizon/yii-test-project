<?php

namespace frontend\controllers;

class PostController extends \yii\rest\ActiveController
{

    public $modelClass = 'backend\models\Post';

    public function actionIndex()
    {
        return $this->render('index');
    }

}
