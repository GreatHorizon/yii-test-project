<?php

use common\models\AccessToken;
use common\models\User;
use yii\base\Model;

class LoginModel extends Model
{
    public $username;
    public $password;

    private $accessToken;


    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['username', 'password'], 'required'],
            [['username', 'password'], 'string']
        ];
    }


    public function login(): bool
    {
        if (!$this->validate()) {
            return false;
        }

        $user = User::findOne(['username' => $this->username]);

        if ($user == null || !$user->validatePassword($this->password)) {
            $this->addError('User not found');
            return false;
        }

        $this->accessToken = $this->createAccessToken($user->userId);

        if (!$this->accessToken->save()) {
            $this->addErrors($this->accessToken->getErrors());
        }

        return true;
    }

    private static function createAccessToken(int $userId): AccessToken
    {
        $accessToken = new AccessToken();
        $accessToken->userId = $userId;
        
        return $accessToken;
    }

    public function serializeToken(): array
    {
        return ['accessToken' => $this->accessToken->token];
    }


}