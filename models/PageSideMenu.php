<?php

namespace webvimark\modules\content\models;


use yii\helpers\Url;

class PageSideMenu extends PagePlace
{
	const WIDGET_CLASS = 'webvimark\modules\content\widgets\side_menu\SideMenuWidget';

	/**
	 * @return array
	 */
	public static function getItemsForMenu()
	{
		$sideMenus = static::find()->asArray()->all();
		$output = [];

		foreach ($sideMenus as $sideMenu)
		{
			$output[] = [
				'label'=>'<i class="fa fa-file"></i> ' . $sideMenu['name'],
				'url'=>['/content/page/tree', 'place'=>$sideMenu['code']],
			];
		}
		$output[] = '<li class="divider"></li>';
		$output[] = ['label' => '<i class="fa fa-table"></i> Список', 'url' => ['/content/side-menu/index']];

		return $output;
	}

	/**
	 * @inheritdoc
	 */
	public static function find()
	{
		return parent::find()->andWhere(['page_place.type'=>PagePlace::TYPE_SIDE_MENU]);
	}

	/**
	 * Generate random code for sideMenu
	 *
	 * @inheritdoc
	 */
	public function beforeValidate()
	{
		$this->type = static::TYPE_SIDE_MENU;

		if ( ! $this->code )
			$this->code = uniqid();

		return parent::beforeValidate();
	}

	/**
	 * Set type = SideMenu
	 *
	 * @inheritdoc
	 */
	public function beforeSave($insert)
	{
		$this->type = PagePlace::TYPE_SIDE_MENU;

		return parent::beforeSave($insert);
	}


	/**
	 * @inheritdoc
	 */
	public function afterDelete()
	{
		PageWidget::deleteIfExists([
			'class'   => self::WIDGET_CLASS,
			'options' => serialize(['place' => $this->code]),
		]);

		parent::afterDelete();
	}

	/**
	 * Create page_widget or update it's name
	 *
	 * @inheritdoc
	 */
	public function afterSave($insert, $changedAttributes)
	{
		if ( $insert )
		{
			$widget = new PageWidget();

			$widget->name         = $this->name;
			$widget->position     = PageWidget::POSITION_SIDE;
			$widget->description  = 'Боковое меню';
			$widget->is_internal  = 1;
			$widget->class        = self::WIDGET_CLASS;
			$widget->options      = serialize(['place' => $this->code]);
			$widget->has_settings = 1;
			$widget->settings_url = Url::to(['/content/page/tree', 'place'=>$this->code]);

			$widget->save(false);
		}
		elseif ( array_key_exists('name', $changedAttributes) )
		{
			$widget = PageWidget::findOne([
				'class'   => self::WIDGET_CLASS,
				'options' => serialize(['place' => $this->code]),
			]);

			if ( $widget )
			{
				$widget->name = $this->name;
				$widget->save(false);
			}
		}

		parent::afterSave($insert, $changedAttributes);
	}
}