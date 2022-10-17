<?php

use yii\db\Migration;

/**
 * Class m221015_133426_user_change_date_nullability
 */
class m221015_133426_user_change_date_nullability extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('user', 'createdAt', $this->integer());
        $this->alterColumn('user', 'updatedAt', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('user', 'createdAt', $this->integer()->notNull());
        $this->alterColumn('user', 'updatedAt', $this->integer()->notNull());
    }
}
