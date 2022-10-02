<?php

use yii\db\Migration;

/**
 * Class m221002_133801_access_token
 */
class m221002_133801_access_token extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('access_token', [
            'accessTokenId' => $this->primaryKey(),
            'userId' => $this->integer()->notNull(),
            'createdAt' => $this->dateTime(),
        ]);


        $this->addForeignKey(
            'fk-access-token-userId',
            'access_token',
            'userId',
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
        $this->dropTable('access_token');
    }
}
