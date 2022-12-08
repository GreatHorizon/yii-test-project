<?php

namespace frontend\controllers;

use common\models\User;
use Symfony\Component\CssSelector\Exception\InternalErrorException;
use yii\web\Controller;

abstract class BaseController extends Controller
{
    public $enableCsrfValidation = false;

    /**
     * @throws InternalErrorException
     */
    public function checkIdentity($accessToken): bool
    {
        if (empty($accessToken)) {
            throw new InternalErrorException('Access token not found');
        }

        $user = User::findIdentityByAccessToken($accessToken);

        if (empty($user)) {
            throw new InternalErrorException('User not found');
        }

        \Yii::$app->user->setIdentity($user);

        return true;
    }
}