<?php

namespace webvimark\modules\content\models;

use Yii;
use yii\helpers\Inflector;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "page_system_place".
 *
 * @property integer $id
 * @property integer $active
 * @property integer $sorter
 * @property string $name
 * @property string $path
 * @property integer $created_at
 * @property integer $updated_at
 */
class PageSystemPlace extends \webvimark\components\BaseActiveRecord
{
	/**
	* @inheritdoc
	*/
	public static function tableName()
	{
		return 'page_system_place';
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
			[['active', 'sorter', 'created_at', 'updated_at'], 'integer'],
			[['name', 'path'], 'required'],
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
			'sorter' => 'Порядок',
			'name' => 'Название',
			'path' => 'Путь',
			'created_at' => 'Создано',
			'updated_at' => 'Обновлено',
		];
	}
}
