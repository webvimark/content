<?php

use webvimark\modules\content\models\PageWidget;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\widgets\Pjax;
use webvimark\extensions\GridBulkActions\GridBulkActions;
use webvimark\extensions\GridPageSize\GridPageSize;
use yii\grid\GridView;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var webvimark\modules\content\models\search\PageWidgetSearch $searchModel
 */

$this->title = 'Виджеты шаблонов';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="page-widget-index">

	<?php // echo $this->render('_search', ['model' => $searchModel]); ?>

	<div class="panel panel-default">
		<div class="panel-heading">
			<strong>
				<span class="glyphicon glyphicon-th"></span>  <?= Html::encode($this->title) ?>
			</strong>

			<?= GridPageSize::widget(['pjaxId'=>'page-widget-grid-pjax']) ?>
		</div>

		<div class="panel-body">

			<div class="row">
				<div class="col-sm-6">
					<p>
						<?= Html::a('<span class="glyphicon glyphicon-plus-sign"></span> ' . 'Создать', ['create'], ['class' => 'btn btn-sm btn-success']) ?>
					</p>
				</div>

				<div class="col-sm-6 text-right">
					<?= GridBulkActions::widget(['gridId'=>'page-widget-grid']) ?>
				</div>
			</div>


			<?php Pjax::begin([
				'id'=>'page-widget-grid-pjax',
			]) ?>

			<?= GridView::widget([
				'id'=>'page-widget-grid',
				'dataProvider' => $dataProvider,
				'pager'=>[
					'options'=>['class'=>'pagination pagination-sm'],
					'hideOnSinglePage'=>true,
					'lastPageLabel'=>'>>',
					'firstPageLabel'=>'<<',
				],
				'layout'=>'{items}<div class="row"><div class="col-sm-8">{pager}</div><div class="col-sm-4 text-right">{summary}</div></div>',
				'filterModel' => $searchModel,
				'columns' => [
					['class' => 'yii\grid\SerialColumn', 'options'=>['style'=>'width:10px'] ],

					[
						'attribute'=>'name',
						'value'=>function($model){
								return Html::a($model->name, ['update', 'id'=>$model->id], ['data-pjax'=>0]);
							},
						'format'=>'raw',
					],
					[
						'attribute'=>'position',
						'filter'=>PageWidget::getPositionList(),
						'value'=>function($model){
								return PageWidget::getPositionValue($model->position);
							},
						'format'=>'raw',
					],
					[
						'class'=>'webvimark\components\StatusColumn',
						'attribute'=>'has_settings',
						'toggleUrl'=>Url::to(['toggle-attribute', 'attribute'=>'has_settings', 'id'=>'_id_']),
					],
					'settings_url',
					[
						'class'=>'webvimark\components\StatusColumn',
						'attribute'=>'is_internal',
					],
					[
						'class'=>'webvimark\components\StatusColumn',
						'attribute'=>'only_one',
					],
					[
						'class'=>'webvimark\components\StatusColumn',
						'attribute'=>'active',
						'toggleUrl'=>Url::to(['toggle-attribute', 'attribute'=>'active', 'id'=>'_id_']),
					],
					['class' => 'webvimark\components\SorterColumn'],

					['class' => 'yii\grid\CheckboxColumn', 'options'=>['style'=>'width:10px'] ],
					[
						'class' => 'yii\grid\ActionColumn',
						'contentOptions'=>['style'=>'width:70px; text-align:center;'],
					],
				],
			]); ?>
		
			<?php Pjax::end() ?>
		</div>
	</div>
</div>
