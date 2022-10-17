<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "post".
 *
 * @property int $postId
 * @property int $authorId
 * @property string|null $title
 * @property string|null $text
 * @property int|null $createdAt
 * @property int|null $updatedAt
 *
 * @property User $author
 */
class BasePost extends \common\models\BaseModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'post';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['authorId'], 'required'],
            [['authorId', 'createdAt', 'updatedAt'], 'integer'],
            [['text'], 'string'],
            [['title'], 'string', 'max' => 255],
            [['authorId'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['authorId' => 'userId']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'postId' => 'Post ID',
            'authorId' => 'Author ID',
            'title' => 'Title',
            'text' => 'Text',
            'createdAt' => 'Created At',
            'updatedAt' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Author]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor()
    {
        return $this->hasOne(User::class, ['userId' => 'authorId']);
    }
}
