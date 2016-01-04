<?php

use yii\db\Schema;
use yii\db\Migration;

class m151204_124749_Evidense_PoliceCase_tables_create extends Migration
{
    public function safeUp()
    {
        $this->execute("
            CREATE TABLE IF NOT EXISTS `PoliceCase` (
              `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
              `status_id` int(10) unsigned NOT NULL DEFAULT '1',
              `created_at` int(10) unsigned DEFAULT NULL,
              `open_date` int(10) unsigned DEFAULT NULL,
              `infraction_date` int(10) unsigned DEFAULT NULL,
              `officer_date` int(10) unsigned DEFAULT NULL,
              `mailed_date` int(10) unsigned DEFAULT NULL,
              `officer_pin` varchar(250) DEFAULT NULL,
              `officer_id` int(11) unsigned DEFAULT NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ");

        $this->execute("
            CREATE TABLE IF NOT EXISTS `Evidence` (
              `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
              `case_id` int(10) unsigned NOT NULL,
              `user_id` int(10) unsigned DEFAULT NULL,
              `video_lpr` varchar(250) DEFAULT NULL,
              `video_overview_camera` varchar(250) DEFAULT NULL,
              `image_lpr` varchar(250) DEFAULT NULL,
              `image_overview_camera` varchar(250) DEFAULT NULL,
              `license` varchar(250) NOT NULL,
              `state_id` int(10) unsigned NOT NULL,
              `created_at` int(10) unsigned DEFAULT NULL,
              PRIMARY KEY (`id`),
              UNIQUE KEY `FK_Evidence_Case` (`case_id`),
              KEY `FK_Evidence_User` (`user_id`),
              CONSTRAINT `FK_Evidence_Case` FOREIGN KEY (`case_id`) REFERENCES `PoliceCase` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
              CONSTRAINT `FK_Evidence_User` FOREIGN KEY (`user_id`) REFERENCES `User` (`id`) ON DELETE SET NULL ON UPDATE SET NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ");

    }

    public function safeDown()
    {
        $this->dropTable('Evidence');
        $this->dropTable('PoliceCase');
    }
}
