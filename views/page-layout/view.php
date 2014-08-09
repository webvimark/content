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
				Если вы оставите, к примеру, левую колонку пустой, то на сайте она исчезнет
			</div>

			<?php $form = ActiveForm::begin([
				'id'      => 'layout-widgets',
//				'options' => ['class' => 'form-horizontal'],
			]) ?>

			<?= Html::hiddenInput('form-submitted', 1) ?>

			<table class="table table-bordered">
				<thead>
					<tr>
						<th class="text-center">Левая колонка</th>
						<th class="text-center">Центральная колонка</th>
						<th class="text-center">Правая колонка</th>
					</tr>
				</thead>

				<tbody>
					<tr>
						<th width="20%">

							<div class="form-inline text-center">
								<?= Html::dropDownList(
									'widgets-dropdown-' . PageLayoutHasPageWidget::POSITION_LEFT,
									null,
									ArrayHelper::map(PageWidget::findAll([
										'active'   => 1,
										'position' => PageWidget::POSITION_SIDE
									]), 'id', 'name'),
									['class'=>'form-control input-sm', 'prompt'=>'']
								) ?>

								<?= Html::tag('span', '<i class="fa fa-plus"></i>', [
									'class'=>'btn btn-sm btn-default addBtn',
									'data-position'=>PageLayoutHasPageWidget::POSITION_LEFT,
								]) ?>
							</div>

						</th>
						<th width="60%">

							<div class="form-inline text-center">
								<?= Html::dropDownList(
									'widgets-dropdown-' . PageLayoutHasPageWidget::POSITION_TOP,
									null,
									ArrayHelper::map(PageWidget::findAll([
										'active'   => 1,
										'position' => PageWidget::POSITION_CENTER
									]), 'id', 'name'),
									['class'=>'form-control input-sm', 'prompt'=>'']
								) ?>

								<?= Html::tag('span', '<i class="fa fa-plus"></i>', [
									'class'=>'btn btn-sm btn-default addBtn',
									'data-position'=>PageLayoutHasPageWidget::POSITION_TOP,
								]) ?>
							</div>
						</th>
						<th width="20%">

							<div class="form-inline text-center">
								<?= Html::dropDownList(
									'widgets-dropdown-' . PageLayoutHasPageWidget::POSITION_RIGHT,
									null,
									ArrayHelper::map(PageWidget::findAll([
										'active'   => 1,
										'position' => PageWidget::POSITION_SIDE
									]), 'id', 'name'),
									['class'=>'form-control input-sm', 'prompt'=>'']
								) ?>

								<?= Html::tag('span', '<i class="fa fa-plus"></i>', [
									'class'=>'btn btn-sm btn-default addBtn',
									'data-position'=>PageLayoutHasPageWidget::POSITION_RIGHT,
								]) ?>
							</div>
						</th>
					</tr>

					<tr>
						<td width="20%">
							<ul class="sortable list-unstyled" id="widget-container-<?= PageLayoutHasPageWidget::POSITION_LEFT ?>">

								<?php foreach ($groupedWidgets['left'] as $leftWidget): ?>
									<?= $this->render('addWidget', [
										'widget'=>$leftWidget,
										'position'=>PageLayoutHasPageWidget::POSITION_LEFT,
									]) ?>
								<?php endforeach ?>

							</ul>
						</td>

						<td width="60%">
							<ul class="sortable list-unstyled" id="widget-container-<?= PageLayoutHasPageWidget::POSITION_TOP ?>">

								<?php foreach ($groupedWidgets['top'] as $topWidget): ?>
									<?= $this->render('addWidget', [
										'widget'=>$topWidget,
										'position'=>PageLayoutHasPageWidget::POSITION_TOP,
									]) ?>
								<?php endforeach ?>

							</ul>

							<div class="text-center well">
								<h3>
									Здесь находится редактируемый текст
								</h3>
							</div>

							<ul class="sortable list-unstyled" id="widget-container-<?= PageLayoutHasPageWidget::POSITION_BOTTOM ?>">

								<?php foreach ($groupedWidgets['bottom'] as $bottomWidget): ?>
									<?= $this->render('addWidget', [
										'widget'=>$bottomWidget,
										'position'=>PageLayoutHasPageWidget::POSITION_BOTTOM,
									]) ?>
								<?php endforeach ?>

							</ul>
						</td>

						<td width="20%">
							<ul class="sortable list-unstyled" id="widget-container-<?= PageLayoutHasPageWidget::POSITION_RIGHT ?>">

								<?php foreach ($groupedWidgets['right'] as $rightWidget): ?>
									<?= $this->render('addWidget', [
										'widget'=>$rightWidget,
										'position'=>PageLayoutHasPageWidget::POSITION_RIGHT,
									]) ?>
								<?php endforeach ?>

							</ul>
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