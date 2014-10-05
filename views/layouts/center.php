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

<?php $this->beginContent(Yii::$app->getModule('content')->defaultParentLayout) ?>

<?php if ( count($layoutWidgets['header']) > 0 ): ?>
	<?php PageLayoutHasPageWidget::renderWidgets($layoutWidgets, 'header') ?>

<?php endif; ?>

<div class="<?= Yii::$app->getModule('content')->wrapperCssClass ?>">

	<div class="row">

		<div class="<?= Yii::$app->getModule('content')->center1ColumnCssClass ?>">
			<?php PageLayoutHasPageWidget::renderWidgets($layoutWidgets, 'top') ?>

			<?= $content ?>

			<?php PageLayoutHasPageWidget::renderWidgets($layoutWidgets, 'bottom') ?>
		</div>

	</div>
</div>

<?php if ( count($layoutWidgets['footer']) > 0 ): ?>
	<?php PageLayoutHasPageWidget::renderWidgets($layoutWidgets, 'footer') ?>

<?php endif; ?>


<?php $this->endContent() ?>