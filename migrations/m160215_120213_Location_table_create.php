<?php

use yii\db\Migration;

class m160215_120213_Location_table_create extends Migration
{
    public function safeUp()
    {
        $this->execute("
            CREATE TABLE IF NOT EXISTS `Location` (
                `record_id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
                `lat_dd` DECIMAL(20,17) NOT NULL,
                `lat_dms` VARCHAR(20) NOT NULL,
                `lat_ddm` VARCHAR(20) NOT NULL,
                `lng_dd` DECIMAL(20,17) NOT NULL,
                `lng_dms` VARCHAR(20) NOT NULL,
                `lng_ddm` VARCHAR(20) NOT NULL,
                `created_at` INT(10) UNSIGNED DEFAULT NULL,
                PRIMARY KEY (`record_id`),
                CONSTRAINT FK_Record_Location FOREIGN KEY (`record_id`) REFERENCES Record(`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ");
    }

    public function safeDown()
    {
        $this->dropTable('Location');
    }
}
