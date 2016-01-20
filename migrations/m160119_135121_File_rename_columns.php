<?php

use yii\db\Schema;
use yii\db\Migration;

class m160119_135121_File_rename_columns extends Migration
{
    const TABLE = 'File';
    private $columns = [
        'evidence_id' => 'record_id',
        'evidence_file_type' => 'record_file_type',
    ];

    public function safeUp()
    {
        foreach ($this->columns as $name => $newName) {
            $this->renameColumn(self::TABLE, $name, $newName);
        }
    }

    public function safeDown()
    {
        foreach ($this->columns as $name => $newName) {
            $this->renameColumn(self::TABLE, $newName, $name);
        }
    }
}