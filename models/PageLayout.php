<?php

namespace webvimark\modules\content\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\caching\DbDependency;

/**
 * This is the model class for table "page_layout".
 *
 * @property integer $id
 * @property integer $active
 * @property integer $sorter
 * @property string $name
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $is_main
 * @property integer $is_system
 *
 * @property Page[] $pages
 * @property PageLayoutHasPageWidget[] $pageLayoutHasPageWidgets
 */
class PageLayout extends \webvimark\components\BaseActiveRecord
{
	/**
	 * @return PageLayoutHasPageWidget[]
	 */
	public function getAllPageWidgets()
	{
		return PageLayoutHasPageWidget::find()
			->innerJoinWith(['pageWidget'])
			->where([
				'page_layout_has_page_widget.page_layout_id'=>$this->id,
				'page_widget.active'=>1,
			])
			->orderBy('page_layout_has_page_widget.sorter ASC')
			->all();
	}

	/**
	 * @return array
	 */
	public function getWidgetsGroupedByPosition()
	{
		$cacheKey = '__content_getWidgetsGroupedByPosition_' . $this->id;

		$result = Yii::$app->cache->get($cacheKey);

		if ( $result === false )
		{
			$layoutWidgets = $this->getAllPageWidgets();

			$result = [
				'left'   => [],
				'right'  => [],
				'top'    => [],
				'bottom' => [],
			];

			foreach ($layoutWidgets as $layoutWidget)
			{
				switch ($layoutWidget->position)
				{
					case PageLayoutHasPageWidget::POSITION_LEFT:
						$result['left'][] = $layoutWidget->pageWidget;
						break;

					case PageLayoutHasPageWidget::POSITION_RIGHT:
						$result['right'][] = $layoutWidget->pageWidget;
						break;

					case PageLayoutHasPageWidget::POSITION_TOP:
						$result['top'][] = $layoutWidget->pageWidget;
						break;

					case PageLayoutHasPageWidget::POSITION_BOTTOM:
						$result['bottom'][] = $layoutWidget->pageWidget;
						break;
				}
			}

			$dependency = new DbDependency();
			$dependency->sql = 'SELECT MAX(updated_at) FROM (SELECT updated_at FROM page_widget UNION SELECT updated_at FROM page_layout_has_page_widget) as cache_getWidgetsGroupedByPosition';

			Yii::$app->cache->set($cacheKey, $result, Yii::$app->getModule('content')->cacheTime, $dependency);
		}

		return $result;
	}

	/**
	* @inheritdoc
	*/
	public static function tableName()
	{
		return 'page_layout';
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
			[['active', 'sorter', 'created_at', 'updated_at', 'is_main', 'is_system'], 'integer'],
			[['name'], 'required'],
			[['name'], 'string', 'max' => 255]
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
			'created_at' => 'Создано',
			'updated_at' => 'Обновлено',
			'is_main' => 'Is Main',
			'is_system' => 'Is System',
		];
	}

	/**
	* @return \yii\db\ActiveQuery
	*/
	public function getPages()
	{
		return $this->hasMany(Page::className(), ['page_layout_id' => 'id']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getPageLayoutHasPageWidgets()
	{
		return $this->hasMany(PageLayoutHasPageWidget::className(), ['page_layout_id' => 'id']);
	}

	/**
	 * Don't let delete system and main layouts
	 *
	 * @inheritdoc
	 */
	public function beforeDelete()
	{
		if ( $this->is_main == 1 OR $this->is_system == 1 )
		{
			return false;
		}

		return parent::beforeDelete();
	}
}
