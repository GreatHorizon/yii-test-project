<?php

use yii\db\Migration;

/**
 * Class m221008_074426_post_add_created_at_updated_at
 */
class m221008_074426_post_add_created_at_updated_at extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('post', 'createdAt', $this->integer()->defaultValue(time()));
        $this->addColumn('post', 'updatedAt', $this->integer()->defaultValue(time()));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('post', 'createdAt');
        $this->dropColumn('post', 'updatedAt');
    }
}
