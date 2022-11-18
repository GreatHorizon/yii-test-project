<?php

namespace common\models;

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

/**
 * @SWG\Definition()
 *
 * @SWG\Property(property="postId", type="integer")
 * @SWG\Property(property="authorId", type="integer")
 * @SWG\Property(property="title", type="string")
 * @SWG\Property(property="text", type="string")
 * @SWG\Property(property="createdAt", type="integer")
 * @SWG\Property(property="updatedAt", type="integer")
 */
class Post extends BasePost
{
    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'postId' => 'ID поста',
            'authorId' => 'ID автора',
            'title' => 'Название',
            'text' => 'Текст',
        ];
    }


    public function serialize(): array
    {
        return [
            "userId" => $this->postId,
            "authorId" => $this->authorId,
            "title" => $this->title,
            "status" => $this->text,
        ];
    }

    public function beforeSave($insert): bool
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        if ($insert) {
            $this->createdAt = time();
        }

        $this->updatedAt = time();

        return parent::beforeSave($insert);
    }

    public function __construct($title = null, $text = null, $userId = null, $config = [])
    {
        $this->title = $title;
        $this->text = $text;
        $this->authorId = $userId;

        parent::__construct($config);
    }
}
