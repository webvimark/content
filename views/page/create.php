<?php

use webvimark\extensions\FormFieldsVisibility\FormFieldsVisibility;
use webvimark\modules\content\models\Page;
use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var string $place
 * @var string $placeName
 * @var webvimark\modules\content\models\Page $model
 */

$this->title = 'Создание страницы';
$this->params['breadcrumbs'][] = ['label' => $placeName, 'url' => ['/content/page/tree', 'place'=>$place]];

$this->params['breadcrumbs'][] = $this->title;
?>
<div class="page-create">

	<div class="panel panel-default">
		<div class="panel-heading">
			<strong>
				<span class="glyphicon glyphicon-th"></span> <?= Html::encode($this->title) ?>
			</strong>

			<?php if ( $model->type == Page::TYPE_TEXT ): ?>

				<?= FormFieldsVisibility::widget([
					'model'=>$model,
					'storageId'=>'page_type_text',
					'attributes' => [
						'active'                => $model->getAttributeLabel('active'),
						'is_main'               => $model->getAttributeLabel('is_main'),
						'url'                   => $model->getAttributeLabel('url'),
						'page_place_id'         => $model->getAttributeLabel('page_place_id'),
						'page_custom_layout_id' => $model->getAttributeLabel('page_custom_layout_id'),
						'meta_description'      => $model->getAttributeLabel('meta_description'),
						'meta_keywords'         => $model->getAttributeLabel('meta_keywords'),
						'meta_title'            => $model->getAttributeLabel('meta_title'),
					],
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
