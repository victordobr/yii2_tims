<?php

use yii\db\Schema;
use yii\db\Migration;

class m160108_122104_table_CaseStatus extends Migration
{
    public function up()
    {
        $sql = "
            CREATE TABLE IF NOT EXISTS `CaseStatus` (
              `id` int(100) NOT NULL,
              `StatusName` varchar(200) NOT NULL,
              `StatusDescription` text NOT NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ; ";

        $this->execute($sql);
    }

    public function down()
    {
        $this->dropTable('CaseStatus');
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
