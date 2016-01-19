<?php

use yii\db\Schema;
use yii\db\Migration;

class m160113_113245_Owners_table_rename extends Migration
{
    public function safeUp()
    {
        $this->renameTable('Owners', 'Owner');
    }

    public function safeDown()
    {
        $this->renameTable('Owner', 'Owners');
    }
}
