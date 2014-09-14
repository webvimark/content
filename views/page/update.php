<?php

use webvimark\extensions\FormFieldsVisibility\FormFieldsVisibility;
use webvimark\modules\content\models\Page;
use webvimark\modules\content\models\PageCustomLayout;
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

				<?php
				$fieldVisibilityAttributes = [
					'active'                => $model->getAttributeLabel('active'),
					'is_main'               => $model->getAttributeLabel('is_main'),
					'url'                   => $model->getAttributeLabel('url'),
					'menu_image'            => $model->getAttributeLabel('menu_image'),
					'page_place_id'         => $model->getAttributeLabel('page_place_id'),
					'page_custom_layout_id' => $model->getAttributeLabel('page_custom_layout_id'),
					'meta_description'      => $model->getAttributeLabel('meta_description'),
					'meta_keywords'         => $model->getAttributeLabel('meta_keywords'),
					'meta_title'            => $model->getAttributeLabel('meta_title'),
				];

				if ( PageCustomLayout::find()->andWhere(['active'=>1])->count('id') == 0 )
				{
					unset($fieldVisibilityAttributes['page_custom_layout_id']);
				}

				if ( !$model->pagePlace OR $model->pagePlace->with_image != 1 )
				{
					unset($fieldVisibilityAttributes['menu_image']);
				}
				?>

				<?= FormFieldsVisibility::widget([
					'model'=>$model,
					'storageId'=>'page_type_text',
					'attributes' => $fieldVisibilityAttributes,
				]) ?>

			<?php elseif ( $model->type == Page::TYPE_LINK ): ?>

				<?= FormFieldsVisibility::widget([
					'model'=>$model,
					'storageId'=>'page_type_link',
					'attributes' => [
						'page_place_id'         => $model->getAttributeLabel('page_place_id'),
					],
				]) ?>

			<?php endif; ?>
		</div>
		<div class="panel-body">

			<?= $this->render('_form', compact('model')) ?>
		</div>
	</div>

</div>
