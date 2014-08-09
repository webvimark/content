<?php

namespace webvimark\modules\content\models;

use Yii;
use yii\helpers\Inflector;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "page_custom_layout".
 *
 * @property integer $id
 * @property integer $active
 * @property integer $type
 * @property string $name
 * @property string $path
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Page[] $pages
 */
class PageCustomLayout extends \webvimark\components\BaseActiveRecord
{
	// When page should extend this layout and use default left_center, left_center_right, etc
	const TYPE_EXTEND = 0;

	// When page should use only thi layout without default one
	const TYPE_REPLACE = 1;

	/**
	* @inheritdoc
	*/
	public static function tableName()
	{
		return 'page_custom_layout';
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
			[['active', 'type', 'created_at', 'updated_at'], 'integer'],
			[['type', 'name', 'path'], 'required'],
			[['name', 'path'], 'string', 'max' => 255]
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
			'type' => 'Тип',
			'name' => 'Название',
			'path' => 'Путь',
			'created_at' => 'Создано',
			'updated_at' => 'Обновлено',
		];
	}

	/**
	 * getTypeList
	 * @return array
	 */
	public static function getTypeList()
	{
		return array(
			static::TYPE_EXTEND  => 'Наследовать',
			static::TYPE_REPLACE => 'Заменять',
		);
	}

	/**
	 * getTypeValue
	 *
	 * @param string $val
	 *
	 * @return string
	 */
	public static function getTypeValue($val)
	{
		$ar = self::getTypeList();

		return isset( $ar[$val] ) ? $ar[$val] : $val;
	}


	/**
	* @return \yii\db\ActiveQuery
	*/
	public function getPages()
	{
		return $this->hasMany(Page::className(), ['page_custom_layout_id' => 'id']);
	}
}
