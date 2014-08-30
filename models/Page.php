<?php

namespace webvimark\modules\content\models;

use webvimark\helpers\LittleBigHelper;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\helpers\Url;

/**
 * This is the model class for table "page".
 *
 * @property integer $id
 * @property integer $active
 * @property integer $sorter
 * @property string $name
 * @property string $url
 * @property string $link_url
 * @property string $body
 * @property integer $type
 * @property integer $is_main
 * @property integer $parent_id
 * @property integer $page_place_id
 * @property integer $page_custom_layout_id
 * @property integer $page_layout_id
 * @property string $meta_title
 * @property string $meta_keywords
 * @property string $meta_description
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Page $parent
 * @property Page[] $children
 * @property PagePlace $pagePlace
 * @property PageLayout $pageLayout
 * @property PageCustomLayout $pageCustomLayout
 * @property PageText[] $pageTexts
 */
class Page extends \webvimark\components\BaseActiveRecord
{
	const TYPE_TEXT = 0;
	const TYPE_LINK = 1;

	/**
	 * @param string $place
	 *
	 * @return array
	 */
	public static function getItemsForMenu($place)
	{
		$pages = Page::find()
			->innerJoinWith(['pagePlace'])
			->select(['page.name', 'page.id', 'page.parent_id', 'page.is_main', 'page.page_place_id', 'page.type', 'page.url', 'page.link_url'])
			->where([
				'page.active'=>1,
				'page_place.active'=>1,
				'page_place.code'=>$place,
			])
			->orderBy('page.sorter')
			->all();

		return self::getChildrenForMenu($pages, null);
	}

	/**
	 * Helper for "getItemsForMenu"
	 *
	 * @param array    $pages
	 * @param int|null $id
	 *
	 * @return array
	 */
	protected static function getChildrenForMenu($pages, $id)
	{
		$output = [];

		foreach ($pages as $page)
		{
			if ( $page['parent_id'] == $id )
			{
				$output[$page['id']]['label'] = $page['name'];

				if ( $page['is_main'] == 1 )
				{
					$output[$page['id']]['url'] = '/';
				}
				else
				{
					$output[$page['id']]['url'] = ($page['type'] == Page::TYPE_TEXT) ? ['/content/view/page', 'url'=>$page['url']] : $page['link_url'];
				}

				$items = self::getChildrenForMenu($pages, $page['id']);

				if ( $items )
				{
					$output[$page['id']]['items'] = $items;
				}
			}
		}

		return $output;
	}

	/**
	 * Array for "link_url" dropDown in _form
	 *
	 * @return array
	 */
	public static function getLinkUrlList()
	{
		$output = [];

		$systemPages = PageSystemPlace::find()
			->where(['active'=>1])
			->orderBy('sorter ASC')
			->asArray()
			->all();

		foreach ($systemPages as $systemPage)
		{
			$output['Системные страницы'][Url::to($systemPage['path'])] = $systemPage['name'];
		}
		$output[] = '';

		$textPages = Page::find()
			->select(['url', 'name'])
			->where(['type'=>Page::TYPE_TEXT])
			->asArray()
			->all();

		foreach ($textPages as $textPage)
		{
			$output['Существующие текстовые страницы'][Url::to(['/content/view/page', 'url'=>$textPage['url']])] = $textPage['name'];
		}
		$output[] = '';

		return $output;
	}

	/**
	* @inheritdoc
	*/
	public static function tableName()
	{
		return 'page';
	}

	/**
	* @inheritdoc
	*/
	public function behaviors()
	{
		return [
			TimestampBehavior::className(),
		];
	}

