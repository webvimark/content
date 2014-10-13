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
		'id'      => 'page-form',
		'layout'  => 'horizontal',
		'options' => [
			'enctype' => "multipart/form-data",
		]
	]); ?>

	<?= $form->field($model->loadDefaultValues(), 'active')->checkbox(['class'=>'b-switch'], false) ?>

	<?php if ( $model->is_main == 0 ): ?>
		<?= $form->field($model->loadDefaultValues(), 'is_main')->checkbox(['class'=>'b-switch'], false) ?>
	<?php endif; ?>

	<?= $form->field($model, 'name')->textInput(['maxlength' => 255, 'autofocus'=>$model->isNewRecord ? true:false]) ?>

	<?php if ( $model->pagePlace AND $model->pagePlace->with_image == 1 ): ?>

		<?php if ( ! $model->isNewRecord AND is_file($model->getImagePath('full', 'menu_image'))): ?>
			<div class='form-group field-page-menu_image'>
				<div class='col-sm-3'></div>
				<div class='col-sm-6'>
					<?= Html::img($model->getImageUrl('full', 'menu_image'), ['alt'=>'menu_image']) ?>
					<br/>
					<?= Html::a(
						'<i class="fa fa-trash-o"></i>',
						['delete-menu-image', 'pageId'=>$model->id],
						[
							'style'=>'color:red',
							'data-confirm'=>'Вы уверены ?',
						]
					) ?>
				</div>
			</div>

		<?php endif; ?>

		<?= $form->field($model, 'menu_image', ['enableClientValidation'=>false, 'enableAjaxValidation'=>false])
			->fileInput(['class'=>'form-control']) ?>
	<?php endif; ?>

	<?php if ( $model->type == Page::TYPE_LINK ): ?>

		<?= $form->field($model, 'link_url')->dropDownList(Page::getLinkUrlList(), ['prompt'=>'']) ?>

		<?= $form->field($model, 'page_place_id')
			->dropDownList(
				ArrayHelper::map(PagePlace::find()->where(['active'=>1])->asArray()->all(), 'id', 'name'),
				['prompt'=>'']
			) ?>

	<?php else: ?>

		<?= $form->field($model, 'url')->textInput(['maxlength' => 255])
			->hint(Html::a(
					'ЧПУ',
					'https://www.google.ru/search?q=%D1%87%D0%B5%D0%BB%D0%BE%D0%B2%D0%B5%D0%BA%D0%BE-%D0%BF%D0%BE%D0%BD%D1%8F%D1%82%D0%BD%D1%8B%D0%B5+%D1%83%D1%80%D0%BB&oq=%D1%87%D0%B5%D0%BB%D0%BE%D0%B2%D0%B5%D0%BA%D0%BE-%D0%BF%D0%BE%D0%BD%D1%8F%D1%82%D0%BD%D1%8B%D0%B5+%D1%83%D1%80%D0%BB',
					['target'=>'_blank']
				) .' Вы можете оставить поле пустым.') ?>

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
			)->hint(Html::a('К списку шаблонов', '/content/page-layout/index', ['target'=>'_blank'])) ?>

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