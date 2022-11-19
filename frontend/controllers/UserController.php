<?php

namespace frontend\controllers;

use frontend\models\user\GetUsersForm;
use yii\web\Controller;
use yii\web\MethodNotAllowedHttpException;
use yii\web\NotFoundHttpException;
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
     * @throws NotFoundHttpException
     * @SWG\Get(path="user/all-users",
     *     tags={"User"},
     *     summary="Get users list",
     *     @SWG\Parameter(
     *         name="accessToken",
     *         in="path",
     *         description="User access token",
     *         required=true,
     *         type="string",
     *     ),
     *     @SWG\Response(
     *         response = 200,
     *         description = "User collection response",
     *         @SWG\Schema(
     *             type="array",
     *             @SWG\Items(ref = "#/definitions/User")
     *         ),
     *     )
     * )
     */
    public function actionAllUsers(): array
    {
        $model = new GetUsersForm();
        $model->load(\Yii::$app->request->get(), '');

        if ($model->getUsers()) {
            return $model->serializeUsers();
        } else {
            return $model->getErrors();
        }
    }
}
