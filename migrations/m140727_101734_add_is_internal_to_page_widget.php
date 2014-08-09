<?php

use yii\db\Schema;
use yii\db\Migration;

class m140727_101734_add_is_internal_to_page_widget extends Migration
{
	public function safeUp()
	{
		$this->addColumn('page_widget', 'is_internal', 'tinyint(1) not null default 0');
		Yii::$app->cache->flush();
	}

	public function safeDown()
	{
		$this->dropColumn('page_widget', 'is_internal');
		Yii::$app->cache->flush();
	}
}
