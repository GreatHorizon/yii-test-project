<?php

use yii\db\Migration;

/**
 * Class m221017_162937_access_token_change_created_at_type
 */
class m221017_162937_access_token_change_created_at_type extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('access_token', 'createdAt', $this->integer());

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('access_token', 'createdAt', $this->integer()->notNull());
    }
}
