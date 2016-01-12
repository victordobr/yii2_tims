<?php

use yii\db\Schema;
use yii\db\Migration;

class m160112_160251_rename_column_casestatus extends Migration
{
    const TABLE = "CaseStatus";
    public function up()
    {

    $this->renameColumn(self::TABLE,"StatusName","name");
    $this->renameColumn(self::TABLE,"StatusDescription","description");
    }

    public function down()
    {
        $this->renameColumn(self::TABLE,"name","StatusName");
        $this->renameColumn(self::TABLE,"description","StatusDescription");
    }

}
