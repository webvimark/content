<?php

namespace webvimark\modules\content\controllers;

use webvimark\modules\content\models\PagePlace;
use Yii;
use webvimark\modules\content\models\Page;
use webvimark\modules\content\models\search\PageSearch;
use webvimark\components\AdminDefaultController;
use yii\base\Exception;
use yii\filters\VerbFilter;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;

/**
 * PageController implements the CRUD actions for Page model.
 */
class PageController extends AdminDefaultController
{
	/**
	 * @var Page
	 */
	public $modelClass = 'webvimark\modules\content\models\Page';

	/**
	 * @var PageSearch
	 */
	public $modelSearchClass = 'webvimark\modules\content\models\search\PageSearch';

	public function behaviors()
	{
		return [
			'verbs' => [
				'class' => VerbFilter::className(),
				'actions' => [
					'delete' => ['post'],
					'inline-save' => ['post'],
				],
			],
		];
	}

	/**
	 * For inline editing via CKEditor
	 * Echo back container ID
	 *
	 * @throws \yii\base\Exception
	 */
	public function actionInlineSave()
	{
		if ( Yii::$app->request->isAjax AND isset( $_POST['editabledata'], $_POST['editorID'] ) )
		{
			$pageId = ltrim($_POST['editorID'], 'content-page-');

			$model = Page::findOne($pageId);

			if ( !$model )
			{
				throw new NotFoundHttpException('Page not found');
			}

			$model->body = $_POST['editabledata'];
			$model->save(false);

			echo $_POST['editorID'];
		}
		else
		{
			throw new Exception("Couldn't save data");
		}
	}

	/**
	 * When $place is null - show pages without place
	 *
	 * @param string|null $place
	 *
	 * @return string
	 * @throws \yii\web\NotFoundHttpException
	 */
	public function actionTree($place = null)
	{
		if ( $place )
		{
			$pages = Page::find()
				->innerJoinWith(['pagePlace'])
				->where([
					'page_place.code'=>$place,
					'page_place.active'=>1,
				])
				->orderBy('page.sorter ASC')
				->all();
		}
		else
		{
			$pages = Page::find()
				->where('page.page_place_id IS NULL')
				->orderBy('page.sorter ASC')
				->all();
		}

		if ( $pages )
		{
			$pagePlace = $place ? $pages[0]->pagePlace : $place;
		}
		else
		{
			if ( $place )
			{
				$pagePlace = PagePlace::findOne(['code'=>$place]);

				if ( !$pagePlace )
					throw new NotFoundHttpException('Page not found');
			}
			else
			{
				$pagePlace = null;
			}

		}

		return $this->render('tree', compact('pages', 'pagePlace'));
	}

	/**
	 * @inheritdoc
	 */
	public function actionCreate($type = null, $place = null)
	{
		if ( $place )
		{
			$pagePlace = PagePlace::findOne(['code'=>$place]);

			if ( !$pagePlace )
				throw new NotFoundHttpException('Page not found');

			$placeName = $pagePlace->name;
		}
		else
		{
			$placeName = PagePlace::NO_PLACE_NAME;
		}

		$model = new Page();

		// If type is not sent or sent wrong type - use default type (TYPE_TEXT)
		$type = ($type === null) ? Page::TYPE_TEXT : $type;
		$model->type = in_array($type, [Page::TYPE_LINK, Page::TYPE_TEXT]) ? $type : Page::TYPE_TEXT;

		$model->scenario = $model->type . '_scenario';

		if ( isset($pagePlace) )
		{
			$model->page_place_id = $pagePlace->id;
		}

		if ( $model->load(Yii::$app->request->post()) && $model->save() )
		{
			return $this->redirect(['view',	'id' => $model->id]);
		}

		return $this->renderIsAjax('create', compact('model', 'place', 'placeName'));
	}

	/**
	 * @inheritdoc
	 */
	public function actionUpdate($id)
	{
		$model = $this->findModel($id);
		$model->scenario = $model->type . '_scenario';

		if ( $model->load(Yii::$app->request->post()) )
		{
			if ( $model->validate() )
			{
				if ( $model->oldAttributes['page_place_id'] != $model->page_place_id )
					$model->parent_id = null;

				$model->save(false);

				return $this->redirect(['view',	'id' => $model->id]);
			}
		}

		return $this->renderIsAjax('update', compact('model'));
	}

	/**
	 * Delete menu image
	 *
	 * @param int $pageId
	 */
	public function actionDeleteMenuImage($pageId)
	{
		$page = Page::findOne($pageId);

		if ( $page )
		{
			$page->deleteImage($page->menu_image);

			$page->menu_image = null;
			$page->save(false);
		}

		$this->redirect(['update', 'id'=>$pageId]);
	}

	/**
	 * @inheritdoc
	 */
	protected function getRedirectPage($action, $model = null)
	{
		if ( $action == 'delete' )
		{
			return ['tree', 'place'=>@$model->pagePlace->code];
		}

		return parent::getRedirectPage($action, $model);
	}
}
