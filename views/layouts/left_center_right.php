<?php
/**
 * @var $content string
 * @var $this yii\web\View
 * @var $layoutWidgets array
 * @var $page webvimark\modules\content\models\Page
 */
use webvimark\modules\content\helpers\Singleton;
use webvimark\modules\content\models\PageLayoutHasPageWidget;

?>

<?php $layoutWidgets = Singleton::getData('_contentLayoutWidgets') ?>

<?php $this->beginContent($this->context->module->defaultParentLayout) ?>

	<div class="row">
		<div class="<?= $this->context->module->left3ColumnCssClass ?>">

			<?php PageLayoutHasPageWidget::renderWidgets($layoutWidgets, 'left') ?>
		</div>

		<div class="<?= $this->context->module->center3ColumnCssClass ?>">

			<?php PageLayoutHasPageWidget::renderWidgets($layoutWidgets, 'top') ?>

			<?= $content ?>

			<?php PageLayoutHasPageWidget::renderWidgets($layoutWidgets, 'bottom') ?>

		</div>

		<div class="<?= $this->context->module->right3ColumnCssClass ?>">

			<?php PageLayoutHasPageWidget::renderWidgets($layoutWidgets, 'right') ?>

		</div>
	</div>

<?php $this->endContent() ?>