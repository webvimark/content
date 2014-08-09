<?php

use yii\db\Schema;
use yii\db\Migration;

class m140731_052738_create_page_system_place extends Migration
{
	public function safeUp()
	{
		$tableOptions = null;
		if ( $this->db->driverName === 'mysql' )
		{
			$tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
		}

$this->createTable('page_system_place', array (
  'id' => 'pk',
  'active' => 'tinyint(1) not null default 1',
  'sorter' => 'int not null',
  'name' => 'string not null',
  'path' => 'string not null',
  'created_at' => 'int not null',
  'updated_at' => 'int not null',
), $tableOptions);



	}

	public function safeDown()
	{
		$this->dropTable('page_system_place');

	}
}
