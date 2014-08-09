<?php

namespace webvimark\modules\content\controllers;

use Yii;
use webvimark\modules\content\models\PageWidget;
use webvimark\modules\content\models\search\PageWidgetSearch;
use webvimark\components\AdminDefaultController;
use yii\filters\VerbFilter;

/**
 * PageWidgetController implements the CRUD actions for PageWidget model.
 */
class PageWidgetController extends AdminDefaultController
{
	/**
	 * @var PageWidget
	 */
	public $modelClass = 'webvimark\modules\content\models\PageWidget';

	/**
	 * @var PageWidgetSearch
	 */
	public $modelSearchClass = 'webvimark\modules\content\models\search\PageWidgetSearch';

	public function behaviors()
	{
		return [
			'verbs' => [
				'class' => VerbFilter::className(),
				'actions' => [
					'delete' => ['post'],
				],
			],
		];
	}
}
