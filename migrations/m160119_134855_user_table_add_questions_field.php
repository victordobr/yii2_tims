<?php

use yii\db\Schema;
use yii\db\Migration;

class m160119_134855_user_table_add_questions_field extends Migration
{
    const TABLE = 'User';
    private $columns = [
        'question_id' =>  'INT(100) UNSIGNED NULL',
        'question_answer' => 'VARCHAR(200) DEFAULT \'\' NULL',
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

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
