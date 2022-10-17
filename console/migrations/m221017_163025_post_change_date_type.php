<?php

use yii\db\Migration;

/**
 * Class m221017_163025_post_change_date_type
 */
class m221017_163025_post_change_date_type extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('post', 'createdAt', $this->integer());
        $this->alterColumn('post', 'updatedAt', $this->integer());

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('post', 'createdAt', $this->integer()->defaultValue(time()));
        $this->alterColumn('post', 'updatedAt', $this->integer()->defaultValue(time()));
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m221017_163025_post_change_date_type cannot be reverted.\n";

        return false;
    }
    */
}
