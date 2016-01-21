<?php

use yii\db\Migration;

class m160120_123818_File_change_foreign_key extends Migration
{
    const TABLE = 'File';

    private $columns = [
        'evidence_id' => 'record_id',
        'evidence_file_type' => 'record_file_type',
    ];

    public function safeUp()
    {
        $this->execute('SET FOREIGN_KEY_CHECKS = 0;');
        $this->dropIndex('FK_File_Evidence', self::TABLE);
        $this->dropForeignKey('FK_File_Evidence', self::TABLE);


        foreach ($this->columns as $name => $newName) {
            $this->renameColumn(self::TABLE, $name, $newName);
        }

        $this->addForeignKey('FK_File_Record', self::TABLE, 'record_id', 'Record', 'id');
        $this->execute('SET FOREIGN_KEY_CHECKS = 1;');
    }

    public function safeDown()
    {
        $this->execute('SET FOREIGN_KEY_CHECKS = 0;');
        $this->dropIndex('FK_File_Record', self::TABLE);
        $this->dropForeignKey('FK_File_Record', self::TABLE);
        $this->execute('SET FOREIGN_KEY_CHECKS = 1;');

        foreach ($this->columns as $name => $newName) {
            $this->renameColumn(self::TABLE, $newName, $name);
        }
    }
}
