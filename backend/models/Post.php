<?php

namespace app\models;

use common\models\User;
use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "post".
 *
 * @property int $postId
 * @property int $authorId
 * @property string|null $title
 * @property string|null $text
 *
 * @property User $author
 */
class Post extends ActiveRecord
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
            [['authorId'], 'integer'],
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
        ];
    }

    /**
     * Gets query for [[Author]].
     *
     * @return ActiveQuery
     */
    public function getAuthor()
    {
        return $this->hasOne(User::class, ['userId' => 'authorId']);
    }
}
