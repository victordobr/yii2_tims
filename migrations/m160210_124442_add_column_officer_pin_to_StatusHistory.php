<?php

use yii\db\Schema;
use yii\db\Migration;

class m160210_124442_add_column_officer_pin_to_StatusHistory extends Migration
{
    const TABLE = 'StatusHistory';

    private $columns = [
        'officer_pin' => 'VARCHAR(16) NULL',
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
