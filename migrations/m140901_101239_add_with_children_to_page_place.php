<?php

use yii\db\Migration;

class m140901_101239_add_with_children_to_page_place extends Migration
{
	public function safeUp()
	{
		$this->addColumn('page_place', 'with_children', 'tinyint(1) not null default 1');
		Yii::$app->cache->flush();


	}

	public function safeDown()
	{
		$this->dropColumn('page_place', 'with_children');
		Yii::$app->cache->flush();
	}
}
