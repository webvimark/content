<?php

namespace app\modules\content\controllers;

use Yii;
use app\modules\content\models\TextBlock;
use app\modules\content\models\search\TextBlockSearch;
use webvimark\components\AdminDefaultController;
use yii\filters\VerbFilter;

/**
 * TextBlockController implements the CRUD actions for TextBlock model.
 */
class TextBlockController extends AdminDefaultController
{
	/**
	 * @var TextBlock
	 */
	public $modelClass = 'app\modules\content\models\TextBlock';

	/**
	 * @var TextBlockSearch
	 */
	public $modelSearchClass = 'app\modules\content\models\search\TextBlockSearch';

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
