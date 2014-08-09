<?php

namespace webvimark\modules\content\controllers;

use Yii;
use webvimark\modules\content\models\PageSystemPlace;
use webvimark\modules\content\models\search\PageSystemPlaceSearch;
use webvimark\components\AdminDefaultController;
use yii\filters\VerbFilter;

/**
 * PageSystemPlaceController implements the CRUD actions for PageSystemPlace model.
 */
class PageSystemPlaceController extends AdminDefaultController
{
	/**
	 * @var PageSystemPlace
	 */
	public $modelClass = 'webvimark\modules\content\models\PageSystemPlace';

	/**
	 * @var PageSystemPlaceSearch
	 */
	public $modelSearchClass = 'webvimark\modules\content\models\search\PageSystemPlaceSearch';

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
