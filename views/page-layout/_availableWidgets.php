<?php
/**
 * @var $this yii\web\View
 * @var $layoutPosition int
 * @var $widgetPosition int
 */
use webvimark\modules\content\models\PageWidget;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

?>
<div class="form-inline text-center">
	<?= Html::dropDownList(
		'widgets-dropdown-' . $layoutPosition,
		null,
		ArrayHelper::map(PageWidget::findAll([
			'active'   => 1,
			'position' => $widgetPosition
		]), 'id', 'name'),
		['class'=>'form-control input-sm', 'prompt'=>'']
	) ?>

	<?= Html::tag('span', '<i class="fa fa-plus"></i>', [
		'class'=>'btn btn-sm btn-default addBtn',
		'data-position'=>$layoutPosition,
	]) ?>
</div>