<?php

namespace app\modules\content\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "text_block".
 *
 * @property integer $id
 * @property integer $active
 * @property integer $text_block_place_id
 * @property integer $sorter
 * @property string $name
 * @property string $body
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property TextBlockPlace $textBlockPlace
 */
class TextBlock extends \yii\db\ActiveRecord
{

	/**
	 * @param string $placeCode
	 *
	 * @return static[]
	 */
	public static function getAllByCode($placeCode)
	{
		return static::find()
			->joinWith('textBlockPlace')
			->where([
				'text_block.active' => 1,
				'text_block_place.code'=>$placeCode,
			])
			->orderBy('sorter DESC')
			->all();
	}

	/**
	 * @param string $placeCode
	 *
	 * @return static
	 */
	public static function getOneByCode($placeCode)
	{
		return static::find()
			->joinWith('textBlockPlace')
			->where([
				'text_block.active' => 1,
				'text_block_place.code'=>$placeCode,
			])
			->orderBy('sorter DESC')
			->one();
	}


	/**
	* @inheritdoc
	*/
	public static function tableName()
	{
		return 'text_block';
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
			[['active', 'text_block_place_id', 'sorter', 'created_at', 'updated_at'], 'integer'],
			[['text_block_place_id', 'name', 'body'], 'required'],
			['text_block_place_id', 'isPlaceCanHaveMoreRecords'],
			[['body'], 'string'],
			[['name'], 'string', 'max' => 255]
		];
	}

	/**
	 * Rule
	 *
	 * @return bool
	 */
	public function isPlaceCanHaveMoreRecords()
	{
		if ( $this->textBlockPlace->one_record == 1 AND ( count($this->textBlockPlace->textBlocks) > 0 ) )
		{
			if ( $this->isNewRecord )
			{
				$this->addError('text_block_place_id', 'У Вас уже есть текст для этого места');
				return false;
			}
			else
			{
				foreach ($this->textBlockPlace->textBlocks as $textBlock)
				{
					if ( $this->id == $textBlock->id )
						return true;
				}

				$this->addError('text_block_place_id', 'У Вас уже есть текст для этого места');
				return false;
			}
		}

		return true;
	}

	/**
	* @inheritdoc
	*/
	public function attributeLabels()
	{
		return [
			'id' => 'ID',
			'active' => 'Активно',
			'text_block_place_id' => 'Место расположения',
			'sorter' => 'Порядок',
			'name' => 'Название',
			'body' => 'Текст',
			'created_at' => 'Создано',
			'updated_at' => 'Обновлено',
		];
	}

	/**
	* @return \yii\db\ActiveQuery
	*/
	public function getTextBlockPlace()
	{
		return $this->hasOne(TextBlockPlace::className(), ['id' => 'text_block_place_id'])
			->where(['text_block_place.active'=>1]);
	}
}
