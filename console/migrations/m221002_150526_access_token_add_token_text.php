<?php

use yii\db\Migration;

/**
 * Class m221002_150526_access_token_add_token_text
 */
class m221002_150526_access_token_add_token_text extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('access_token', 'token', $this->string()->defaultValue(null));

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('access_token', 'token');

    }
}
