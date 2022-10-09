<?php

namespace frontend\controllers;

use common\models\User;
use Yii;
use yii\web\Controller;
use yii\web\MethodNotAllowedHttpException;
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

        if ($request->isGet) {
            return $this->getAllUsers($request);
        } else {
            throw new MethodNotAllowedHttpException;
        }
    }


    /**
     * @throws ServerErrorHttpException
     */
    private function getAllUsers($request): array
    {
        $accessToken = $request->get('accessToken');

        if ($accessToken == null) {
            throw new ServerErrorHttpException('AccessToken should not be empty');
        }

        $searchResult = User::find()->orderBy('createdAt')->all();
        $users = [];

        foreach ($searchResult as $user) {
            ///Potentially polymorphic call. ActiveRecord does not have members in its hierarchy
            $users[] = $user->serialize();
        }

        return $users;
    }
}
