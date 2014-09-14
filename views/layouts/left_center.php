<?php
/**
 * @var $content string
 * @var $this yii\web\View
 * @var $layoutWidgets array
 * @var $page webvimark\modules\content\models\Page
 */
use webvimark\helpers\Singleton;
use webvimark\modules\content\models\PageLayoutHasPageWidget;

?>
<?php $layoutWidgets = Singleton::getData('_contentLayoutWidgets') ?>

<?php $this->beginContent($this->context->module->defaultParentLayout) ?>

<?php if ( count($layoutWidgets['header']) > 0 ): ?>
	<div class="row">
		<div class="<?= $this->context->module->center1ColumnCssClass ?>">
			<?php PageLayoutHasPageWidget::renderWidgets($layoutWidgets, 'header') ?>
		</div>
	</div>
<?php endif; ?>

	<div class="row">
		<div class="<?= $this->context->module->left2ColumnCssClass ?>">
			<?php PageLayoutHasPageWidget::renderWidgets($layoutWidgets, 'left') ?>
		</div>

		<div class="<?= $this->context->module->center2ColumnCssClass ?>">
			<?php PageLayoutHasPageWidget::renderWidgets($layoutWidgets, 'top') ?>

			<?= $content ?>

			<?php PageLayoutHasPageWidget::renderWidgets($layoutWidgets, 'bottom') ?>
		</div>
	</div>

<?php if ( count($layoutWidgets['footer']) > 0 ): ?>
	<div class="row">
		<div class="<?= $this->context->module->center1ColumnCssClass ?>">
			<?php PageLayoutHasPageWidget::renderWidgets($layoutWidgets, 'footer') ?>
		</div>
	</div>
<?php endif; ?>


<?php $this->endContent() ?>