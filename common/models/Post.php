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
 *
 * @property User $author
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


    public function serialize(): array {
        return [
            "userId" => $this->postId,
            "authorId"=>$this->authorId,
            "title" => $this->title,
            "status" => $this->text,
        ];
    }

}
