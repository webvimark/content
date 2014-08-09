<?php

namespace webvimark\modules\content\controllers;

use Yii;
use webvimark\modules\content\models\TextBlockPlace;
use webvimark\modules\content\models\search\TextBlockPlaceSearch;
use webvimark\components\AdminDefaultController;
use yii\filters\VerbFilter;

/**
 * TextBlockPlaceController implements the CRUD actions for TextBlockPlace model.
 */
class TextBlockPlaceController extends AdminDefaultController
{
	/**
	 * @var TextBlockPlace
	 */
	public $modelClass = 'webvimark\modules\content\models\TextBlockPlace';

	/**
	 * @var TextBlockPlaceSearch
	 */
	public $modelSearchClass = 'webvimark\modules\content\models\search\TextBlockPlaceSearch';

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
