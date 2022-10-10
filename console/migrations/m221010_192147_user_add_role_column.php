<?php

use yii\db\Migration;

/**
 * Class m221010_192147_user_add_role_column
 */
class m221010_192147_user_add_role_column extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('user', 'role', $this->tinyInteger());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('user', 'role');
    }
}
