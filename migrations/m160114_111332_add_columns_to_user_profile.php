<?php

use yii\db\Schema;
use yii\db\Migration;

class m160114_111332_add_columns_to_user_profile extends Migration
{
    const TABLE = 'User';
    private $columns = [
        'zip_code' => 'VARCHAR(16) DEFAULT \'\' NOT NULL',
        'state_id' => 'INT(11) UNSIGNED NOT NULL',
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
