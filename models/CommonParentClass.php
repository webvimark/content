<?php


namespace webvimark\modules\content\models;


use webvimark\components\BaseActiveRecord;
use Yii;

/**
 * Used as parent class for all content module models
 *
 * Class CommonParentClass
 * @package webvimark\modules\content\models
 */
class CommonParentClass extends BaseActiveRecord
{
	/**
	 * Flush cache
	 *
	 * @inheritdoc
	 */
	public function afterDelete()
	{
		Yii::$app->cache->flush();

		parent::afterDelete();
	}
} 