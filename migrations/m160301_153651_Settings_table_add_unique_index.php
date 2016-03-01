<?php

use yii\db\Migration;

class m160301_153651_Settings_table_add_unique_index extends Migration
{
    public function safeUp()
    {
        $this->createIndex('settings_unique_key_section', '{{%settings}}', ['section', 'key'], true);
    }

    public function safeDown()
    {
        $this->dropIndex('settings_unique_key_section', '{{%settings}}');
    }
}
