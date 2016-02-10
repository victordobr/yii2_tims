<?php

use yii\db\Schema;
use yii\db\Migration;

class m160202_112932_modify_status_history extends Migration
{
    const TABLE = 'StatusHistory';

    private $columns = [
        'add' => ['stage_id' => 'INT(11) UNSIGNED NOT NULL'],
        'drop' => ['parent_id' => 'INT(11) NULL'],
    ];

    public function up()
    {
        $this->execute('SET FOREIGN_KEY_CHECKS = 0');
        foreach ($this->columns['add'] as $name => $type) {
            $this->addColumn(self::TABLE, $name, $type);
        }
        foreach (array_keys($this->columns['drop']) as $name) {
            $this->dropColumn(self::TABLE, $name);
        }
        $this->createIndex('UK_Record_Stage', self::TABLE, ['record_id', 'stage_id'], true);
        $this->execute('SET FOREIGN_KEY_CHECKS = 1');
    }

    public function down()
    {
        $this->execute('SET FOREIGN_KEY_CHECKS = 0');
        foreach ($this->columns['drop'] as $name => $type) {
            $this->addColumn(self::TABLE, $name, $type);
        }
        foreach (array_keys($this->columns['add']) as $name) {
            $this->dropColumn(self::TABLE, $name);
        }
        $this->dropIndex('UK_Record_Stage', self::TABLE);
        $this->execute('SET FOREIGN_KEY_CHECKS = 1');
    }

}
