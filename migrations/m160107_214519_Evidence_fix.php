<?php

use yii\db\Schema;
use yii\db\Migration;

class m160107_214519_Evidence_fix extends Migration
{
    public function safeUp()
    {
        $this->execute("
            ALTER TABLE `PoliceCase`
                DROP COLUMN `infraction_date`;
        ");

        $this->execute("
            ALTER TABLE `Evidence`
                ADD COLUMN `infraction_date` INT(10) UNSIGNED NULL DEFAULT NULL AFTER `state_id`;
        ");

        $this->execute("
            ALTER TABLE `Evidence`
                ADD COLUMN `lat` VARCHAR(20) NOT NULL AFTER `license`,
                CHANGE COLUMN `infraction_date` `infraction_date` INT(10) UNSIGNED NULL AFTER `state_id`;
        ");

        $this->execute("
            ALTER TABLE `Evidence`
                ADD COLUMN `lng` VARCHAR(20) NOT NULL AFTER `lat`;
        ");

    }

    public function safeDown()
    {
        $this->execute("
            ALTER TABLE `Evidence`
                DROP COLUMN `lat`;
        ");

        $this->execute("
            ALTER TABLE `Evidence`
                DROP COLUMN `lng`;
        ");

        $this->execute("
            ALTER TABLE `Evidence`
                DROP COLUMN `infraction_date`;
        ");

        $this->execute("
            ALTER TABLE `PoliceCase`
                ADD COLUMN `infraction_date` INT(10) UNSIGNED NULL DEFAULT NULL;
        ");
    }
}
