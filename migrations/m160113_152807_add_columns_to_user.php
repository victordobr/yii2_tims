<?php

use yii\db\Schema;
use yii\db\Migration;

class m160113_152807_add_columns_to_user extends Migration
{
    const TABLE = 'User';
    private $columns = [
        'pre_name' => 'VARCHAR(3) DEFAULT \'mr\' NOT NULL',
        'address' => 'VARCHAR(255) DEFAULT \'\' NOT NULL',
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
