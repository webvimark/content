<?php
/**
 * @var $this yii\web\View
 */
use webvimark\modules\content\models\Page;
use yii\bootstrap\Nav;
?>

<div class="side-menu-widget">
	<?= Nav::widget([
		'items'=>Page::getItemsForMenu($this->context->place),
		'activateParents'=>true,
	]) ?>
</div>