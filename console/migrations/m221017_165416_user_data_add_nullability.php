<?php

use yii\db\Migration;

/**
 * Class m221017_165416_user_data_add_nullability
 */
class m221017_165416_user_data_add_nullability extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('post', 'createdAt', $this->integer()->null());
        $this->alterColumn('post', 'updatedAt', $this->integer()->null());

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('post', 'createdAt', $this->integer());
        $this->alterColumn('post', 'updatedAt', $this->integer());
    }
}
