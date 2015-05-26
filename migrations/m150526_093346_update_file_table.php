<?php

use yii\db\Schema;
use yii\db\Migration;

class m150526_093346_update_file_table extends Migration
{
    public function up()
    {

        $this->addColumn('file', 'deleted', 'TINYINT(1) UNSIGNED NULL DEFAULT \'0\'');
        $this->dropForeignKey('FK_file_document', 'file');
    }

    public function down()
    {
        $this->dropColumn('file', 'deleted');
        $this->addForeignKey('FK_file_document', 'file', 'owner_id', 'document', 'id', 'cascade', 'cascade');
    }
}
