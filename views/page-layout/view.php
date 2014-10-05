<?php

use webvimark\modules\content\assets\SortableAsset;
use webvimark\modules\content\models\PageLayoutHasPageWidget;
use webvimark\modules\content\models\PageWidget;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var array $groupedWidgets
 * @var webvimark\modules\content\models\PageLayout $model
 */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Шаблоны страниц', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="page-layout-view">


	<div class="panel panel-default">
		<div class="panel-heading">
			<strong>
				<span class="glyphicon glyphicon-th"></span> <?= Html::encode($this->title) ?>
			</strong>
		</div>
		<div class="panel-body">

			<div class="alert alert-info text-center">
				Если вы оставите, к примеру, правую колонку пустой, то на сайте она исчезнет
			</div>

			<?php $form = ActiveForm::begin([
				'id'      => 'layout-widgets',
//				'options' => ['class' => 'form-horizontal'],
			]) ?>

			<?= Html::hiddenInput('form-submitted', 1) ?>

<!--			// ================= Header =================-->
			<table class="table table-bordered">
				<thead>
					<tr>
						<th>
							<?= $this->render('_availableWidgets', [
								'layoutPosition' => PageLayoutHasPageWidget::POSITION_HEADER,
								'widgetPosition' => PageWidget::POSITION_HEADER_FOOTER,
							]) ?>
						</th>
					</tr>
				</thead>

				<tbody>
				<tr>
					<td>
						<?= $this->render('_savedWidgets', [
							'groupedWidgets' => $groupedWidgets,
							'position'       => PageLayoutHasPageWidget::POSITION_HEADER,
							'widgetIndex'    => 'header',
						]) ?>

					</td>
				</tr>
				</tbody>
			</table>


<!--			// ================= Main container =================-->
			<table class="table table-bordered">
				<thead>
				<tr>
					<th width="20%">
						<?= $this->render('_availableWidgets', [
							'layoutPosition' => PageLayoutHasPageWidget::POSITION_LEFT,
							'widgetPosition' => PageWidget::POSITION_SIDE,
						]) ?>
					</th>
					<th width="60%">
						<?= $this->render('_availableWidgets', [
							'layoutPosition' => PageLayoutHasPageWidget::POSITION_TOP,
							'widgetPosition' => PageWidget::POSITION_CENTER,
						]) ?>
					</th>
					<th width="20%">
						<?= $this->render('_availableWidgets', [
							'layoutPosition' => PageLayoutHasPageWidget::POSITION_RIGHT,
							'widgetPosition' => PageWidget::POSITION_SIDE,
						]) ?>
					</th>
				</tr>
				</thead>

				<tbody>


					<tr>
						<td width="20%">
							<?= $this->render('_savedWidgets', [
								'groupedWidgets' => $groupedWidgets,
								'position'       => PageLayoutHasPageWidget::POSITION_LEFT,
								'widgetIndex'    => 'left',
							]) ?>
						</td>

						<td width="60%">
							<?= $this->render('_savedWidgets', [
								'groupedWidgets' => $groupedWidgets,
								'position'       => PageLayoutHasPageWidget::POSITION_TOP,
								'widgetIndex'    => 'top',
							]) ?>

							<div class="text-center well">
								<h3>
									Здесь находится редактируемый текст
								</h3>
							</div>

							<?= $this->render('_savedWidgets', [
								'groupedWidgets' => $groupedWidgets,
								'position'       => PageLayoutHasPageWidget::POSITION_BOTTOM,
								'widgetIndex'    => 'bottom',
							]) ?>

						</td>

						<td width="20%">
							<?= $this->render('_savedWidgets', [
								'groupedWidgets' => $groupedWidgets,
								'position'       => PageLayoutHasPageWidget::POSITION_RIGHT,
								'widgetIndex'    => 'right',
							]) ?>
						</td>
					</tr>
				</tbody>

				<tfoot>
					<tr>
						<th width="20%">

						</th>
						<th width="60%">

							<div class="form-inline text-center">
								<?= Html::dropDownList(
									'widgets-dropdown-' . PageLayoutHasPageWidget::POSITION_BOTTOM,
									null,
									ArrayHelper::map(PageWidget::findAll([
										'active'   => 1,
										'position' => PageWidget::POSITION_CENTER
									]), 'id', 'name'),
									['class'=>'form-control input-sm', 'prompt'=>'']
								) ?>

								<?= Html::tag('span', '<i class="fa fa-plus"></i>', [
									'class'=>'btn btn-sm btn-default addBtn',
									'data-position'=>PageLayoutHasPageWidget::POSITION_BOTTOM,
								]) ?>
							</div>
						</th>
						<th width="20%">

						</th>
					</tr>

				</tfoot>

			</table>



<!--			// ================= Footer =================-->
			<table class="table table-bordered">
				<thead>
				<tr>
					<th>
						<?= $this->render('_availableWidgets', [
							'layoutPosition' => PageLayoutHasPageWidget::POSITION_FOOTER,
							'widgetPosition' => PageWidget::POSITION_HEADER_FOOTER,
						]) ?>
					</th>
				</tr>
				</thead>

				<tbody>
				<tr>
					<td>
						<?= $this->render('_savedWidgets', [
							'groupedWidgets' => $groupedWidgets,
							'position'       => PageLayoutHasPageWidget::POSITION_FOOTER,
							'widgetIndex'    => 'footer',
						]) ?>
					</td>
				</tr>
				</tbody>
			</table>



			<?= Html::submitButton('<i class="fa fa-check"></i> Сохранить', ['class' => 'btn btn-success btn-lg']) ?>

			<?php ActiveForm::end() ?>

		</div>
	</div>
</div>


<?php
$url = Url::to(['add-widget']);

$js = <<<JS
$('.sortable').sortable();

// Adding widgets
$('.addBtn').on('click', function(){
	var position = $(this).data('position');
	var dropDown = $('[name="widgets-dropdown-' + position + '"]');

	if ( dropDown.val() )
	{
		$.get('$url', { widgetId: dropDown.val(), position: position })
			.done(function(data){
				dropDown.val('');
				$('#widget-container-' + position).append(data);
				$('.sortable').sortable();
			})
	}

});

//Removing widgets
$(document).on('click', '.removeWidget', function(){
	$('#' + $(this).data('unique-id')).remove();
	$('.sortable').sortable();
});

JS;

$css = <<<CSS
li.sortable-placeholder {
	border: 1px dashed #CCC;
	background: none;
	width: 100%;
	height: 75px;
	margin-bottom: 20px;

}
CSS;

$this->registerCss($css);

$this->registerJs($js);

SortableAsset::register($this);
?>