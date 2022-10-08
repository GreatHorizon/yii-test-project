<?php

namespace frontend\controllers;

use common\models\Post;
use common\models\User;
use Yii;
use yii\web\Controller;
use yii\web\MethodNotAllowedHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\web\ServerErrorHttpException;

class PostController extends Controller
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
     * @throws MethodNotAllowedHttpException
     * @throws ServerErrorHttpException
     */
    public function actionIndex(): array
    {
        $request = Yii::$app->request;

        if ($request->isGet) {
            return $this->getAllPosts($request);
        } else {
            throw new MethodNotAllowedHttpException;
        }
    }

    /**
     * @throws MethodNotAllowedHttpException
     * @throws ServerErrorHttpException
     */
    public function actionMyPosts(): array
    {
        $request = Yii::$app->request;

        if ($request->isGet) {
            return $this->getMyPosts($request);
        } else {
            throw new MethodNotAllowedHttpException;
        }
    }

    /**
     * @throws ServerErrorHttpException
     */
    private function getMyPosts($request): array
    {
        $accessToken = $request->get('accessToken');

        if (empty($accessToken)) {
            throw new ServerErrorHttpException('AccessToken should not be empty');
        }

        $user = User::findIdentityByAccessToken($accessToken);

        if (empty($user)) {
            throw new ServerErrorHttpException('AccessToken should not be empty');
        }

        ///Potentially polymorphic call. ActiveRecord does not have members in its hierarchy
        $searchResult = $user->getPosts()->orderBy('createdAt')->all();
        $posts = [];

        foreach ($searchResult as $post) {
            $posts[] = $post->serialize();
        }

        return $posts;
    }

    /**
     * @throws ServerErrorHttpException
     * @throws NotFoundHttpException
     */
    private function getAllPosts($request): array
    {
        $accessToken = $request->get('accessToken');

        if (empty($accessToken)) {
            throw new ServerErrorHttpException('AccessToken should not be empty');
        }

        $foundUser = User::findIdentityByAccessToken($accessToken);

        if (empty($foundUser)) {
            throw new NotFoundHttpException('User not found');
        }

        ///Potentially polymorphic call. ActiveRecord does not have members in its hierarchy
        $searchResult = Post::find()->orderBy('createdAt')->all();

        $posts = [];

        foreach ($searchResult as $post) {
            $posts[] = $post->serialize();
        }

        return $posts;
    }
}
