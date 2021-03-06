<?php

namespace webvimark\modules\content;

class ContentModule extends \yii\base\Module
{
	public $left3ColumnCssClass = 'col-xs-15';
	public $center3ColumnCssClass = 'col-xs-30';
	public $right3ColumnCssClass = 'col-xs-15';

	public $left2ColumnCssClass = 'col-xs-15';
	public $centerForLeft2ColumnCssClass = 'col-xs-45';

	public $right2ColumnCssClass = 'col-xs-15';
	public $centerForRight2ColumnCssClass = 'col-xs-45';

	public $center1ColumnCssClass = 'col-xs-60';

	public $wrapperCssClass = 'container page-middle-wrapper';

	/**
	 * This layout is a parent for 4 default content layouts
	 *
	 * @var string
	 */
	public $defaultParentLayout = '@app/views/layouts/main.php';

	public $controllerNamespace = 'webvimark\modules\content\controllers';

	public $cacheTime = 86400; // 24 hours

	/**
	 * Little feature for webvimark/module-user-management
	 *
	 * Set freeAccess true or false for "ViewController" where all pages rendered
	 *
	 * @var bool
	 */
	public $freeAccess = false;

	public function init()
	{
		parent::init();

		// custom initialization code goes here
	}
}
