<?php

use webvimark\modules\content\models\PageWidget;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use webvimark\extensions\BootstrapSwitch\BootstrapSwitch;

/**
 * @var yii\web\View $this
 * @var webvimark\modules\content\models\PageWidget $model
 * @var yii\bootstrap\ActiveForm $form
 */
?>
<div class="page-widget-form">

	<?php $form = ActiveForm::begin([
		'id'=>'page-widget-form',
		'layout'=>'horizontal',
		]); ?>

	<?= $form->field($model->loadDefaultValues(), 'active')->checkbox(['class'=>'b-switch'], false) ?>

	<?= $form->field($model, 'name')->textInput(['maxlength' => 255, 'autofocus'=>$model->isNewRecord ? true:false]) ?>

	<?= $form->field($model, 'position')->dropDownList(PageWidget::getPositionList(), ['prompt'=>'']) ?>

	<?= $form->field($model->loadDefaultValues(), 'has_settings')->checkbox(['class'=>'b-switch'], false) ?>

	<?= $form->field($model, 'settings_url')->textInput(['maxlength' => 255]) ?>

	<?= $form->field($model, 'description')->textarea(['rows'=>4]) ?>

	<?= $form->field($model, 'class')->textInput(['maxlength' => 255]) ?>

	<?= $form->field($model, 'options')->textInput(['maxlength' => 255]) ?>

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