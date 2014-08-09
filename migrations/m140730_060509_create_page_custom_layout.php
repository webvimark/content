<?php

use yii\db\Schema;
use yii\db\Migration;

class m140730_060509_create_page_custom_layout extends Migration
{
	public function safeUp()
	{
		$tableOptions = null;
		if ( $this->db->driverName === 'mysql' )
		{
			$tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
		}

		$this->createTable('page_custom_layout', [
			'id'         => 'pk',
			'active'     => 'tinyint(1) not null default 1',
			'type'       => 'int not null',
			'name'       => 'string not null',
			'path'       => 'string not null',

			'created_at' => 'int not null',
			'updated_at' => 'int not null',
		], $tableOptions);

		$this->addColumn('page', 'page_custom_layout_id', 'int');
		$this->addForeignKey('fk_page_page_custom_layout_id', 'page', 'page_custom_layout_id', 'page_custom_layout', 'id', 'SET NULL', 'CASCADE');
		Yii::$app->cache->flush();

	}

	public function safeDown()
	{
		$this->dropForeignKey('fk_page_page_custom_layout_id', 'page');
		$this->dropColumn('page', 'page_custom_layout_id');
		Yii::$app->cache->flush();

		$this->dropTable('page_custom_layout');

	}
}
