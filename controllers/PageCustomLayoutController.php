<?php

namespace webvimark\modules\content\controllers;

use Yii;
use webvimark\modules\content\models\PageCustomLayout;
use webvimark\modules\content\models\search\PageCustomLayoutSearch;
use webvimark\components\AdminDefaultController;
use yii\filters\VerbFilter;

/**
 * PageCustomLayoutController implements the CRUD actions for PageCustomLayout model.
 */
class PageCustomLayoutController extends AdminDefaultController
{
	/**
	 * @var PageCustomLayout
	 */
	public $modelClass = 'webvimark\modules\content\models\PageCustomLayout';

	/**
	 * @var PageCustomLayoutSearch
	 */
	public $modelSearchClass = 'webvimark\modules\content\models\search\PageCustomLayoutSearch';

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
