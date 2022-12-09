<?php

namespace frontend\controllers;

use frontend\models\post\CreatePostModel;
use frontend\models\post\GetAllPostsModel;
use frontend\models\post\GetMyPostsModel;
use Symfony\Component\CssSelector\Exception\InternalErrorException;
use yii\web\MethodNotAllowedHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\web\ServerErrorHttpException;

class PostController extends BaseController
{
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
     * @throws InternalErrorException
     * @throws \Throwable
     * @SWG\Get(
     *     path="/post/all-posts",
     *     tags={"Post"},
     *     summary="Get full post list",
     *     @SWG\Parameter(
     *         name="accessToken",
     *         in="query",
     *         description="User access token",
     *         required=true,
     *         type="string",
     *     ),
     *     @SWG\Parameter(
     *         name="offset",
     *         in="query",
     *         description="Offset",
     *         type="int",
     *     ),
     *     @SWG\Parameter(
     *         name="limit",
     *         in="query",
     *         description="Limit",
     *         type="int",
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
    public function actionAllPosts(): array
    {
        $this->model = new GetAllPostsModel();

        $this->model->load(\Yii::$app->request->get(), '');

        if ($this->setIdentity() && $this->model->getPosts()) {
            return $this->model->serializePosts();
        } else {
            return $this->model->getErrors();
        }
    }

    /**
     * @throws MethodNotAllowedHttpException
     * @throws ServerErrorHttpException
     * @throws NotFoundHttpException
     * @throws \Throwable
     * @SWG\Get(
     *     path="/post/my-posts",
     *     tags={"Post"},
     *     summary="Get my post list",
     *     @SWG\Parameter(
     *         name="accessToken",
     *         in="query",
     *         description="User access token",
     *         required=true,
     *         type="string",
     *     ),
     *     @SWG\Parameter(
     *         name="offset",
     *         in="query",
     *         description="Offset",
     *         type="int",
     *     ),
     *     @SWG\Parameter(
     *         name="limit",
     *         in="query",
     *         description="Limit",
     *         type="int",
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
        $this->model = new GetMyPostsModel();
        $this->model->load(\Yii::$app->request->get(), '');

        if ($this->setIdentity() && $this->model->getMyPosts()) {
            return $this->model->serializeMyPosts();
        } else {
            return $this->model->getErrors();
        }
    }

    /**
     * @return array
     * @throws MethodNotAllowedHttpException
     * @throws NotFoundHttpException
     * @throws ServerErrorHttpException
     * @throws \Throwable
     * @SWG\Post(path="post/create-post",
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
    public function actionCreatePost(): array
    {
        $this->model = new CreatePostModel();
        $this->model->load(\Yii::$app->request->post(), '');

        if ($this->setIdentity() && $this->model->createPost()) {
            return $this->model->getSerializedPost();
        } else {
            return $this->model->getErrors();
        }
    }
}
