<?php

namespace common\models;

use backend\models\Post;
use Yii;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "user".
 *
 * @property int $userId
 * @property string $username
 * @property string $authKey
 * @property string $passwordHash
 * @property string|null $passwordResetToken
 * @property string $email
 * @property int $status
 * @property int $createdAt
 * @property int $updatedAt
 * @property string|null $verificationToken
 *
 * @property Post[] $posts
 */
class User extends BaseUser implements IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_INACTIVE = 9;
    const STATUS_ACTIVE = 10;

    public function attributeLabels(): array
    {
        return [
            'userId' => 'ID пользователя',
            'username' => 'Имя пользователя',
            'authKey' => 'Auth Key',
            'passwordHash' => 'Password Hash',
            'passwordResetToken' => 'Password Reset Token',
            'email' => 'Почта',
            'status' => 'Статус',
            'createdAt' => 'Created At',
            'updatedAt' => 'Updated At',
            'verificationToken' => 'Verification Token',
        ];
    }

    public static function findByUsername(string $username): ?User
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    public static function findIdentity($id)
    {
        return static::findOne(['userId' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    public static function findIdentityByAccessToken($token, $type = null): ?IdentityInterface
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    public function validatePassword(string $password): bool
    {
        return Yii::$app->security->validatePassword($password, $this->passwordHash);
    }

    public function setPassword($password)
    {
        $this->passwordHash = Yii::$app->security->generatePasswordHash($password);
    }

    public function generateEmailVerificationToken()
    {
        $this->verificationToken = Yii::$app->security->generateRandomString() . '_' . time();
    }

    public function generateAuthKey()
    {
        $this->authKey = Yii::$app->security->generateRandomString();
    }


    public function getId()
    {
        return $this->getPrimaryKey();
    }

    public function getAuthKey(): ?string
    {
        return $this->authKey;
    }

    public function validateAuthKey($authKey): ?bool
    {
        return $this->getAuthKey() === $authKey;
    }

    public function fields()
    {
        $fields = parent::fields();

        unset(
            $fields['authKey'], $fields['passwordHash'],
            $fields['passwordResetToken'], $fields['verificationToken'],
        );

        return $fields;
    }
}
