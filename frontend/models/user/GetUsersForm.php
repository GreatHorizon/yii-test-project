<?php

namespace frontend\models\user;

use common\models\User;
use yii\base\Model;

class GetUsersForm extends Model
{
    public $accessToken;
    public $offset;
    public $limit;

    private $users;

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

    /**
     * @throws \Throwable
     */
    public function getUsers(): bool
    {
        if (!$this->validate()) {
            return false;
        }

        $this->users = User::find()
            ->offset($this->offset ?? 0)
            ->limit($this->limit ?? 1000)
            ->orderBy('createdAt');

        return true;
    }


    public function serializeUsers(): array
    {
        $users = [];

        foreach ($this->users->each() as $post) {
            $users[] = $post->serialize();
        }

        return $users;
    }

}