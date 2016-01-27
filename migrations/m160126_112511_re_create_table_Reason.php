<?php

use yii\db\Schema;
use yii\db\Migration;

class m160126_112511_re_create_table_Reason extends Migration
{
    const TABLE = 'Reason';

    public function safeUp()
    {
        $this->dropForeignKey('FK_Record_Reason', 'Record');
        $this->execute('DROP TABLE IF EXISTS ' . self::TABLE);
        $this->dropColumn('Record', 'reason_id');
        $this->createTable(
            self::TABLE,
            [
                'code' => Schema::TYPE_PK,
                'description' => Schema::TYPE_TEXT . ' NOT NULL DEFAULT ""',
            ],
            'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB'
        );
    }

    public function safeDown()
    {
        $this->dropTable(self::TABLE);
    }

}
