<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;
use webvimark\extensions\GridBulkActions\GridBulkActions;
use webvimark\extensions\GridPageSize\GridPageSize;
use yii\grid\GridView;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var webvimark\modules\content\models\search\PageLayoutSearch $searchModel
 */

$this->title = 'Шаблоны страниц';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="page-layout-index">

	<?php // echo $this->render('_search', ['model' => $searchModel]); ?>

	<div class="panel panel-default">
		<div class="panel-heading">
			<strong>
				<span class="glyphicon glyphicon-th"></span>  <?= Html::encode($this->title) ?>
			</strong>

			<?= GridPageSize::widget(['pjaxId'=>'page-layout-grid-pjax']) ?>
		</div>

		<div class="panel-body">

			<div class="row">
				<div class="col-sm-6">
					<p>
						<?= Html::a('<span class="glyphicon glyphicon-plus-sign"></span> ' . 'Создать', ['create'], ['class' => 'btn btn-sm btn-success']) ?>
					</p>
				</div>

				<div class="col-sm-6 text-right">
					<?= GridBulkActions::widget(['gridId'=>'page-layout-grid']) ?>
				</div>
			</div>


			<?php Pjax::begin([
				'id'=>'page-layout-grid-pjax',
			]) ?>

			<?= GridView::widget([
				'id'=>'page-layout-grid',
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
								return Html::a($model->name, ['view', 'id'=>$model->id], ['data-pjax'=>0]);
							},
						'format'=>'raw',
					],
					[
						'value'=>function($model){
								return Html::tag('span', 'Копировать <i class="fa fa-copy"></i>', [
									'class'=>'btn btn-default btn-sm clone-btn',
									'data-clone-id'=>$model->id,
								]);
							},
						'options'=>['width'=>'10px'],
						'format'=>'raw',
					],
					[
						'class'=>'webvimark\components\StatusColumn',
						'attribute'=>'is_main',
						'toggleUrl'=>Url::to(['toggle-attribute', 'attribute'=>'is_main', 'id'=>'_id_']),
						'visible'=>Yii::$app->user->isSuperadmin,
					],
					[
						'class'=>'webvimark\components\StatusColumn',
						'attribute'=>'is_system',
						'toggleUrl'=>Url::to(['toggle-attribute', 'attribute'=>'is_system', 'id'=>'_id_']),
						'visible'=>Yii::$app->user->isSuperadmin,
					],
					[
						'class'=>'webvimark\components\StatusColumn',
						'attribute'=>'active',
						'toggleUrl'=>Url::to(['toggle-attribute', 'attribute'=>'active', 'id'=>'_id_']),
						'visible'=>Yii::$app->user->isSuperadmin,

					],
					['class' => 'webvimark\components\SorterColumn'],

					['class' => 'yii\grid\CheckboxColumn', 'options'=>['style'=>'width:10px'] ],
					[
						'class' => 'yii\grid\ActionColumn',
						'buttons'=>[
							'delete'=>function($url, $model){
									if ( $model->is_system  == 1 OR $model->is_main == 1 )
									{
										return '';
									}
									else
									{
										return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
											'title' => Yii::t('yii', 'Delete'),
											'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
											'data-method' => 'post',
											'data-pjax' => '0',
										]);
									}
								},
						],
						'contentOptions'=>['style'=>'width:70px; text-align:center;'],
					],
				],
			]); ?>
		
			<?php Pjax::end() ?>
		</div>
	</div>
</div>

<?php
$url = Url::to(['clone-page-layout']);

$js = <<<JS
$(document).on('click', '.clone-btn', function(){
	$.get('$url', { id: $(this).data('clone-id') }).done(function(){
		$.pjax.reload({container: '#page-layout-grid-pjax'});
	})
});
JS;

$this->registerJs($js);
?>