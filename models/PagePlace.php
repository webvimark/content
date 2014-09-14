<?php

namespace webvimark\modules\content\models;

use Yii;
use yii\helpers\Inflector;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "page_place".
 *
 * @property integer $id
 * @property integer $active
 * @property integer $with_children
 * @property integer $with_image
 * @property integer $image_before_label
 * @property integer $sorter
 * @property integer $type
 * @property string $name
 * @property string $code
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Page[] $pages
 */
class PagePlace extends \webvimark\components\BaseActiveRecord
{
	const NO_PLACE_NAME = 'Страницы вне меню';

	const TYPE_BASE_MENU = 0;
	const TYPE_SIDE_MENU = 1;

	/**
	* @inheritdoc
	*/
	public static function tableName()
	{
		return 'page_place';
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
			[['active', 'sorter', 'with_children', 'image_before_label', 'with_image', 'created_at', 'updated_at'], 'integer'],
			[['name', 'code', 'type'], 'required'],
			[['name', 'code'], 'string', 'max' => 255],
			[['code'], 'unique']
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
			'with_children' => 'С подменю',
			'with_image' => 'С картинкой',
			'sorter' => 'Порядок',
			'name' => 'Название',
			'code' => 'Код',
			'type' => 'Тип',
			'created_at' => 'Создано',
			'updated_at' => 'Обновлено',
		];
	}

	/**
	* @return \yii\db\ActiveQuery
	*/
	public function getPages()
	{
		return $this->hasMany(Page::className(), ['page_place_id' => 'id']);
	}
}
