<?php

use yii\db\Schema;
use yii\db\Migration;

class m160118_162627_Record_table_create extends Migration
{
    public function safeUp()
    {
        $record = 'CREATE TABLE Record (
            id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
            lat VARCHAR(20) NOT NULL,
            lng VARCHAR(20) NOT NULL,
            infraction_date INT(10) UNSIGNED NOT NULL,
            open_date INT(10) UNSIGNED NOT NULL,
            state_id INT(10) UNSIGNED NOT NULL,
            license VARCHAR(250) NOT NULL,
            user_id INT(10) UNSIGNED NOT NULL,
            ticket_fee INT(10) UNSIGNED DEFAULT NULL,
            ticket_payment_expire_date INT(10) UNSIGNED DEFAULT NULL,
            comments text DEFAULT NULL,
            user_plea_request text DEFAULT NULL,
            status_id INT(10) UNSIGNED DEFAULT 1010 NOT NULL,
            created_at INT(10) UNSIGNED,
            PRIMARY KEY (id),
            CONSTRAINT FK_Record_User FOREIGN KEY (user_id) REFERENCES User (id)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        CREATE INDEX FK_Record_User ON Evidence (user_id);';

        $this->execute($record);
    }

    public function safeDown()
    {
        $this->dropTable('Record');
    }
}
