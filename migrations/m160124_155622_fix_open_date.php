<?php

use yii\db\Schema;
use yii\db\Migration;

class m160124_155622_fix_open_date extends Migration
{
    public function safeUp()
    {
        $this->execute("
          UPDATE `Record` SET `open_date`=NULL;
        ");

//        $this->execute("
//            TRUNCATE `File`;
//        ");
    }

    public function safeDown()
    {

    }
}
