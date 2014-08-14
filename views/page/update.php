<?php

use webvimark\extensions\FormFieldsVisibility\FormFieldsVisibility;
use webvimark\modules\content\models\Page;
use webvimark\modules\content\models\PagePlace;
use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var webvimark\modules\content\models\Page $model
 */

if ( $model->pagePlace )
{
	$placeCode = $model->pagePlace->code;
	$placeName = $model->pagePlace->name;
}
else
{
	$placeCode = null;
	$placeName = PagePlace::NO_PLACE_NAME;
}

$this->title = 'Редактирование страницы: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => $placeName, 'url' => ['/content/page/tree', 'place'=>$placeCode]];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Редактирование';
?>
<div class="page-update">

	<div class="panel panel-default">
		<div class="panel-heading">
			<strong>
				<span class="glyphicon glyphicon-th"></span> <?= Html::encode($this->title) ?>
			</strong>

			<?php if ( $model->type == Page::TYPE_TEXT ): ?>

				<?= FormFieldsVisibility::widget([
					'model'=>$model,
					'attributes' => [
						'url'                   => $model->getAttributeLabel('url'),
						'page_place_id'         => $model->getAttributeLabel('page_place_id'),
						'page_custom_layout_id' => $model->getAttributeLabel('page_custom_layout_id'),
						'meta_description'      => $model->getAttributeLabel('meta_description'),
						'meta_keywords'         => $model->getAttributeLabel('meta_keywords'),
						'meta_title'            => $model->getAttributeLabel('meta_title'),
					],
				]) ?>

			<?php endif; ?>
		</div>
		<div class="panel-body">

			<?= $this->render('_form', compact('model')) ?>
		</div>
	</div>

</div>
