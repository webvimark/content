<?php

namespace webvimark\modules\content\models;

use Yii;
use yii\helpers\Inflector;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "page_layout_has_page_widget".
 *
 * @property integer $id
 * @property integer $page_layout_id
 * @property integer $page_widget_id
 * @property integer $sorter
 * @property integer $position
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property PageLayout $pageLayout
 * @property PageWidget $pageWidget
 */
class PageLayoutHasPageWidget extends \webvimark\components\BaseActiveRecord
{
	const POSITION_TOP = 0;
	const POSITION_RIGHT = 1;
	const POSITION_BOTTOM = 2;
	const POSITION_LEFT = 3;
	const POSITION_HEADER = 4;
	const POSITION_FOOTER = 5;


	/**
	 * Used in layouts left_center, left_center_right, etc
	 *
	 * @param $layoutWidgets array
	 * @param $position string
	 */
	public static function renderWidgets($layoutWidgets, $position)
	{
		foreach ($layoutWidgets[$position] as $widget)
		{
			$widgetClass = $widget->class;

			echo "<div class='layout-widget layout-widget-{$position}'>";
				echo $widgetClass::widget(unserialize($widget->options));
			echo "</div>";
		}
	}

	/**
	* @inheritdoc
	*/
	public static function tableName()
	{
		return 'page_layout_has_page_widget';
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
			[['page_layout_id', 'page_widget_id', 'sorter', 'position', 'created_at', 'updated_at'], 'integer'],
			[['position'], 'required']
		];
	}

	/**
	* @inheritdoc
	*/
	public function attributeLabels()
	{
		return [
			'id' => 'ID',
			'page_layout_id' => 'Page Layout ID',
			'page_widget_id' => 'Page Widget',
			'sorter' => 'Порядок',
			'position' => 'Position',
			'created_at' => 'Создано',
			'updated_at' => 'Обновлено',
		];
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
	public function getPageWidget()
	{
		return $this->hasOne(PageWidget::className(), ['id' => 'page_widget_id']);
	}
}
