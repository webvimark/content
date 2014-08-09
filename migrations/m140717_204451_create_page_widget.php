<?php

use yii\db\Schema;
use yii\db\Migration;

class m140717_204451_create_page_widget extends Migration
{
	public function safeUp()
	{
		$tableOptions = null;
		if ( $this->db->driverName === 'mysql' )
		{
			$tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
		}

		$this->createTable('page_widget', array(
			'id'           => 'pk',
			'active'       => 'tinyint(1) not null default 1',
			'sorter'       => 'int not null',
			'position'     => 'int(1) not null',
			'name'         => 'string not null',
			'description'  => 'string not null',
			'class'        => 'string not null',
			'options'      => 'string not null',
			'has_settings' => 'tinyint(1) not null default 0',
			'settings_url' => 'string not null',
			'created_at'   => 'int not null',
			'updated_at'   => 'int not null',
		), $tableOptions);


		$this->createTable('page_layout_has_page_widget', array(
			'id'             => 'pk',
			'page_layout_id' => 'int',
			'page_widget_id'    => 'int',
			'sorter'         => 'int not null',
			'position'       => 'int(1) not null',
			'created_at'     => 'int not null',
			'updated_at'     => 'int not null',
			0                => 'FOREIGN KEY (page_layout_id) REFERENCES page_layout (id) ON DELETE CASCADE ON UPDATE CASCADE',
			1                => 'FOREIGN KEY (page_widget_id) REFERENCES page_widget (id) ON DELETE CASCADE ON UPDATE CASCADE',
		), $tableOptions);


	}

	public function safeDown()
	{
		$this->dropTable('page_layout_has_page_widget');
		$this->dropTable('page_widget');

	}
}
