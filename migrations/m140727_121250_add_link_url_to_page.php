<?php

use yii\db\Schema;
use yii\db\Migration;

class m140727_121250_add_link_url_to_page extends Migration
{
	public function safeUp()
	{
		$this->addColumn('page', 'link_url', 'varchar(255) not null');
		Yii::$app->cache->flush();
	}

	public function safeDown()
	{
		$this->dropColumn('page', 'link_url');
		Yii::$app->cache->flush();
	}
}
