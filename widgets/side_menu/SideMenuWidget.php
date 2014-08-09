<?php
namespace webvimark\modules\content\widgets\side_menu;


use yii\base\Widget;

class SideMenuWidget extends Widget
{
	public $place;

	public function run()
	{
		return $this->render('index');
	}
} 