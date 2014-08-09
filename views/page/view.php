<?php

use webvimark\modules\content\models\Page;
use webvimark\modules\content\models\PagePlace;
use yii\bootstrap\ButtonDropdown;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

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

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => $placeName, 'url' => ['/content/page/tree', 'place'=>$placeCode]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="page-view">


	<div class="panel panel-default">
		<div class="panel-heading">
			<strong>
				<span class="glyphicon glyphicon-th"></span> <?= Html::encode($this->title) ?>
			</strong>
		</div>
		<div class="panel-body">

			<p>
				<?= ButtonDropdown::widget([
					'label'=>'<span class="glyphicon glyphicon-plus-sign"></span> ' . 'Создать',
					'options'=>['class'=>'btn btn-success btn-sm'],
					'encodeLabel'=>false,
					'dropdown'=>[
						'items' => [
							[
								'label' => 'Текстовую страницу',
								'url'   => Url::to([
										'create',
										'type'=>Page::TYPE_TEXT,
										'place' => @$model->pagePlace->code
									])
							],
							[
								'label' => 'Ссылку на страницу',
								'url'   => Url::to([
										'create',
										'type'=>Page::TYPE_LINK,
										'place' => @$model->pagePlace->code
									])
							],
						],
					],

				]) ?>
				<?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-sm btn-primary']) ?>

				<?= Html::a(
					'Посмотреть на сайте <i class="fa fa-eye"></i>',
					$model->type == Page::TYPE_TEXT ? ['/content/view/page', 'url'=>$model->url] : $model->link_url,
					['class' => 'btn btn-sm btn-default', 'target'=>'_blank']
				) ?>

				<?= Html::a('Удалить', ['delete', 'id' => $model->id], [
					'class' => 'btn btn-sm btn-danger pull-right',
					'data' => [
						'confirm' => 'Вы уверены, что хотите удалить этот элемент?',
						'method' => 'post',
					],
				]) ?>
			</p>

			<?= DetailView::widget([
				'model' => $model,
				'attributes' => [
					'id',
					[
						'attribute'=>'active',
						'value'=>($model->active == 1) ?
								'<span class="label label-success">Да</span>' :
								'<span class="label label-warning">Нет</span>',
						'format'=>'raw',
					],
					'name',
					[
						'attribute'=>'url',
						'visible'=>$model->type == Page::TYPE_TEXT,
					],
					[
						'attribute'=>'link_url',
						'visible'=>$model->type == Page::TYPE_LINK,
					],
					[
						'attribute'=>'page_place_id',
						'value'=>@$model->pagePlace->name,
					],
					[
						'attribute'=>'page_layout_id',
						'value'=>@$model->pageLayout->name,
						'visible'=>$model->type == Page::TYPE_TEXT,
					],
					[
						'attribute'=>'body',
						'visible'=>$model->type == Page::TYPE_TEXT,
						'format'=>'raw',
					],
					[
						'attribute'=>'meta_title',
						'visible'=>$model->type == Page::TYPE_TEXT,
					],
					[
						'attribute'=>'meta_keywords',
						'visible'=>$model->type == Page::TYPE_TEXT,
					],
					[
						'attribute'=>'meta_description',
						'visible'=>$model->type == Page::TYPE_TEXT,
					],
					'created_at:datetime',
					'updated_at:datetime',
				],
			]) ?>

		</div>
	</div>
</div>
