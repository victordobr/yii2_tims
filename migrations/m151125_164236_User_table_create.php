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
              `type_id` tinyint(1) unsigned NOT NULL COMMENT '1 - admin;',
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
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ");

        $this->execute("
            INSERT INTO `User` (`id`, `type`, `email`, `password`, `first_name`, `last_name`, `phone`, `created_at`, `last_login`, `notes`, `avail_space`, `logins_count`, `company_name`, `active`) VALUES
                    (1, 1, 'despected@gmail.com', 'd033e22ae348aeb5660fc2140aec35850c4da997', NULL, NULL, NULL, 0, 4294967295, NULL, NULL, NULL, NULL, 1),
                    (2, 1, 'admin@admin.admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', 'admin', 'admin', NULL, 2147483647, 4294967295, NULL, 16000500, NULL, NULL, 1);
        ");

    }

    public function safeDown()
    {
        $this->dropTable('User');
    }
}
