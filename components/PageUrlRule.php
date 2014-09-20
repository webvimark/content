<?php
namespace webvimark\modules\content\components;

use webvimark\modules\content\models\Page;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use yii\web\Request;
use yii\web\UrlManager;
use yii\web\UrlRule;
use Yii;

class PageUrlRule extends UrlRule
{
	public $connectionID = 'db';

	protected $_recursiveParentUrl;

	protected $_paramsInitialized = false;
	protected $_pagesById;
	protected $_pagesByUrl;

	/**
	 * Initialize params once per run
	 */
	protected function initializeParams()
	{
		$pages = (new Query())
			->select(['id', 'url', 'parent_id'])
			->from('page')
			->where(['page.active'=>1])
			->all();

		$this->_paramsInitialized = true;

		$this->_pagesById = ArrayHelper::map($pages, 'url', 'parent_id', 'id');
		$this->_pagesByUrl = ArrayHelper::map($pages, 'id', 'parent_id', 'url');
	}

	/**
	 * Creates a URL according to the given route and parameters.
	 * @param UrlManager $manager the URL manager
	 * @param string $route the route. It should not have slashes at the beginning or the end.
	 * @param array $params the parameters
	 * @return string|boolean the created URL, or false if this rule cannot be used for creating this URL.
	 */
	public function createUrl($manager, $route, $params)
	{
		if ( $route === 'content/view/page' AND isset( $params['url'] ) )
		{
			if ( !$this->_paramsInitialized )
				$this->initializeParams();

			if ( isset( $params['_language'] ) )
			{
				return $params['_language'] . '/' . $this->getPageRecursiveUrl($params['url']);
			}
			else
			{
				return $this->getPageRecursiveUrl($params['url']);
			}
		}

		return false;  // this rule does not apply
	}

	/**
	 * Find page and all it parents to create nice url like: "/first-parent/second-parent/this-page-url"
	 *
	 * @param string $url
	 *
	 * @return string
	 */
	protected function getPageRecursiveUrl($url)
	{
		if ( isset($this->_pagesByUrl[$url]) )
		{
			$tmpByUrl = $this->_pagesByUrl[$url];
			$parentId = array_pop($tmpByUrl);

			if ( $parentId AND isset($this->_pagesById[$parentId]) )
			{
				$tmpById = array_keys($this->_pagesById[$parentId]);
				$parentUrl = array_pop($tmpById);

				$url = $this->getPageRecursiveUrl($parentUrl) . '/' . $url;
			}
		}

		return $url;
	}


	/**
	 * Parses the given request and returns the corresponding route and parameters.
	 * @param UrlManager $manager the URL manager
	 * @param Request $request the request component
	 * @return array|boolean the parsing result. The route and the parameters are returned as an array.
	 * If false, it means this rule cannot be used to parse this path info.
	 */
	public function parseRequest($manager, $request)
	{
		// If it's base url - call main page
		if ( $request->getPathInfo() === '' )
		{
			$mainPage = $this->getMainPage();

			if ( $mainPage !== false )
			{
				if ( $mainPage['type'] == Page::TYPE_TEXT )
				{
					return ['/content/view/page', ['url'=>$mainPage['url']]];
				}
				elseif ( $mainPage['type'] == Page::TYPE_LINK )
				{
					return [
						'/' . ltrim($mainPage['link_url'], '/'),
						[]
					];

				}
			}
		}

		$path = rtrim($request->getPathInfo(), '/');

		$parts = explode('/', $path);

		$languagePart = null;

		// Multilingual support - remove language from parts
		if ( isset( Yii::$app->params['mlConfig']['languages'] ) )
		{
			if ( array_key_exists($parts[0], Yii::$app->params['mlConfig']['languages'] ) )
			{
				$languagePart = array_shift($parts);
			}
		}

		if ( count($parts) == 1 AND $parts[0] != '' )
		{
			$url = $this->getPageUrl($parts[0]);

			if ( $url !== false )
			{
				return ['content/view/page', ['url'=>$url, '_language'=>$languagePart]];
			}
		}
		elseif ( count($parts) > 1 )
		{
			if ( !$this->_paramsInitialized )
				$this->initializeParams();

			$url = end($parts);
			$pageRoute = $this->getPageRecursiveUrl($url);

			if ( $languagePart )
			{
				$pageRoute = $languagePart . '/' . $pageRoute;
			}

			if ( $path == $pageRoute )
				return ['content/view/page', ['url'=>$url, '_language'=>$languagePart]];
		}

		return false;  // this rule does not apply
	}

	/**
	 * @param string $url
	 *
	 * @return bool|string
	 */
	protected function getPageUrl($url)
	{
		return (new Query())
			->select('url')
			->from('page')
			->where([
				'page.active'=>1,
				'page.url'=>$url,
			])
			->scalar();
	}

	/**
	 * @return bool|string
	 */
	protected function getMainPage()
	{
		return (new Query())
			->select(['url', 'link_url', 'type'])
			->from('page')
			->where([
				'page.is_main'=>1,
			])
			->one();
	}
}