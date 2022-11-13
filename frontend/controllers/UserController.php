<?php

namespace frontend\controllers;

use common\models\User;
use frontend\models\post\CreatePostForm;
use frontend\models\user\GetUsersForm;
use Yii;
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
     * @SWG\Get(path="/user",
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
    public function actionIndex(): array
    {
        $model = new GetUsersForm();
        $model->load(\Yii::$app->request->get(), '');

        if ($model->getUsers()) {
            return $model->getSerializedUsers();
        } else {
            return $model->getErrors();
        }
    }
}
