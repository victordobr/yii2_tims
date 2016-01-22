<?php

use yii\db\Migration;

class m160120_150421_Case_and_evidence_remove_tables extends Migration
{
    public function safeUp()
    {
        $this->execute('SET FOREIGN_KEY_CHECKS = 0;');
        $this->dropTable('Evidence');
        $this->dropTable('PoliceCase');
        $this->execute('SET FOREIGN_KEY_CHECKS = 1;');
    }

    public function safeDown()
    {
        $policeCase = 'CREATE TABLE PoliceCase
        (
            id INT(10) UNSIGNED PRIMARY KEY NOT NULL,
            status_id INT(10) UNSIGNED DEFAULT \'1\' NOT NULL,
            created_at INT(10) UNSIGNED,
            open_date INT(10) UNSIGNED,
            officer_date INT(10) UNSIGNED,
            mailed_date INT(10) UNSIGNED,
            officer_pin VARCHAR(250),
            officer_id INT(11) UNSIGNED
        );';
        $evidence = 'CREATE TABLE Evidence
        (
            id INT(10) UNSIGNED PRIMARY KEY NOT NULL,
            case_id INT(10) UNSIGNED NOT NULL,
            user_id INT(10) UNSIGNED,
            license VARCHAR(250) NOT NULL,
            lat VARCHAR(20) NOT NULL,
            lng VARCHAR(20) NOT NULL,
            state_id INT(10) UNSIGNED NOT NULL,
            infraction_date INT(10) UNSIGNED,
            created_at INT(10) UNSIGNED,
            CONSTRAINT FK_Evidence_Case FOREIGN KEY (case_id) REFERENCES PoliceCase (id),
            CONSTRAINT FK_Evidence_User FOREIGN KEY (user_id) REFERENCES User (id)
        );
        CREATE UNIQUE INDEX FK_Evidence_Case ON Evidence (case_id);
        CREATE INDEX FK_Evidence_User ON Evidence (user_id);';

        $this->execute('SET FOREIGN_KEY_CHECKS = 0;');
        $this->execute($evidence);
        $this->execute($policeCase);
        $this->execute('SET FOREIGN_KEY_CHECKS = 1;');
    }
}