<?php

use yii\db\Schema;
use yii\db\Migration;

class m140727_120013_add_type_to_page extends Migration
{
	public function safeUp()
	{
		$this->addColumn('page', 'type', 'int not null default 0');
		Yii::$app->cache->flush();
	}

	public function safeDown()
	{
		$this->dropColumn('page', 'type');
		Yii::$app->cache->flush();
	}
}
