<?php

namespace common\models;

use Yii;

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
 * @property int|null $role
 *
 * @property AccessToken[] $accessTokens
 * @property Post[] $posts
 */
class BaseUser extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'authKey', 'passwordHash', 'email', 'createdAt', 'updatedAt'], 'required'],
            [['status', 'createdAt', 'updatedAt', 'role'], 'integer'],
            [['username', 'passwordHash', 'passwordResetToken', 'email', 'verificationToken'], 'string', 'max' => 255],
            [['authKey'], 'string', 'max' => 32],
            [['username'], 'unique'],
            [['email'], 'unique'],
            [['passwordResetToken'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'userId' => 'User ID',
            'username' => 'Username',
            'authKey' => 'Auth Key',
            'passwordHash' => 'Password Hash',
            'passwordResetToken' => 'Password Reset Token',
            'email' => 'Email',
            'status' => 'Status',
            'createdAt' => 'Created At',
            'updatedAt' => 'Updated At',
            'verificationToken' => 'Verification Token',
            'role' => 'Role',
        ];
    }

    /**
     * Gets query for [[AccessTokens]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAccessTokens()
    {
        return $this->hasMany(AccessToken::class, ['userId' => 'userId']);
    }

    /**
     * Gets query for [[Posts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPosts()
    {
        return $this->hasMany(Post::class, ['authorId' => 'userId']);
    }
}
