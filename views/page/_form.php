<?php

use webvimark\modules\content\models\Page;
use webvimark\modules\content\models\PageCustomLayout;
use webvimark\modules\content\models\PageLayout;
use webvimark\modules\content\models\PagePlace;
use webvimark\extensions\ckeditor\CKEditor;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use webvimark\extensions\BootstrapSwitch\BootstrapSwitch;

/**
 * @var yii\web\View $this
 * @var webvimark\modules\content\models\Page $model
 * @var yii\bootstrap\ActiveForm $form
 */
?>
<div class="page-form">

	<?php $form = ActiveForm::begin([
		'id'=>'page-form',
		'layout'=>'horizontal',
		]); ?>

	<?= $form->field($model->loadDefaultValues(), 'active')->checkbox(['class'=>'b-switch'], false) ?>

	<?= $form->field($model, 'name')->textInput(['maxlength' => 255, 'autofocus'=>$model->isNewRecord ? true:false]) ?>

	<?php if ( $model->type == Page::TYPE_LINK ): ?>

		<?= $form->field($model, 'link_url')->dropDownList(Page::getLinkUrlList(), ['prompt'=>'']) ?>

		<?= $form->field($model, 'page_place_id')
			->dropDownList(
				ArrayHelper::map(PagePlace::find()->where(['active'=>1])->asArray()->all(), 'id', 'name'),
				['prompt'=>'']
			) ?>

	<?php else: ?>

		<?= $form->field($model, 'url')->textInput(['maxlength' => 255]) ?>

		<?= $form->field($model, 'page_place_id')
			->dropDownList(
				ArrayHelper::map(PagePlace::find()->where(['active'=>1])->asArray()->all(), 'id', 'name'),
				['prompt'=>'']
			) ?>

		<?php $customLayouts = ArrayHelper::map(PageCustomLayout::find()->where(['active'=>1])->asArray()->all(), 'id', 'name') ?>

		<?php if ( count($customLayouts) > 0 ): ?>

			<?= $form->field($model, 'page_custom_layout_id')
				->dropDownList(
					$customLayouts,
					['prompt'=>'']
				) ?>

		<?php endif; ?>


		<?= $form->field($model, 'page_layout_id')
			->dropDownList(
				ArrayHelper::map(PageLayout::find()->asArray()->all(), 'id', 'name'),
				['prompt'=>'']
			) ?>

		<?= $form->field($model, 'body')->textarea() ?>

		<?= $form->field($model, 'meta_title')->textInput(['maxlength' => 255]) ?>

		<?= $form->field($model, 'meta_keywords')->textInput(['maxlength' => 255]) ?>

		<?= $form->field($model, 'meta_description')->textInput(['maxlength' => 255]) ?>

	<?php endif; ?>


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

<?php CKEditor::widget(['type'=>CKEditor::TYPE_STANDARD]) ?>
<?php BootstrapSwitch::widget() ?>