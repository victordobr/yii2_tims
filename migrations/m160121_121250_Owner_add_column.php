<?php

use yii\db\Migration;

class m160121_121250_Owner_add_column extends Migration
{
    const TABLE = 'Owner';
    private $column_name = 'record_id';
    private $column_type = 'INT(10) UNSIGNED NOT NULL';
    private $foreign_key_name = 'FK_Owner_Record';

    public function safeUp()
    {
        $this->addColumn(self::TABLE, $this->column_name, $this->column_type);
        $this->execute('SET FOREIGN_KEY_CHECKS = 0;');
        $this->addForeignKey($this->foreign_key_name, self::TABLE, $this->column_name, 'Record', 'id');
        $this->execute('SET FOREIGN_KEY_CHECKS = 1;');
    }

    public function safeDown()
    {
        $this->execute('SET FOREIGN_KEY_CHECKS = 0;');
        $this->dropForeignKey($this->foreign_key_name, self::TABLE);
        $this->execute('SET FOREIGN_KEY_CHECKS = 1;');
        $this->dropColumn(self::TABLE, $this->column_name);
    }
}
