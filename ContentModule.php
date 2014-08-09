<?php

namespace webvimark\modules\content;

class ContentModule extends \yii\base\Module
{
	public $left3ColumnCssClass = 'col-xs-3';
	public $center3ColumnCssClass = 'col-xs-6';
	public $right3ColumnCssClass = 'col-xs-3';

	public $left2ColumnCssClass = 'col-xs-3';
	public $center2ColumnCssClass = 'col-xs-9';
	public $right2ColumnCssClass = 'col-xs-3';

	public $center1ColumnCssClass = 'col-xs-12';

	/**
	 * This layout is a parent for 4 default content layouts
	 *
	 * @var string
	 */
	public $defaultParentLayout = '@app/views/layouts/main.php';

	public $controllerNamespace = 'webvimark\modules\content\controllers';

	public function init()
	{
		parent::init();

		// custom initialization code goes here
	}
}
