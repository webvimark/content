<?php

namespace webvimark\modules\content\controllers;

use webvimark\modules\content\models\PageLayoutHasPageWidget;
use webvimark\modules\content\models\PageWidget;
use Yii;
use webvimark\modules\content\models\PageLayout;
use webvimark\modules\content\models\search\PageLayoutSearch;
use webvimark\components\AdminDefaultController;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;

/**
 * PageLayoutController implements the CRUD actions for PageLayout model.
 */
class PageLayoutController extends AdminDefaultController
{
	/**
	 * @var PageLayout
	 */
	public $modelClass = 'webvimark\modules\content\models\PageLayout';

	/**
	 * @var PageLayoutSearch
	 */
	public $modelSearchClass = 'webvimark\modules\content\models\search\PageLayoutSearch';

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


	/**
	 * Displays a single model.
	 *
	 * @param integer $id
	 *
	 * @return mixed
	 */
	public function actionView($id)
	{
		$model = $this->findModel($id);

		$groupedWidgets = $model->getWidgetsGroupedByPosition();

		if ( isset( $_POST['sorted-widgets']) )
		{
			PageLayoutHasPageWidget::deleteAll(['page_layout_id'=>$id]);

			foreach ($_POST['sorted-widgets'] as $position => $widgets)
			{
				$sorter = 0;
				foreach ($widgets as $widgetId)
				{
					$layoutWidget = new PageLayoutHasPageWidget();
					$layoutWidget->page_layout_id = $id;
					$layoutWidget->page_widget_id = $widgetId;
					$layoutWidget->position = $position;
					$layoutWidget->sorter = $sorter;
					$layoutWidget->save(false);

					$sorter++;
				}
			}

			$this->redirect(['view', 'id'=>$id]);

		}

		return $this->renderIsAjax('view', compact('model', 'groupedWidgets'));
	}

	/**
	 * @param int $id - PageLayout ID
	 */
	public function actionClonePageLayout($id)
	{
		$model = $this->findModel($id);

		$newModel = new PageLayout();

		// Clone attributes
		foreach ($model->attributes as $name => $value)
		{
			if ( in_array($name, ['id', 'is_main', 'is_system']) )
				continue;

			if ( $name == 'name' )
			{
				$value .= ' (Копия)';
			}

			$newModel->$name = $value;
		}

		$newModel->save(false);

		// Clone widget positions
		foreach ($model->pageLayoutHasPageWidgets as $prototypeLayoutWidget)
		{
			$layoutWidget = new PageLayoutHasPageWidget();
			$layoutWidget->page_layout_id = $newModel->id;
			$layoutWidget->page_widget_id = $prototypeLayoutWidget->page_widget_id;
			$layoutWidget->position = $prototypeLayoutWidget->position;
			$layoutWidget->sorter = $prototypeLayoutWidget->position;
			$layoutWidget->save(false);
		}
	}

	/**
	 * @param int $widgetId
	 * @param int $position
	 *
	 * @return string
	 * @throws \yii\web\NotFoundHttpException
	 */
	public function actionAddWidget($widgetId, $position)
	{
		$widget = PageWidget::findOne([
			'id'=>$widgetId,
			'active'=>1,
		]);

		if ( !$widget )
			throw new NotFoundHttpException('Widget not found');

		return $this->renderPartial('addWidget', compact('widget', 'position'));
	}
}
