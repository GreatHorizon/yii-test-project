<?php

use yii\db\Migration;

/**
 * Class m220930_205900_user_rename_verification_token
 */
class m220930_205900_user_rename_verification_token extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->renameColumn('user', 'verification_token', 'verificationToken');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->renameColumn('user', 'verificationToken', 'verification_token');
    }
}
