<?php

use yii\db\Migration;
use yii\db\Schema;
//use yii\db\mysql\Schema;

class m160309_093910_re_create_Vehicle extends Migration
{
    const TABLE = 'Vehicle';

    private $dump = 'CREATE TABLE Vehicle
(
    id INT(10) UNSIGNED PRIMARY KEY NOT NULL,
    year INT(4) UNSIGNED NOT NULL,
    make VARCHAR(50),
    model VARCHAR(50) NOT NULL
);
CREATE INDEX I_VehicleModelYear_make ON Vehicle (make);
CREATE INDEX I_VehicleModelYear_model ON Vehicle (model);
CREATE INDEX I_VehicleModelYear_year ON Vehicle (year);
CREATE UNIQUE INDEX U_VehicleModelYear_year_make_model ON Vehicle (year, make, model);';

    private $columns = [
        'id' => Schema::TYPE_PK,
        'tag' => 'VARCHAR(12) NOT NULL',
        'state' => 'INT(11) UNSIGNED NOT NULL',
        'make' => 'VARCHAR(30) NOT NULL',
        'model' => 'VARCHAR(30) NOT NULL',
        'year' => 'VARCHAR(4) NOT NULL',
        'color' => 'VARCHAR(32) NOT NULL',
        'owner_id' => 'INT(11) UNSIGNED NOT NULL',
    ];

    private $options = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';

    public function up()
    {
        $this->dropTable(self::TABLE);
        $this->createTable(self::TABLE, $this->columns, $this->options);
        $this->addForeignKey('FK_Vehicle_Owner', self::TABLE, ['owner_id'], 'Owner', ['id'], 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->dropTable(self::TABLE);
        $this->execute($this->dump);
    }

}
