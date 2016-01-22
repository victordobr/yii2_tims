<?php

use yii\db\Schema;
use yii\db\Migration;

class m160119_124607_questions_table extends Migration
{
    public function up()
    {
        $this->execute("
            CREATE TABLE IF NOT EXISTS `Question` (
              `id` int(100) NOT NULL AUTO_INCREMENT,
              `text` text NOT NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;");



        $this->execute("INSERT INTO `Question` (`id`, `text`) VALUES
                (1, 'what is your home town name'),
                (2, 'what is your favourite school teacher name'),
                (3, 'what is your favourite poet name'),
                (4, 'What is the last name of the teacher who gave you your first failing grade?'),
                (5, 'What is the name of the place your wedding reception was held?'),
                (6, 'What was the name of your elementary / primary school?'),
                (7, 'In what city or town does your nearest sibling live?'),
                (8, 'What is your pet’s name?');");



    }

    public function down()
    {
        $this->dropTable('Question');
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
