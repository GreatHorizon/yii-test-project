<?php

namespace frontend\models\post;

use common\models\User;
use yii\base\Model;
use yii\db\ActiveQuery;

class GetMyPostsForm extends Model
{
    public int $offset;
    public int $limit;
    public string $accessToken;

    private ActiveQuery $myPosts;

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


    public function getMyPosts(): bool
    {
        if (!$this->validate()) {
            return false;
        }

        $user = User::findIdentityByAccessToken($this->accessToken);

        if (empty($user)) {
            $this->addError('error', 'User not found');
            return false;
        }

        $this->myPosts = $user->getPosts()
            ->offset($this->offset)
            ->limit($this->limit)
            ->orderBy(['createdAt' => SORT_DESC]);

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