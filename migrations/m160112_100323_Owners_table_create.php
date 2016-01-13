<?php

use yii\db\Migration;

class m160112_100323_Owners_table_create extends Migration
{
    public function safeUp()
    {
        $this->execute("
            CREATE TABLE IF NOT EXISTS `Owners` (
              `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
              `first_name` varchar(255) NOT NULL,
              `middle_name` varchar(255) DEFAULT NULL,
              `last_name` varchar(255) NOT NULL,
              `address_1` text NOT NULL,
              `address_2` text DEFAULT NULL,
              `city` varchar(255) NOT NULL,
              `state_id` int(10) unsigned NOT NULL,
              `license` varchar(20) NOT NULL,
              `zip_code` varchar(20) NOT NULL,
              `email` varchar(50) DEFAULT NULL,
              `phone` varchar(50) DEFAULT NULL,
              `vehicle_id` int(10) unsigned NOT NULL,
              `vehicle_year` int(10) unsigned DEFAULT NULL,
              `vehicle_color_id` int(10) unsigned NOT NULL,
              `created_at` int(10) unsigned DEFAULT NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ");
    }

    public function safeDown()
    {
        $this->dropTable('Owners');
    }
}
