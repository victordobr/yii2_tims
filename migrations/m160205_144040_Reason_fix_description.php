<?php

use yii\db\Schema;
use yii\db\Migration;

class m160205_144040_Reason_fix_description extends Migration
{
    public function safeUp()
    {
        $this->execute("
            ALTER TABLE `Reason`
                CHANGE COLUMN `description` `description` TEXT NULL DEFAULT NULL COLLATE 'utf8_unicode_ci' AFTER `code`;
        ");
    }

    public function safeDown()
    {
        $this->execute("
            ALTER TABLE `Reason`
                CHANGE COLUMN `description` `description` TEXT NOT NULL COLLATE 'utf8_unicode_ci' AFTER `code`;
        ");
    }
}
