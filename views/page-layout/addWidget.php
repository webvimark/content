<?php
/**
 * @var $this yii\web\View
 * @var $position int
 * @var $widget webvimark\modules\content\models\PageWidget
 */

use yii\helpers\Html;

$uniqueId = uniqid();
?>

<li id="<?= $uniqueId ?>">
	<div class="panel panel-warning">
		<div class="panel-heading">
			<strong>

				<?php if ( $widget->has_settings == 1 ): ?>
					<?= Html::a("<i class='fa fa-cogs'></i>", $widget->settings_url, ['target'=>'_blank', 'class'=>'tn']) ?>

				<?php else: ?>
					<i class='fa fa-th'></i>

				<?php endif; ?>

				<span class="asd">
				<?= $widget->name ?>

				</span>

				<span style='cursor:pointer' class="pull-right removeWidget" data-unique-id="<?= $uniqueId ?>">
					<i class="fa fa-trash-o alert-danger"></i>
				</span>
			</strong>
		</div>
		<div class="panel-body">

			<?= Html::hiddenInput("sorted-widgets[{$position}][]", $widget->id) ?>

		</div>
	</div>
</li>
