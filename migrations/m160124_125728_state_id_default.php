<?php

use yii\db\Schema;
use yii\db\Migration;

class m160124_125728_state_id_default extends Migration
{
    public function safeUp()
    {
        $this->execute("
            ALTER TABLE `User`
	          CHANGE COLUMN `state_id` `state_id` INT(11) UNSIGNED NULL DEFAULT NULL AFTER `zip_code`;
        ");

        $this->execute("
            ALTER TABLE `Owner`
                CHANGE COLUMN `record_id` `record_id` INT(10) UNSIGNED NULL DEFAULT NULL AFTER `created_at`;
        ");

        $this->execute("
            ALTER TABLE `Record`
                CHANGE COLUMN `open_date` `open_date` INT(10) UNSIGNED NULL DEFAULT NULL AFTER `infraction_date`;
        ");
    }

    public function safeDown()
    {
        $this->execute("
            ALTER TABLE `User`
                ALTER `state_id` DROP DEFAULT;
            ALTER TABLE `User`
                CHANGE COLUMN `state_id` `state_id` INT(11) UNSIGNED NOT NULL AFTER `zip_code`;
        ");

        $this->execute('SET FOREIGN_KEY_CHECKS = 0;');
        $this->execute("
            ALTER TABLE `Owner`
                ALTER `record_id` DROP DEFAULT;
            ALTER TABLE `Owner`
                CHANGE COLUMN `record_id` `record_id` INT(10) UNSIGNED NOT NULL AFTER `created_at`;
        ");
        $this->execute('SET FOREIGN_KEY_CHECKS = 1;');
    }
}
