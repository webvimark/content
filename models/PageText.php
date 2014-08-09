<?php

namespace webvimark\modules\content\models;

use Yii;
use yii\helpers\Inflector;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "page_text".
 *
 * @property integer $id
 * @property string $body
 * @property integer $page_id
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Page $page
 */
class PageText extends \webvimark\components\BaseActiveRecord
{
	/**
	* @inheritdoc
	*/
	public static function tableName()
	{
		return 'page_text';
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
			[['body'], 'required'],
			[['body'], 'string'],
			[['page_id', 'created_at', 'updated_at'], 'integer']
		];
	}

	/**
	* @inheritdoc
	*/
	public function attributeLabels()
	{
		return [
			'id' => 'ID',
			'body' => 'Текст',
			'page_id' => 'Page ID',
			'created_at' => 'Создано',
			'updated_at' => 'Обновлено',
		];
	}

	/**
	* @return \yii\db\ActiveQuery
	*/
	public function getPage()
	{
		return $this->hasOne(Page::className(), ['id' => 'page_id']);
	}
}
