<?php

namespace frontend\controllers;

use common\models\User;
use yii\base\Model;
use yii\web\Controller;

abstract class BaseController extends Controller
{
    public $enableCsrfValidation = false;

    public Model $model;

    public function checkIdentity(): bool
    {
        $accessToken = \Yii::$app->request->get('accessToken');

        if (empty($accessToken)) {
            $this->onError('Access token not found');
            return false;
        }

        $user = User::findIdentityByAccessToken($accessToken);

        if (empty($user)) {
            $this->onError('User not found');
            return false;
        }

        \Yii::$app->user->setIdentity($user);

        return true;
    }


    public function onError(string $error)
    {
        $this->model->addError('error', $error);
    }
}