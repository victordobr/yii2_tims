<?php

use yii\db\Schema;
use yii\db\Migration;

class m151125_164236_User_table_create extends Migration
{
    public function safeUp()
    {
        $this->execute("
            CREATE TABLE IF NOT EXISTS `User` (
              `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
              `is_active` tinyint(1) unsigned NOT NULL DEFAULT '0',
              `email` varchar(255) NOT NULL,
              `password` varchar(255) NOT NULL,
              `recover_hash` varchar(255) DEFAULT NULL COMMENT 'Hash for password recovering email',
              `activation_hash` varchar(255) DEFAULT NULL COMMENT 'Hash for account activation email',
              `first_name` varchar(255) NOT NULL DEFAULT '',
              `middle_name` varchar(255) DEFAULT NULL,
              `last_name` varchar(255) NOT NULL DEFAULT '',
              `phone` varchar(50) DEFAULT NULL,
              `agency` varchar(255) DEFAULT NULL,
              `created_at` int(10) unsigned DEFAULT NULL,
              `last_login_at` int(10) unsigned DEFAULT NULL,
              `logins_count` int(10) unsigned DEFAULT '0',
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ");
    }

    public function safeDown()
    {
        $this->dropTable('User');
    }
}
