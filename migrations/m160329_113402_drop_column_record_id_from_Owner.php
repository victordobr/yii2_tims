<?php

use yii\db\Migration;

class m160329_113402_drop_column_record_id_from_Owner extends Migration
{
    const TABLE = 'Owner';
    private $columns = [
        'record_id' => 'INT(10) UNSIGNED',
    ];

    public function up()
    {
        $this->dropForeignKey('FK_Owner_Record', self::TABLE);
        foreach (array_keys($this->columns) as $column) {
            $this->dropColumn(self::TABLE, $column);
        }
    }

    public function down()
    {
        foreach ($this->columns as $column => $type) {
            $this->addColumn(self::TABLE, $column, $type);
        }
        $this->addForeignKey('FK_Owner_Record', self::TABLE, ['record_id'], 'Record', ['id'], 'CASCADE', 'CASCADE');
    }

}
