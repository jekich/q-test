<?php

use yii\db\Schema;
use yii\db\Migration;

class m150526_140023_update_doc_table extends Migration
{
    public function up()
    {
        $this->alterColumn('document', 'name', 'VARCHAR(255) NULL');
        $this->addColumn('document', 'status', 'TINYINT(1) NULL DEFAULT \'0\'');
    }

    public function down()
    {
        $this->alterColumn('documen', 'name', 'VARCHAR(255) NOT NULL');
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
