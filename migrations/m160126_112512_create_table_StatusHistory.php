<?php

use yii\db\Schema;
use yii\db\Migration;

class m160126_112512_create_table_StatusHistory extends Migration
{
    const TABLE = 'StatusHistory';

    public function up()
    {
        $this->execute('SET FOREIGN_KEY_CHECKS=0');
        $this->createTable(
            self::TABLE,
            [
                'id' => Schema::TYPE_PK,
                'parent_id' => Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 0',
                'record_id'=>Schema::TYPE_INTEGER .' UNSIGNED NOT NULL',
                'author_id'=>Schema::TYPE_INTEGER .' UNSIGNED NOT NULL',
                'status_code' => Schema::TYPE_INTEGER . ' NULL',
                'reason_code' => Schema::TYPE_INTEGER . ' NULL',
                'created_at' => Schema::TYPE_INTEGER . ' NOT NULL',
                'expired_at' => Schema::TYPE_INTEGER . ' NULL',
            ],
            'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB'
        );
        $this->addForeignKey('FK_Status_Code', self::TABLE, ['status_code'], 'CaseStatus', ['id'], 'CASCADE', 'CASCADE');
        $this->addForeignKey('FK_Status_Record', self::TABLE, ['record_id'], 'Record', ['id'], 'CASCADE', 'CASCADE');
        $this->addForeignKey('FK_Status_User', self::TABLE, ['author_id'], 'User', ['id'], 'CASCADE', 'CASCADE');
        $this->addForeignKey('FK_Status_Reason', self::TABLE, ['reason_code'], 'Reason', ['code'], 'CASCADE', 'CASCADE');
        $this->execute('SET FOREIGN_KEY_CHECKS=1');
    }

    public function down()
    {
        $this->dropTable(self::TABLE);
    }

}
