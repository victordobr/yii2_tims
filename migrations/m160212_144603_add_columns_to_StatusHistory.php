<?php

use yii\db\Schema;
use yii\db\Migration;

class m160212_144603_add_columns_to_StatusHistory extends Migration
{
    const TABLE = 'Record';

    private $columns = [
        'dmv_received_at' => 'INT(11) UNSIGNED',
        'printed_at' => 'INT(11) UNSIGNED',
        'qc_verified_at' => 'INT(11) UNSIGNED',
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
