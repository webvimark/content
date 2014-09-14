<?php

use yii\db\Migration;

class m140914_082113_add_with_image_to_page_place extends Migration
{
	public function safeUp()
	{
		$this->addColumn('page_place', 'with_image', 'tinyint(1) not null default 0');
		Yii::$app->cache->flush();

	}

	public function safeDown()
	{
		$this->dropColumn('page_place', 'with_image');
		Yii::$app->cache->flush();
	}
}
