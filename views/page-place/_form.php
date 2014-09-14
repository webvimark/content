<?php

use webvimark\modules\content\models\PagePlace;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use webvimark\extensions\BootstrapSwitch\BootstrapSwitch;

/**
 * @var yii\web\View $this
 * @var webvimark\modules\content\models\PagePlace $model
 * @var yii\bootstrap\ActiveForm $form
 */
?>
<div class="page-place-form">

	<?php $form = ActiveForm::begin([
		'id'=>'page-place-form',
		'layout'=>'horizontal',
		]); ?>

	<?= $form->field($model->loadDefaultValues(), 'active')->checkbox(['class'=>'b-switch'], false) ?>

	<?= $form->field($model->loadDefaultValues(), 'with_children')->checkbox(['class'=>'b-switch'], false) ?>

	<?= $form->field($model, 'type')->dropDownList([
		PagePlace::TYPE_BASE_MENU=>'Основное меню',
		PagePlace::TYPE_SIDE_MENU=>'Боковое меню',
	], ['prompt'=>'']) ?>

	<?= $form->field($model, 'name')->textInput(['maxlength' => 255, 'autofocus'=>$model->isNewRecord ? true:false]) ?>

	<?= $form->field($model, 'code')->textInput(['maxlength' => 255]) ?>

	<?= $form->field($model->loadDefaultValues(), 'with_image')->checkbox(['class'=>'b-switch'], false) ?>

	<div id="image-params" class="<?= ($model->with_image == 1) ? '' : 'hide' ?>">

		<?= $form->field($model->loadDefaultValues(), 'image_before_label')->checkbox(['class'=>'b-switch'], false) ?>
	</div>


	<div class="form-group">
		<div class="col-sm-offset-3 col-sm-9">
			<?php if ( $model->isNewRecord ): ?>
				<?= Html::submitButton(
					'<span class="glyphicon glyphicon-plus-sign"></span> Создать',
					['class' => 'btn btn-success']
				) ?>
			<?php else: ?>
				<?= Html::submitButton(
					'<span class="glyphicon glyphicon-ok"></span> Сохранить',
					['class' => 'btn btn-primary']
				) ?>
			<?php endif; ?>
		</div>
	</div>

	<?php ActiveForm::end(); ?>

</div>

<?php BootstrapSwitch::widget() ?>

<?php
$js = <<<JS
// Hide or show image params depends on toggler
$('.bootstrap-switch-id-pageplace-with_image').on('click', function(){
	var imageParams = $('#image-params');

	if ( $('#pageplace-with_image').is(':checked') )
	{
		imageParams.removeClass('hide');
	}
	else
	{
		imageParams.addClass('hide');
	}
});
JS;

$this->registerJs($js);
?>