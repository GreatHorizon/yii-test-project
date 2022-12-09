<?php

namespace frontend\models\post;

use common\models\Post;
use yii\base\Model;

class GetAllPostsModel extends Model
{
    public $accessToken;
    public $offset;
    public $limit;

    private $posts;

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['accessToken'], 'required'],
            [['accessToken'], 'string'],
            ['limit', 'default', 'value' => 20],
            ['offset', 'default', 'value' => 0],
        ];
    }


    /**
     * @throws \Throwable
     */
    public function getPosts(): bool
    {
        if (!$this->validate()) {
            return false;
        }

        $this->posts = Post::find()
            ->offset($this->offset)
            ->limit($this->limit)
            ->orderBy(['createdAt' => SORT_DESC]);

        return true;
    }


    public function serializePosts(): array
    {
        $posts = [];

        foreach ($this->posts->each() as $post) {
            $posts[] = $post->serialize();
        }

        return $posts;
    }
}