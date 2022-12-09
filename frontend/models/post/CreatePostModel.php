<?php

namespace frontend\models\post;

use common\models\Post;
use yii\base\Model;

class CreatePostModel extends Model
{
    public $title;
    public $text;
    public $accessToken;

    private $post;


    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['title', 'accessToken'], 'required'],
            [['title', 'text', 'accessToken'], 'string']
        ];
    }


    /**
     * @throws \Throwable
     */
    public function createPost(): bool
    {
        if (!$this->validate()) {
            return false;
        }

        $user = \Yii::$app->user->getIdentity();

        $this->post = new Post();
        $this->post->title = $this->title;
        $this->post->text = $this->text;
        $this->post->authorId = $user->userId;

        if (!$this->post->save()) {
            $this->addErrors($this->post->getErrors());
            return false;
        }

        return true;
    }


    public function getSerializedPost()
    {
        return $this->post->serialize();
    }
}