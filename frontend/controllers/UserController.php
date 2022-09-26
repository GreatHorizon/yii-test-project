<?php

namespace frontend\controllers;

use yii\rest\ActiveController;

class UserController extends ActiveController
{

    public $modelClass = 'common\models\User';

    public function actionIndex()
    {
        return $this->render('index');
    }

}
