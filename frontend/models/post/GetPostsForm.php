<?php

namespace frontend\models\post;

use common\models\Post;
use common\models\User;
use yii\base\Model;

class GetPostsForm extends Model
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


    public function getPosts(): bool
    {
        if (!$this->validate()) {
            return false;
        }

        $user = User::findIdentityByAccessToken($this->accessToken);

        if (empty($user)) {
            $this->addError('error', 'User not found');
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