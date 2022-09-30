<?php

use yii\db\Migration;

/**
 * Class m220930_205340_rename_user_columns
 */
class m220930_205340_rename_user_columns extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->renameColumn('user','auth_key','authKey');
        $this->renameColumn('user','password_hash','passwordHash');
        $this->renameColumn('user','password_reset_token','passwordResetToken');
        $this->renameColumn('user','created_at','createdAt');
        $this->renameColumn('user','updated_at','updatedAt');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->renameColumn('user','authKey','auth_key');
        $this->renameColumn('user','passwordHash','password_hash');
        $this->renameColumn('user','passwordResetToken','password_reset_token');
        $this->renameColumn('user','createdAt','created_at');
        $this->renameColumn('user','updatedAt','updated_at');
    }
}
