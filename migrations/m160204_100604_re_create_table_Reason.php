<?php

use yii\db\Schema;
use yii\db\Migration;

class m160204_100604_re_create_table_Reason extends Migration
{
    const TABLE = 'Reason';

    public function up()
    {
        $this->execute('SET FOREIGN_KEY_CHECKS = 0');
        $this->dropTable(self::TABLE);
        $this->createTable(
            self::TABLE,
            [
                'status_history_id' => Schema::TYPE_PK,
                'code' => Schema::TYPE_INTEGER . ' UNSIGNED NOT NULL',
                'description' => Schema::TYPE_TEXT . ' NOT NULL',
            ],
            'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB'
        );
        $this->addForeignKey('FK_Reason_Status', self::TABLE, ['status_history_id'], 'StatusHistory', ['id'], 'CASCADE', 'CASCADE');
        $this->execute('SET FOREIGN_KEY_CHECKS = 1');
    }

    public function down()
    {
        $this->execute('SET FOREIGN_KEY_CHECKS = 0');
        $this->dropTable(self::TABLE);
        $this->execute(
            'CREATE TABLE Reason
            (
                code INT(11) PRIMARY KEY NOT NULL,
                description TEXT NOT NULL
            );'
        );
        $this->execute('SET FOREIGN_KEY_CHECKS = 1');
    }
}
