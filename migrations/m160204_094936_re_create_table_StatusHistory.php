<?php

use yii\db\Schema;
use yii\db\Migration;

class m160204_094936_re_create_table_StatusHistory extends Migration
{
    const TABLE = 'StatusHistory';

    public function up()
    {
        $this->execute('SET FOREIGN_KEY_CHECKS = 0');
        $this->dropTable(self::TABLE);
        $this->createTable(
            self::TABLE,
            [
                'id' => Schema::TYPE_PK,
                'record_id'=>Schema::TYPE_INTEGER .' UNSIGNED NOT NULL',
                'author_id'=>Schema::TYPE_INTEGER .' UNSIGNED NOT NULL',
                'status_code' => Schema::TYPE_INTEGER . ' NOT NULL',
                'created_at' => Schema::TYPE_INTEGER . ' NOT NULL',
                'expired_at' => Schema::TYPE_INTEGER . ' NULL',
            ],
            'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB'
        );
        $this->addForeignKey('FK_Status_Code', self::TABLE, ['status_code'], 'CaseStatus', ['id'], 'CASCADE', 'CASCADE');
        $this->addForeignKey('FK_Status_Record', self::TABLE, ['record_id'], 'Record', ['id'], 'CASCADE', 'CASCADE');
        $this->addForeignKey('FK_Status_User', self::TABLE, ['author_id'], 'User', ['id'], 'CASCADE', 'CASCADE');
        $this->execute('SET FOREIGN_KEY_CHECKS = 1');
    }

    public function down()
    {
        $this->execute('SET FOREIGN_KEY_CHECKS = 0');
        $this->dropTable(self::TABLE);
        $this->execute(
            'CREATE TABLE StatusHistory
            (
                id INT(11) PRIMARY KEY NOT NULL,
                record_id INT(11) UNSIGNED NOT NULL,
                author_id INT(11) UNSIGNED NOT NULL,
                status_code INT(11),
                reason_code INT(11),
                created_at INT(11) NOT NULL,
                expired_at INT(11),
                stage_id INT(11) UNSIGNED NOT NULL,
                CONSTRAINT FK_Status_Code FOREIGN KEY (status_code) REFERENCES CaseStatus (id),
                CONSTRAINT FK_Status_Reason FOREIGN KEY (reason_code) REFERENCES Reason (code),
                CONSTRAINT FK_Status_Record FOREIGN KEY (record_id) REFERENCES Record (id),
                CONSTRAINT FK_Status_User FOREIGN KEY (author_id) REFERENCES User (id)
            );
            CREATE INDEX FK_Status_Code ON StatusHistory (status_code);
            CREATE INDEX FK_Status_Reason ON StatusHistory (reason_code);
            CREATE INDEX FK_Status_User ON StatusHistory (author_id);
            CREATE UNIQUE INDEX UK_Record_Stage ON StatusHistory (record_id, stage_id);'
        );
        $this->execute('SET FOREIGN_KEY_CHECKS = 1');
    }

}
