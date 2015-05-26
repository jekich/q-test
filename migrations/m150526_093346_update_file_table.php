<?php

use yii\db\Schema;
use yii\db\Migration;

class m150526_093346_update_file_table extends Migration
{
    public function up()
    {

        $this->addColumn('file', 'deleted', 'TINYINT(1) UNSIGNED NULL DEFAULT \'0\'');
        $this->addColumn('file', 'size', 'BIGINT(20) NULL DEFAULT \'0\'');
        $this->addColumn('file', 'is_image', 'TINYINT(1) UNSIGNED NULL DEFAULT \'0\'');
    }

    public function down()
    {
        $this->dropColumn('file', 'deleted');
        $this->dropColumn('file', 'size');
        $this->dropColumn('file', 'is_image');
    }
}
