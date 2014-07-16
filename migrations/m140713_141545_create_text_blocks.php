<?php

use yii\db\Schema;
use yii\db\Migration;

class m140713_141545_create_text_blocks extends Migration
{
	public function safeUp()
	{
		$tableOptions = null;
		if ( $this->db->driverName === 'mysql' )
		{
			$tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
		}

		$this->createTable('text_block_place', array(
			'id'         => 'pk',
			'active'     => 'tinyint(1) not null default 1',
			'one_record' => 'tinyint(1) not null default 1',
			'name'       => 'string not null',
			'code'       => 'string not null unique',
			'created_at' => 'int not null',
			'updated_at' => 'int not null',
		), $tableOptions);


		$this->createTable('text_block', array(
			'id'                  => 'pk',
			'active'              => 'tinyint(1) not null default 1',
			'text_block_place_id' => 'int not null',
			'sorter'              => 'int not null',
			'name'                => 'string not null',
			'body'                => 'mediumtext not null',
			'created_at'          => 'int not null',
			'updated_at'          => 'int not null',
			0                     => 'FOREIGN KEY (text_block_place_id) REFERENCES text_block_place (id) ON DELETE CASCADE ON UPDATE CASCADE',
		), $tableOptions);


	}

	public function safeDown()
	{
		$this->dropTable('text_block');
		$this->dropTable('text_block_place');

	}
}
