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
     * @throws NotFoundHttpException
     * @SWG\Get(path="/post",
     *     tags={"Post"},
     *     summary="Get full post list",
     *     @SWG\Parameter(
     *         name="accessToken",
     *         in="path",
     *         description="User access token",
     *         required=true,
     *         type="string",
     *     ),
     *     @SWG\Response(
     *         response = 200,
     *         description = "Post collection response",
     *         @SWG\Schema(
     *             type="array",
     *             @SWG\Items(ref = "#/definitions/Post")
     *         ),
     *     )
     * )
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
     * @throws NotFoundHttpException
     * @SWG\Get(path="/my-posts",
     *     tags={"Post"},
     *     summary="Get my post list",
     *     @SWG\Parameter(
     *         name="accessToken",
     *         in="path",
     *         description="User access token",
     *         required=true,
     *         type="string",
     *     ),
     *     @SWG\Response(
     *         response = 200,
     *         description = "Post collection response",
     *         @SWG\Schema(
     *             type="array",
     *             @SWG\Items(ref = "#/definitions/Post")
     *         ),
     *     )
     * )
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
     * @return array
     * @throws MethodNotAllowedHttpException
     * @throws NotFoundHttpException
     * @throws ServerErrorHttpException
     * @SWG\Post(path="/create",
     *     tags={"Post"},
     *     summary="Create new post",
     *     @SWG\Parameter(
     *         name="accessToken",
     *         in="body",
     *         description="User access token",
     *         required=true,
     *         type="string",
     *     ),
     *     @SWG\Parameter(
     *         name="title",
     *         in="body",
     *         description="Post title",
     *         required=true,
     *         type="string",
     *     ),
     *      @SWG\Parameter(
     *         name="text",
     *         in="body",
     *         description="Post text",
     *         required=true,
     *         type="string",
     *     ),
     *     @SWG\Response(
     *         response = 200,
     *         description = "Post created response",
     *         @SWG\Schema(ref = "#/definitions/Post"),
     *     )
     * )
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
            throw new ServerErrorHttpException('Unable to save post: ' . var_export($post->getErrors(), true));
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

        $offset = $request->get('offset');
        $limit = $request->get('limit');

        $query = $user->getPosts()
            ->offset($offset ?? 0)
            ->limit($limit ?? 1000)
            ->orderBy('createdAt');

        $posts = [];

        foreach ($query->each() as $post) {
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

        $offset = $request->get('offset');
        $limit = $request->get('limit');

        $query = Post::find()
            ->offset($offset ?? 0)
            ->limit($limit ?? 1000)
            ->orderBy('createdAt');

        $posts = [];

        foreach ($query->each() as $post) {
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
