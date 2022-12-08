<?php

namespace frontend\controllers;

use frontend\models\user\GetUsersForm;
use Symfony\Component\CssSelector\Exception\InternalErrorException;
use yii\web\MethodNotAllowedHttpException;
use yii\web\NotFoundHttpException;
use yii\web\ServerErrorHttpException;

class UserController extends BaseController
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
     * @throws InternalErrorException
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
        $accessToken = \Yii::$app->request->get('accessToken');


        if ($this->checkIdentity($accessToken) && $model->getUsers()) {
            return $model->serializeUsers();
        } else {
            return $model->getErrors();
        }
    }
}
