<?php
/**
 * @var $this           yii\web\View
 * @var $groupedWidgets array
 * @var $position       int
 * @var $widgetIndex    string
 */
?>
<ul class="sortable list-unstyled" id="widget-container-<?= $position ?>">

	<?php foreach ($groupedWidgets[$widgetIndex] as $widget): ?>
		<?= $this->render('addWidget', [
			'widget'   => $widget,
			'position' => $position,
		]) ?>
	<?php endforeach ?>

</ul>