<?php

use yii\db\Schema;
use yii\db\Migration;

class m140717_202526_add_is_main_to_page_layout extends Migration
{
	public function safeUp()
	{
		$this->addColumn('page_layout', 'is_main', 'tinyint(1) default 0');
		$this->addColumn('page_layout', 'is_system', 'tinyint(1) default 0');

		$this->dropColumn('page_layout', 'code');

		Yii::$app->cache->flush();


	}

	public function safeDown()
	{
		$this->dropColumn('page_layout', 'is_main');
		$this->dropColumn('page_layout', 'is_system');
		Yii::$app->cache->flush();

	}
}
