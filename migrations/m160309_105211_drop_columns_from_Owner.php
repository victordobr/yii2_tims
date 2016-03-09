<?php

use yii\db\Migration;

class m160309_105211_drop_columns_from_Owner extends Migration
{
    const TABLE = 'Owner';

    private $columns = [
        'vehicle_id' => 'INT(10) UNSIGNED NOT NULL',
        'vehicle_year' => 'INT(10) UNSIGNED',
        'vehicle_color_id' => 'INT(10) UNSIGNED NOT NULL',
    ];

    public function up()
    {
        foreach (array_keys($this->columns) as $column) {
            $this->dropColumn(self::TABLE, $column);
        }
    }

    public function down()
    {
        foreach ($this->columns as $column => $type) {
            $this->addColumn(self::TABLE, $column, $type);
        }
    }
}
