<?php

use yii\db\Schema;
use yii\db\Migration;

class m160108_122104_table_CaseStatus extends Migration
{
    public function up()
    {
        $sql = "CREATE TABLE IF NOT EXISTS `CaseStatus` (
              `id` int(100) NOT NULL,
              `StatusName` varchar(200) NOT NULL,
              `StatusDescription` text NOT NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

        $this->execute($sql);

        $this->execute("
            INSERT INTO `CaseStatus` (`id`, `StatusName`, `StatusDescription`) VALUES
            (1, 'Waiting for Evidence Review', 'Waiting for Evidence Review'),
            (2, 'No Sufficient Evidence', 'No Sufficient Evidence'),
            (3, 'Sufficient', 'Sufficient'),
            (4, 'Awaiting Owner Info', 'Awaiting Owner Info'),
            (5, 'To be printed', 'To be printed'),
            (6, 'Ticket Mailed', 'Ticket Mailed'),
            (7, 'Paid', 'Paid'),
            (8, 'Disputed', 'Disputed'),
            (9, 'Payment Date Expired', 'Payment Date Expired'),
            (10, 'Overdue', 'Overdue'),
            (11, 'Overdue-Open ', 'Overdue-Open '),
            (12, 'Open', 'Open'),
            (13, 'Payment By Cheque', 'Payment By Cheque'),
            (14, 'Payment By Cash', 'Payment By Cash'),
            (15, 'Ticket Print', 'Ticket Print'); ");


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
