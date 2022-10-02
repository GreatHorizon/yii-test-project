<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "access_token".
 *
 * @property int $accessTokenId
 * @property int $userId
 * @property string|null $createdAt
 * @property string|null $token
 *
 * @property User $user
 */
class BaseAccessToken extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'access_token';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['userId'], 'required'],
            [['userId'], 'integer'],
            [['createdAt'], 'safe'],
            [['token'], 'string', 'max' => 255],
            [['userId'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['userId' => 'userId']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'accessTokenId' => 'Access Token ID',
            'userId' => 'User ID',
            'createdAt' => 'Created At',
            'token' => 'Token',
        ];
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['userId' => 'userId']);
    }
}
