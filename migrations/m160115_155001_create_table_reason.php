<?php

use yii\db\Schema;
use yii\db\Migration;

class m160115_155001_create_table_reason extends Migration
{
    const TABLE = 'Reason';
    private $columns = [
        'id' => Schema::TYPE_PK,
        'code' => Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 0',
        'description' => Schema::TYPE_TEXT . ' NOT NULL DEFAULT ""',
    ];

    public function up()
    {
        $this->createTable(self::TABLE, $this->columns, 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');
    }

    public function down()
    {
        $this->dropTable(self::TABLE);
    }

}
