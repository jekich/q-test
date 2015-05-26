<?php

use yii\db\Schema;
use yii\db\Migration;

class m150523_195251_init extends Migration
{
    public function up()
    {
        $this->createTable('document', [
            'id' => 'int(21) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY',
            'name' => 'varchar(255) NOT NULL',
            'description' => 'TEXT NULL'
        ]);

        $this->createTable('file', [
            'id' => 'int(21) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY',
            'name' => 'VARCHAR(255) NOT NULL',
            'original_name' => 'VARCHAR(255) NOT NULL',
            'owner_id' => 'INT(21) UNSIGNED NOT NULL',
        ]);

        $this->createIndex('name', 'file', 'name', true);
        $this->addForeignKey('FK_file_document', 'file', 'owner_id', 'document', 'id', 'cascade', 'cascade');
    }

    public function down()
    {
        $this->dropTable('file');
        $this->dropTable('document');
    }
}
