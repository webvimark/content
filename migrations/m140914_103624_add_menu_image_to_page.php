<?php

use yii\db\Migration;

class m140914_103624_add_menu_image_to_page extends Migration
{
	public function safeUp()
	{
		$this->addColumn('page', 'menu_image', 'string');
		Yii::$app->cache->flush();


	}

	public function safeDown()
	{
		$this->dropColumn('page', 'menu_image');
		Yii::$app->cache->flush();
	}
}
