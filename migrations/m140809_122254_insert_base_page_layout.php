<?php

use yii\db\Migration;

class m140809_122254_insert_base_page_layout extends Migration
{
	public function safeUp()
	{
		$this->insert('page_layout', [
			'active'    => 1,
			'is_main'   => 1,
			'is_system' => 1,
			'name'      => 'Базовый шаблон',
		]);
	}

	public function safeDown()
	{
		$this->delete('page_layout', [
			'is_main'   => 1,
			'is_system' => 1,
			'name'      => 'Базовый шаблон',
		]);
	}
}
