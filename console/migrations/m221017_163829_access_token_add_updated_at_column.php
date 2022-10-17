<?php

use yii\db\Migration;

/**
 * Class m221017_163829_access_token_add_updated_at_column
 */
class m221017_163829_access_token_add_updated_at_column extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('access_token', 'updatedAt', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('access_token', 'updatedAt');
    }
}
