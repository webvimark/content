<?php

use yii\db\Schema;
use yii\db\Migration;

class m140716_193849_create_page_and_stuff extends Migration
{
	public function safeUp()
	{
		$tableOptions = null;
		if ( $this->db->driverName === 'mysql' )
		{
			$tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
		}

		$this->createTable('page_place', array(
			'id'         => 'pk',
			'active'     => 'tinyint(1) not null default 1',
			'sorter'     => 'int not null',
			'name'       => 'string not null',
			'code'       => 'string not null unique',
			'created_at' => 'int not null',
			'updated_at' => 'int not null',
		), $tableOptions);


		$this->createTable('page_layout', array(
			'id'         => 'pk',
			'active'     => 'tinyint(1) not null default 1',
			'sorter'     => 'int not null',
			'name'       => 'string not null',
			'code'       => 'string not null unique',
			'created_at' => 'int not null',
			'updated_at' => 'int not null',
		), $tableOptions);


		$this->createTable('page', array(
			'id'               => 'pk',
			'active'           => 'tinyint(1) not null default 1',
			'sorter'           => 'int not null',
			'name'             => 'string not null',
			'url'              => 'string not null',
			'parent_id'        => 'int',
			'page_place_id'    => 'int',
			'page_layout_id'   => 'int',
			'meta_title'       => 'string not null',
			'meta_keywords'    => 'string not null',
			'meta_description' => 'string not null',
			'created_at'       => 'int not null',
			'updated_at'       => 'int not null',
			0                  => 'FOREIGN KEY (parent_id) REFERENCES page (id) ON DELETE SET NULL ON UPDATE CASCADE',
			1                  => 'FOREIGN KEY (page_place_id) REFERENCES page_place (id) ON DELETE SET NULL ON UPDATE CASCADE',
			2                  => 'FOREIGN KEY (page_layout_id) REFERENCES page_layout (id) ON DELETE SET NULL ON UPDATE CASCADE',
		), $tableOptions);


		$this->createTable('page_text', array(
			'id'         => 'pk',
			'body'       => 'mediumtext not null',
			'page_id'    => 'int',
			'created_at' => 'int not null',
			'updated_at' => 'int not null',
			0            => 'FOREIGN KEY (page_id) REFERENCES page (id) ON DELETE CASCADE ON UPDATE CASCADE',
		), $tableOptions);


	}

	public function safeDown()
	{
		$this->dropTable('page_text');
		$this->dropTable('page');
		$this->dropTable('page_layout');
		$this->dropTable('page_place');

	}
}
