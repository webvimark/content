<?php

use yii\db\Schema;
use yii\db\Migration;

class m140720_155416_add_body_to_page extends Migration
{
	public function safeUp()
	{
		$this->addColumn('page', 'body', 'mediumtext not null');
		Yii::$app->cache->flush();

	}

	public function safeDown()
	{
		$this->dropColumn('page', 'body');
		Yii::$app->cache->flush();

	}
}
