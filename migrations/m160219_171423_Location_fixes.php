<?php

use yii\db\Migration;

class m160219_171423_Location_fixes extends Migration
{
    public function safeUp()
    {
        $this->execute("
            ALTER TABLE `Location`
                DROP FOREIGN KEY `FK_Record_Location`;
            ALTER TABLE `Location`
                ADD CONSTRAINT `FK_Record_Location` FOREIGN KEY (`record_id`) REFERENCES `Record` (`id`) ON UPDATE CASCADE ON DELETE CASCADE;
        ");

        $this->execute("
            ALTER TABLE `File`
                DROP FOREIGN KEY `FK_File_Record`;
            ALTER TABLE `File`
                ADD CONSTRAINT `FK_File_Record` FOREIGN KEY (`record_id`) REFERENCES `Record` (`id`) ON UPDATE CASCADE ON DELETE CASCADE;
        ");
    }

    public function safeDown()
    {
        $this->execute("
            ALTER TABLE `Location`
                DROP FOREIGN KEY `FK_Record_Location`;
            ALTER TABLE `Location`
                ADD CONSTRAINT `FK_Record_Location` FOREIGN KEY (`record_id`) REFERENCES `Record` (`id`) ON UPDATE RESTRICT ON DELETE RESTRICT;
        ");

        $this->execute("
            ALTER TABLE `File`
                DROP FOREIGN KEY `FK_File_Record`;
            ALTER TABLE `File`
                ADD CONSTRAINT `FK_File_Record` FOREIGN KEY (`record_id`) REFERENCES `Record` (`id`) ON UPDATE RESTRICT ON DELETE RESTRICT;
        ");
    }
}
