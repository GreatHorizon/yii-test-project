<?php

use yii\db\Migration;

/**
 * Class m220925_121329_post
 */
class m220925_121329_post extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('post', [
            'postId' => $this->primaryKey(),
            'authorId' => $this->integer()->notNull(),
            'title' => $this->string(),
            'text' => $this->text(),
        ]);


        $this->addForeignKey(
          'fk-post-authorId',
          'post',
          'authorId',
          'user',
          'userId',
          'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('post');
    }
}
