<?php

namespace webvimark\modules\content\models;

use Yii;
use yii\helpers\Inflector;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "page_widget".
 *
 * @property integer $id
 * @property integer $active
 * @property integer $sorter
 * @property integer $position
 * @property string $name
 * @property string $description
 * @property string $class
 * @property string $options
 * @property integer $is_internal
 * @property integer $has_settings
 * @property string $settings_url
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property PageLayoutHasPageWidget[] $pageLayoutHasPageWidgets
 */
class PageWidget extends \webvimark\components\BaseActiveRecord
{
	const POSITION_CENTER = 0;
	const POSITION_SIDE = 1;


	/**
	* @inheritdoc
	*/
	public static function tableName()
	{
		return 'page_widget';
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
			[['active', 'sorter', 'position', 'has_settings', 'created_at', 'updated_at'], 'integer'],
			[['position', 'name', 'class'], 'required'],
			[['name', 'description', 'class', 'options', 'settings_url'], 'string', 'max' => 255]
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
			'position' => 'Позиция',
			'name' => 'Название',
			'description' => 'Описание',
			'class' => 'Класс',
			'options' => 'Опции',
			'has_settings' => 'Has Settings',
			'is_internal' => 'Is Internal',
			'settings_url' => 'Settings Url',
			'created_at' => 'Создано',
			'updated_at' => 'Обновлено',
		];
	}

	/**
	* @return \yii\db\ActiveQuery
	*/
	public function getPageLayoutHasPageWidgets()
	{
		return $this->hasMany(PageLayoutHasPageWidget::className(), ['page_widget_id' => 'id']);
	}

	/**
	 * getPositionList
	 * @return array
	 */
	public static function getPositionList()
	{
		return array(
			self::POSITION_CENTER => 'Center',
			self::POSITION_SIDE   => 'Side',
		);
	}

	/**
	 * getPositionValue
	 *
	 * @param string $val
	 *
	 * @return string
	 */
	public static function getPositionValue($val)
	{
		$ar = self::getPositionList();

		return isset( $ar[$val] ) ? $ar[$val] : $val;
	}

}