	/**
	* @inheritdoc
	*/
	public function rules()
	{
		return [
			[['active', 'sorter', 'parent_id', 'is_main', 'page_place_id', 'page_layout_id', 'page_custom_layout_id', 'created_at', 'updated_at'], 'integer'],
			[['name'], 'required'],

			['page_layout_id', 'required', 'on'=>self::TYPE_TEXT . '_scenario'],
			[['url'], 'unique', 'on'=>self::TYPE_TEXT . '_scenario'],

			[['link_url'], 'required', 'on'=>self::TYPE_LINK . '_scenario'],

			[['body'], 'safe'],
			[['name', 'url', 'meta_title', 'meta_keywords', 'meta_description'], 'string', 'max' => 255]
		];
	}

	/**
	* @inheritdoc
	*/
	public function attributeLabels()
	{
		return [
			'id' => 'ID',
			'active' => 'Активно',
			'sorter' => 'Порядок',
			'name' => 'Название',
			'url' => 'Ссылка',
			'body' => 'Текст',
			'type' => 'Тип',
			'is_main' => 'Сделать главной',
			'link_url' => 'Ссылка на страницу',
			'parent_id' => 'Parent ID',
			'page_place_id' => 'Расположение',
			'page_custom_layout_id' => 'Оформление',
			'page_layout_id' => 'Шаблон',
			'meta_title' => 'Meta Title',
			'meta_keywords' => 'Meta Keywords',
			'meta_description' => 'Meta Description',
			'created_at' => 'Создано',
			'updated_at' => 'Обновлено',
		];
	}

	/**
	* @return \yii\db\ActiveQuery
	*/
	public function getParent()
	{
		return $this->hasOne(Page::className(), ['id' => 'parent_id']);
	}

	/**
	* @return \yii\db\ActiveQuery
	*/
	public function getChildren()
	{
		return $this->hasMany(Page::className(), ['parent_id' => 'id']);
	}

	/**
	* @return \yii\db\ActiveQuery
	*/
	public function getPagePlace()
	{
		return $this->hasOne(PagePlace::className(), ['id' => 'page_place_id']);
	}

	/**
	* @return \yii\db\ActiveQuery
	*/
	public function getPageLayout()
	{
		return $this->hasOne(PageLayout::className(), ['id' => 'page_layout_id']);
	}

	/**
	* @return \yii\db\ActiveQuery
	*/
	public function getPageCustomLayout()
	{
		return $this->hasOne(PageCustomLayout::className(), ['id' => 'page_custom_layout_id']);
	}

	/**
	* @return \yii\db\ActiveQuery
	*/
	public function getPageTexts()
	{
		return $this->hasMany(PageText::className(), ['page_id' => 'id']);
	}

	/**
	* Generate url from the name
	*
	* @return bool
	*/
	public function beforeValidate()
	{
		$this->url = LittleBigHelper::slug($this->url ? $this->url : $this->name);

		return parent::beforeValidate();
	}

	/**
	 * If page is set to be main, than remove this status from current main page
	 *
	 * @param bool $insert
	 *
	 * @return bool|void
	 */
	public function beforeSave($insert)
	{
		if ( parent::beforeSave($insert) )
		{
			if ( $this->is_main == 1 )
			{
				if ( $insert OR $this->oldAttributes['is_main'] == 0 )
				{
					// findAll() - just in case
					$mainPages = Page::findAll(['is_main'=>1]);

					foreach ($mainPages as $mainPage)
					{
						$mainPage->is_main = 0;
						$mainPage->save(false);
					}
				}
			}

			return true;
		}

		return false;
	}

	/**
	 * If place has been changed - change it for children (it will be changed recursive)
	 *
	 * @param bool  $insert
	 * @param array $changedAttributes
	 */
	public function afterSave($insert, $changedAttributes)
	{
		if ( !$insert AND array_key_exists('page_place_id', $changedAttributes) )
		{
			foreach ($this->children as $child)
			{
				$child->page_place_id = $this->page_place_id;
				$child->save(false);
			}
		}

		parent::afterSave($insert, $changedAttributes);
	}

	/**
	 * Don't let delete main page
	 *
	 * @return bool
	 */
	public function beforeDelete()
	{
		if ( $this->is_main == 1 )
		{
			return false;
		}

		return parent::beforeDelete();
	}
}
