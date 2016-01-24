<?php

use yii\db\Schema;
use yii\db\Migration;

class m160115_155001_create_table_reason extends Migration
{
    const TABLE = 'Reason';

    public function up()
    {
        $this->execute("
            CREATE TABLE IF NOT EXISTS `Reason` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `code` int(11) NOT NULL DEFAULT '0',
              `description` text COLLATE utf8_unicode_ci NOT NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

            DELETE FROM `Reason`;
            INSERT INTO `Reason` (`id`, `code`, `description`) VALUES
                (1, 10, 'fgh');
        ");
    }

    public function down()
    {
        $this->dropTable(self::TABLE);
    }

}
