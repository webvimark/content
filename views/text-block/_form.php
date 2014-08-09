<?php

use webvimark\modules\content\models\TextBlockPlace;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use webvimark\extensions\BootstrapSwitch\BootstrapSwitch;
use webvimark\extensions\ckeditor\CKEditor;

/**
 * @var yii\web\View $this
 * @var webvimark\modules\content\models\TextBlock $model
 * @var yii\bootstrap\ActiveForm $form
 */
?>
<div class="text-block-form">

	<?php $form = ActiveForm::begin([
		'id'=>'text-block-form',
		'layout'=>'horizontal',
		]); ?>

	<?= $form->field($model->loadDefaultValues(), 'active')->checkbox(['class'=>'b-switch'], false) ?>

	<?= $form->field($model, 'name')->textInput(['maxlength' => 255, 'autofocus'=>$model->isNewRecord ? true:false]) ?>

	<?= $form->field($model, 'text_block_place_id')
		->dropDownList(
			ArrayHelper::map(TextBlockPlace::find()->where(['active'=>1])->asArray()->all(), 'id', 'name'),
			['prompt'=>'']
		) ?>

	<?= $form->field($model, 'body', ['enableClientValidation'=>false, 'enableAjaxValidation'=>false])->textarea(['rows' => 6]) ?>

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
<?php CKEditor::widget() ?>