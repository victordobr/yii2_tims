<?php

use yii\db\Schema;
use yii\db\Migration;

class m160114_122414_File_add_mime_type extends Migration
{
    public function safeUp()
    {
        $this->execute("
            ALTER TABLE `File`
                ADD COLUMN `mime_type` VARCHAR(50) NOT NULL AFTER `evidence_file_type`;
        ");

    }

    public function safeDown()
    {
        $this->execute("
            ALTER TABLE `File`
                DROP COLUMN `mime_type`;
        ");
    }
}
