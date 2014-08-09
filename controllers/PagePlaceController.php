<?php

namespace webvimark\modules\content\controllers;

use Yii;
use webvimark\modules\content\models\PagePlace;
use webvimark\modules\content\models\search\PagePlaceSearch;
use webvimark\components\AdminDefaultController;
use yii\filters\VerbFilter;

/**
 * PagePlaceController implements the CRUD actions for PagePlace model.
 */
class PagePlaceController extends AdminDefaultController
{
	/**
	 * @var PagePlace
	 */
	public $modelClass = 'webvimark\modules\content\models\PagePlace';

	/**
	 * @var PagePlaceSearch
	 */
	public $modelSearchClass = 'webvimark\modules\content\models\search\PagePlaceSearch';

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
