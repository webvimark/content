<?php

use yii\db\Schema;
use yii\db\Migration;

class m140727_152943_add_type_to_page_place extends Migration
{
	public function safeUp()
	{
		$this->addColumn('page_place', 'type', 'int not null');
		Yii::$app->cache->flush();

	}

	public function safeDown()
	{
		$this->dropColumn('page_place', 'type');
		Yii::$app->cache->flush();
	}
}
