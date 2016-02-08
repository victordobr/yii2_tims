<?php

use yii\db\Schema;
use yii\db\Migration;

class m160208_142401_User_email_unique extends Migration
{
    public function safeUp()
    {
        $this->execute("
            ALTER TABLE `User`
                ADD UNIQUE INDEX `email` (`email`);
        ");
    }

    public function safeDown()
    {
        $this->execute("
            ALTER TABLE `User`
                DROP INDEX `email`;
        ");
    }
}
