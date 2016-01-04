<?php

use yii\db\Schema;
use yii\db\Migration;

class m151216_160019_Files_reorganize extends Migration
{
    public function safeUp()
    {
        $this->execute("
            CREATE TABLE IF NOT EXISTS `File` (
              `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
              `evidence_id` int(10) unsigned DEFAULT NULL,
              `file_type` tinyint(1) unsigned NOT NULL,
              `evidence_file_type` tinyint(1) unsigned NOT NULL,
              `url` varchar(250) NOT NULL,
              `created_at` int(10) unsigned DEFAULT NULL,
              PRIMARY KEY (`id`),
              KEY `FK_File_Evidence` (`evidence_id`),
              CONSTRAINT `FK_File_Evidence` FOREIGN KEY (`evidence_id`) REFERENCES `Evidence` (`id`) ON DELETE SET NULL ON UPDATE SET NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ");

        $this->execute("
            ALTER TABLE `Evidence`
                DROP COLUMN `video_lpr`,
                DROP COLUMN `video_overview_camera`,
                DROP COLUMN `image_lpr`,
                DROP COLUMN `image_overview_camera`;
        ");

    }

    public function safeDown()
    {
        $this->dropTable('File');

        $this->execute("
            ALTER TABLE `Evidence`
                ADD COLUMN `video_lpr` varchar(250) DEFAULT NULL,
                ADD COLUMN `video_overview_camera` varchar(250) DEFAULT NULL,
                ADD COLUMN `image_lpr` varchar(250) DEFAULT NULL,
                ADD COLUMN `image_overview_camera` varchar(250) DEFAULT NULL;
        ");
    }
}
