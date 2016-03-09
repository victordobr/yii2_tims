<?php

use yii\db\Migration;
use yii\db\Schema;

class m160309_103034_re_create_Citation extends Migration
{
    const TABLE = 'Citation';

    public function up()
    {
        $this->dropTable(self::TABLE);
        $this->createTable(
            self::TABLE,
            [
                'id' => Schema::TYPE_PK,
                'owner_id' => Schema::TYPE_INTEGER . ' UNSIGNED NOT NULL',
                'location_code' => Schema::TYPE_STRING . ' NOT NULL DEFAULT ""',
                'citation_number' => Schema::TYPE_STRING . ' NOT NULL DEFAULT ""',
                'unique_passcode' => Schema::TYPE_STRING . ' NOT NULL DEFAULT ""',
                'is_active' => 'TINYINT(1) UNSIGNED NOT NULL DEFAULT 0',
                'status' => 'TINYINT(1) UNSIGNED NOT NULL DEFAULT 0', // default - unpaid
                'created_at' => Schema::TYPE_INTEGER . ' NOT NULL',
                'penalty' => Schema::TYPE_INTEGER . ' NOT NULL',
                'fee' => Schema::TYPE_INTEGER . ' NOT NULL',
                'expired_at' => Schema::TYPE_INTEGER . ' NOT NULL',
            ],
            'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB'
        );
        $this->addForeignKey('FK_Citation_Owner', self::TABLE, ['owner_id'], 'Owner', ['id'], 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->dropTable(self::TABLE);
        $this->createTable(
            self::TABLE,
            [
                'id' => Schema::TYPE_PK,
                'record_id' => Schema::TYPE_INTEGER . ' UNSIGNED NOT NULL',
                'location_code' => Schema::TYPE_STRING . ' NOT NULL DEFAULT ""',
                'citation_number' => Schema::TYPE_STRING . ' NOT NULL DEFAULT ""',
                'unique_passcode' => Schema::TYPE_STRING . ' NOT NULL DEFAULT ""',
                'is_logged' => 'TINYINT(1) UNSIGNED NOT NULL DEFAULT 0',
                'status' => 'TINYINT(1) UNSIGNED NOT NULL DEFAULT 0', // default - unpaid
                'created_at' => Schema::TYPE_INTEGER . ' NOT NULL',
            ],
            'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB'
        );
        $this->addForeignKey('FK_Public_User_Record', self::TABLE, ['record_id'], 'Record', ['id'], 'CASCADE', 'CASCADE');
    }

}
