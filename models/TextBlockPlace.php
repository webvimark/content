<?php

namespace app\modules\content\models;

use Yii;
use yii\helpers\Inflector;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "text_block_place".
 *
 * @property integer $id
 * @property integer $active
 * @property integer $one_record
 * @property string $name
 * @property string $code
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property TextBlock[] $textBlocks
 */
class TextBlockPlace extends \yii\db\ActiveRecord
{
	/**
	* @inheritdoc
	*/
	public static function tableName()
	{
		return 'text_block_place';
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
			[['active', 'one_record', 'created_at', 'updated_at'], 'integer'],
			[['name', 'code'], 'required'],
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
			'one_record' => 'One Record',
			'name' => 'Название',
			'code' => 'Код',
			'created_at' => 'Создано',
			'updated_at' => 'Обновлено',
		];
	}

	/**
	* @return \yii\db\ActiveQuery
	*/
	public function getTextBlocks()
	{
		return $this->hasMany(TextBlock::className(), ['text_block_place_id' => 'id']);
	}
}
