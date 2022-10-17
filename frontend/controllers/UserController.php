<?php

namespace frontend\controllers;

use common\models\User;
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
        $request = Yii::$app->request;

        if (!$request->isGet) {
            throw new MethodNotAllowedHttpException;
        }

        $accessToken = $request->get('accessToken');
        $offset = $request->get('offset');
        $limit = $request->get('limit');

        if ($accessToken == null) {
            throw new ServerErrorHttpException('AccessToken should not be empty');
        }

        if (empty($foundUser)) {
            throw new NotFoundHttpException('User not found');
        }

        $query = User::find()
            ->offset($offset ?? 0)
            ->limit($limit ?? 1000)
            ->orderBy('createdAt');

        $users = [];

        foreach ($query->each() as $user) {
            $users[] = $user->serialize();
        }

        return $users;
    }
}
