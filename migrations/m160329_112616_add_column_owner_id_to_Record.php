<?php

use yii\db\Migration;

class m160329_112616_add_column_owner_id_to_Record extends Migration
{
    const TABLE = 'Record';
    private $columns = [
        'owner_id' => 'INT(10) UNSIGNED',
    ];

    public function up()
    {
        foreach ($this->columns as $column => $type) {
            $this->addColumn(self::TABLE, $column, $type);
        }
        $this->addForeignKey('FK_Record_Owner', self::TABLE, ['owner_id'], 'Owner', ['id'], 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->dropForeignKey('FK_Record_Owner', self::TABLE);
        foreach (array_keys($this->columns) as $column) {
            $this->dropColumn(self::TABLE, $column);
        }
    }

}
