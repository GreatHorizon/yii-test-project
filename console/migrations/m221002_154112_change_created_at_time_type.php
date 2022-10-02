<?php

use yii\db\Migration;

/**
 * Class m221002_154112_change_created_at_time_type
 */
class m221002_154112_change_created_at_time_type extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('access_token', 'createdAt', $this->integer()->notNull());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('access_token', 'createdAt', $this->dateTime());

    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m221002_154112_change_created_at_time_type cannot be reverted.\n";

        return false;
    }
    */
}
