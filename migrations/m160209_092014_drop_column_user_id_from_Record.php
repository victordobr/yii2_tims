<?php

use yii\db\Schema;
use yii\db\Migration;

class m160209_092014_drop_column_user_id_from_Record extends Migration
{
    const TABLE = 'Record';

    private $columns = [
        'user_id' => 'INT(10) UNSIGNED NOT NULL'
    ];

    public function up()
    {
        $this->dropForeignKey('FK_Record_User', self::TABLE);
        foreach (array_keys($this->columns) as $name) {
            $this->dropColumn(self::TABLE, $name);
        }
    }

    public function down()
    {
        foreach ($this->columns as $name => $type) {
            $this->addColumn(self::TABLE, $name, $type);
        }
        $this->execute('SET FOREIGN_KEY_CHECKS = 0');
        $this->addForeignKey('FK_Record_User', self::TABLE, 'user_id', 'User', 'id');
        $this->execute('SET FOREIGN_KEY_CHECKS = 1');
    }

}
