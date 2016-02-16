<?php

use yii\db\Migration;

class m160215_123203_remove_columns_lat_and_lng_from_Record extends Migration
{
    const TABLE = 'Record';

    private $columns = [
        'lat' => 'varchar(20) NOT NULL',
        'lng' => 'varchar(20) NOT NULL',
    ];

    private $coordinates_id = 'coordinates_id';

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
