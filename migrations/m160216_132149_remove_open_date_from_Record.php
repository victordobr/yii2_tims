<?php

use yii\db\Migration;

class m160216_132149_remove_open_date_from_Record extends Migration
{
    const TABLE = 'Record';

    private $columns = [
        'open_date' => 'INT(10) UNSIGNED',
    ];

    public function up()
    {
        foreach (array_keys($this->columns) as $name) {
            $this->dropColumn(self::TABLE, $name);
        }
    }

    public function down()
    {
        foreach ($this->columns as $name => $type) {
            $this->addColumn(self::TABLE, $name, $type);
        }
    }

}
