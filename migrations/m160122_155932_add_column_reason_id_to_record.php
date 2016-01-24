<?php

use yii\db\Schema;
use yii\db\Migration;

class m160122_155932_add_column_reason_id_to_record extends Migration
{
    const TABLE = 'Record';
    private $columns = [
        'reason_id' => 'INT(11) NULL',
    ];

    public function up()
    {
        $this->execute('SET FOREIGN_KEY_CHECKS=0');
        foreach ($this->columns as $name => $type) {
            $this->addColumn(self::TABLE, $name, $type);
        }
        $this->addForeignKey('FK_Record_Reason', self::TABLE, 'reason_id', 'Reason', 'id');
        $this->execute('SET FOREIGN_KEY_CHECKS=1');
    }

    public function down()
    {
        $this->execute('SET FOREIGN_KEY_CHECKS=0');
        $this->dropForeignKey('FK_Record_Reason', self::TABLE);
        foreach (array_keys($this->columns) as $name) {
            $this->dropColumn(self::TABLE, $name);
        }
        $this->execute('SET FOREIGN_KEY_CHECKS=1');
    }

}
