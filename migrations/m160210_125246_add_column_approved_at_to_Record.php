<?php

use yii\db\Schema;
use yii\db\Migration;

class m160210_125246_add_column_approved_at_to_Record extends Migration
{
    const TABLE = 'Record';

    private $columns = [
        'approved_at' => 'INT(11) UNSIGNED',
    ];

    public function up()
    {
        foreach ($this->columns as $name => $type) {
            $this->addColumn(self::TABLE, $name, $type);
        }
    }

    public function down()
    {
        foreach (array_keys($this->columns) as $name) {
            $this->dropColumn(self::TABLE, $name);
        }
    }

}
