<?php

use yii\db\Schema;
use yii\db\Migration;

class m160212_145058_Bus_number_and_officer_pin extends Migration
{
    public function safeUp()
    {
        $this->execute("
            ALTER TABLE `User`
                ADD COLUMN `officer_pin` VARCHAR(6) NULL DEFAULT NULL AFTER `question_answer`;

            ALTER TABLE `Record`
	            ADD COLUMN `bus_number` VARCHAR(10) NOT NULL AFTER `approved_at`;
        ");
    }

    public function safeDown()
    {
        $this->execute("
            ALTER TABLE `User`
                DROP COLUMN `officer_pin`;

            ALTER TABLE `Record`
	            DROP COLUMN `bus_number`;
        ");
    }
}
