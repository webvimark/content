<?php
/**
 * @var $this yii\web\View
 */
use webvimark\modules\content\models\Page;
use yii\widgets\Menu;

?>

<div class="side-menu-widget">
	<?= Menu::widget([
		'items'=>Page::getItemsForMenu($this->context->place),
		'activateParents'=>true,
		'encodeLabels'=>false,
		'options'=>[
			'class'=>'nested-menu',
		],
	]) ?>
</div>