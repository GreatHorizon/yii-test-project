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
     * @throws MethodNotAllowedHttpException
     */
    public function actionCreate(): array
    {
        $request = Yii::$app->request;

        if ($request->isPost) {
            return $this->createPost($request);
        } else {
            throw new MethodNotAllowedHttpException;
        }
    }

    /**
     * @throws ServerErrorHttpException
     * @throws NotFoundHttpException
     */
    private function createPost($request): array
    {
        $user = $this->findUserFromRequest($request->post('accessToken'));

        $title = $request->post('title');
        $text = $request->post('text');

        if (empty($title)) {
            throw new ServerErrorHttpException('Title of post should not be empty');
        }

        if (empty($text)) {
            throw new ServerErrorHttpException('Text of post should not be empty');
        }

        $post = new Post($title, $text, $user->userId);

        if (!$post->save()) {
            throw new ServerErrorHttpException('Unable to save post');
        }

        return $post->serialize();
    }

    /**
     * @throws ServerErrorHttpException
     * @throws NotFoundHttpException
     */
    private function getMyPosts($request): array
    {
        $user = $this->findUserFromRequest($request->get('accessToken'));
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
        $this->findUserFromRequest($request->get('accessToken'));

        ///Potentially polymorphic call. ActiveRecord does not have members in its hierarchy
        $searchResult = Post::find()->orderBy('createdAt')->all();

        $posts = [];

        foreach ($searchResult as $post) {
            $posts[] = $post->serialize();
        }

        return $posts;
    }


    /**
     * @throws NotFoundHttpException
     * @throws ServerErrorHttpException
     */
    private function findUserFromRequest($accessToken)
    {
        if (empty($accessToken)) {
            throw new ServerErrorHttpException('AccessToken should not be empty');
        }

        $foundUser = User::findIdentityByAccessToken($accessToken);

        if (empty($foundUser)) {
            throw new NotFoundHttpException('User not found');
        }

        return $foundUser;
    }
}
