<?php

use yii\db\Schema;
use yii\db\Migration;

class m160106_152728_table_car_model_year2 extends Migration
{
    public function up()
    {
        $sql = "
CREATE TABLE IF NOT EXISTS `Vehicle` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `year` int(4) unsigned NOT NULL,
  `make` varchar(50) DEFAULT NULL,
  `model` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `U_VehicleModelYear_year_make_model` (`year`,`make`,`model`),
  KEY `I_VehicleModelYear_year` (`year`),
  KEY `I_VehicleModelYear_make` (`make`),
  KEY `I_VehicleModelYear_model` (`model`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ";

        $this->execute($sql);
    }

    public function down()
    {
        $this->dropTable('Vehicle');

    }
    
    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }
    
    public function safeDown()
    {
    }
    */
}
