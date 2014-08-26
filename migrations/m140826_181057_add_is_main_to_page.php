<?php

use yii\db\Migration;

class m140826_181057_add_is_main_to_page extends Migration
{
	public function safeUp()
	{
		$this->addColumn('page', 'is_main', 'tinyint(1) not null default 0');
		Yii::$app->cache->flush();


	}

	public function safeDown()
	{
		$this->dropColumn('page', 'is_main');
		Yii::$app->cache->flush();
	}
}
