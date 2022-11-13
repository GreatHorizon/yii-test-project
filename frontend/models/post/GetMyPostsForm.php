<?php

namespace frontend\models\post;

use common\models\User;
use yii\base\Model;

class GetMyPostsForm extends Model
{
    public $accessToken;
    public $offset;
    public $limit;

    private $myPosts;

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['accessToken'], 'required'],
            [['limit', 'offset'], 'integer'],
            [['accessToken'], 'string']
        ];
    }


    public function getMyPosts() : bool {
        if (!$this->validate()) {
            return false;
        }

        $user = User::findIdentityByAccessToken($this->accessToken);

        if (empty($user)) {
            $this->addError('error', 'User not found');
            return false;
        }

        $this->myPosts = $user->getPosts()
            ->offset($this->offset ?? 0)
            ->limit($this->limit ?? 1000)
            ->orderBy('createdAt');

        return true;
    }



    public function serializeMyPosts(): array
    {
        $posts = [];

        foreach ($this->myPosts->each() as $post) {
            $posts[] = $post->serialize();
        }

        return $posts;
    }
}