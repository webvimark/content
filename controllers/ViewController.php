<?php

namespace webvimark\modules\content\controllers;

use webvimark\helpers\Singleton;
use webvimark\modules\content\models\Page;
use webvimark\modules\content\models\PageCustomLayout;
use webvimark\modules\content\models\PageLayout;
use webvimark\components\BaseController;
use yii\caching\DbDependency;
use yii\web\NotFoundHttpException;
use Yii;

/**
 * Class ViewController
 *
 * Public controller to browse pages
 *
 * @package webvimark\modules\content\controllers
 */
class ViewController extends BaseController
{
	/**
	 * Little feature for webvimark/module-user-management
	 *
	 * Set freeAccess true or false in config.php for content module
	 *
	 * @var bool
	 */
	public $freeAccess = false;

	/**
	 * Little feature for webvimark/module-user-management
	 */
	public function init()
	{
		$this->freeAccess = $this->module->freeAccess;

		parent::init();
	}

	/**
	 * @param string $url
	 *
	 * @throws \yii\web\NotFoundHttpException
	 * @return string
	 */
	public function actionPage($url)
	{
		$page = $this->getCachedPageByUrl($url);

		if ( !$page )
			throw new NotFoundHttpException('Page not found');

		// If page hasn't defined layout - use main layout
		$pageLayout = $page->pageLayout ? $page->pageLayout : PageLayout::findOne(['is_main'=>1]);

		$layoutWidgets = $pageLayout->getWidgetsGroupedByPosition();

		Singleton::setData('_contentLayoutWidgets', $layoutWidgets);


		// If page has defined custom layout - use it
		if ( $page->page_custom_layout_id AND $page->pageCustomLayout->active == 1 )
		{
			if ( $page->pageCustomLayout->type == PageCustomLayout::TYPE_REPLACE )
			{
				$this->layout = $page->pageCustomLayout->path;
			}
			else
			{
				$this->module->defaultParentLayout = $page->pageCustomLayout->path;

				$this->layout = $this->getLayoutBasedOnWidgetPositions($layoutWidgets);
			}
		}
		else
		{
			$this->layout = $this->getLayoutBasedOnWidgetPositions($layoutWidgets);
		}

		return $this->render('page', compact('page'));
	}

	/**
	 * @param string $url
	 *
	 * @return Page
	 */
	protected function getCachedPageByUrl($url)
	{
		$cacheKey = '__content_actionPage_page' . $url;
		$page = Yii::$app->cache->get($cacheKey);

		if ( $page === false )
		{
			$page = Page::find()
				->joinWith(['pageLayout'])
				->where([
					'page.url'=>$url,
					'page.active'=>1,
				])
				->one();

			$dependency = new DbDependency();
			$dependency->sql = 'SELECT MAX(updated_at) FROM (SELECT updated_at FROM page UNION SELECT updated_at FROM page_layout) as cache_content_actionPage_page';

			Yii::$app->cache->set($cacheKey, $page, Yii::$app->getModule('content')->cacheTime, $dependency);
		}

		return $page;
	}

	/**
	 * Define which of 4 default layouts use (1, 2 or 3 columns)
	 *
	 * @param array $layoutWidgets
	 *
	 * @return string
	 */
	protected function getLayoutBasedOnWidgetPositions($layoutWidgets)
	{
		if ( count($layoutWidgets['left']) > 0 AND count($layoutWidgets['right']) > 0 ) // 3 columns
		{
			return 'left_center_right';
		}
		elseif ( count($layoutWidgets['left']) > 0 AND count($layoutWidgets['right']) == 0 ) // 2 columns (left)
		{
			return 'left_center';
		}
		elseif ( count($layoutWidgets['left']) == 0 AND count($layoutWidgets['right']) > 0 ) // 2 columns (right)
		{
			return 'center_right';
		}
		else // 1 column
		{
			return 'center';
		}
	}
} 