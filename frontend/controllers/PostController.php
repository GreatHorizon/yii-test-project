<?php

namespace frontend\controllers;

use common\models\Post;
use common\models\User;
use frontend\models\post\CreatePostForm;

use frontend\models\post\GetMyPostsForm;
use frontend\models\post\GetPostsForm;
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
        $model = new GetPostsForm();
        $model->load(\Yii::$app->request->get(), '');

        if ($model->getPosts()) {
            return $model->serializePosts();
        } else {
            return $model->getErrors();
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
        $model = new GetMyPostsForm();
        $model->load(\Yii::$app->request->get(), '');

        if ($model->getMyPosts()) {
            return $model->serializeMyPosts();
        } else {
            return $model->getErrors();
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
        $model = new CreatePostForm();
        $model->load(\Yii::$app->request->post(), '');

        if ($model->createPost()) {
            return $model->getSerializedPost();
        } else {
            return $model->getErrors();
        }
    }
}
