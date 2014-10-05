<?php

use yii\db\Migration;

class m141002_132950_add_only_one_to_page_widget extends Migration
{
	public function safeUp()
	{
		$this->addColumn('page_widget', 'only_one', 'tinyint(1) not null default 0');
		Yii::$app->cache->flush();


	}

	public function safeDown()
	{
		$this->dropColumn('page_widget', 'only_one');
		Yii::$app->cache->flush();
	}
}
