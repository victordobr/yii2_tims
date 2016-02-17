<?php

use yii\db\Migration;

class m160216_131503_remove_officer_pin_from_StatusHistory extends Migration
{
    const TABLE = 'StatusHistory';

    private $columns = [
        'officer_pin' => 'VARCHAR(16) NULL',
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
