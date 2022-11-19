<?php

namespace frontend\controllers;

use LoginModel;
use yii\base\Exception;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class AuthController extends Controller
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
     * @SWG\Post(path="auth/login",
     *     tags={"Auth"},
     *     summary="Auth by username and password",
     *     @SWG\Parameter(
     *         name="username",
     *         in="body",
     *         description="Username",
     *         required=true,
     *         type="string",
     *     ),
     *     @SWG\Parameter(
     *         name="password",
     *         in="body",
     *         description="Password",
     *         required=true,
     *         type="string",
     *     ),
     *     @SWG\Response(
     *         response = 200,
     *         description = "Access token response",
     *     )
     * )
     */
    public function actionLogin()
    {

        $model = new LoginModel();
        $model->load(\Yii::$app->request->post(), '');

        if ($model->login()) {
            return $model->serializeToken();
        } else {
            return $model->getErrors();
        }
    }
}
