<?php

namespace app\modules\content\controllers;

use Yii;
use app\modules\content\models\TextBlockPlace;
use app\modules\content\models\search\TextBlockPlaceSearch;
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
	public $modelClass = 'app\modules\content\models\TextBlockPlace';

	/**
	 * @var TextBlockPlaceSearch
	 */
	public $modelSearchClass = 'app\modules\content\models\search\TextBlockPlaceSearch';

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
