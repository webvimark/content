<?php

use yii\db\Migration;

class m140914_101546_add_image_before_label_to_page_place extends Migration
{
	public function safeUp()
	{
		$this->addColumn('page_place', 'image_before_label', 'tinyint(1) not null default 0');
		Yii::$app->cache->flush();

	}

	public function safeDown()
	{
		$this->dropColumn('page_place', 'image_before_label');
		Yii::$app->cache->flush();
	}
}
