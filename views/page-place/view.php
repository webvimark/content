<?php

use webvimark\modules\content\models\PagePlace;
use yii\helpers\Html;
use yii\widgets\DetailView;

/**
 * @var yii\web\View $this
 * @var webvimark\modules\content\models\PagePlace $model
 */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Места размещения страниц', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="page-place-view">


	<div class="panel panel-default">
		<div class="panel-heading">
			<strong>
				<span class="glyphicon glyphicon-th"></span> <?= Html::encode($this->title) ?>
			</strong>
		</div>
		<div class="panel-body">

			<p>
				<?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-sm btn-primary']) ?>
				<?= Html::a('Создать', ['create'], ['class' => 'btn btn-sm btn-success']) ?>
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
					[
						'attribute'=>'with_children',
						'value'=>($model->with_children == 1) ?
								'<span class="label label-success">Да</span>' :
								'<span class="label label-warning">Нет</span>',
						'format'=>'raw',
					],
					[
						'attribute'=>'with_image',
						'value'=>($model->with_image == 1) ?
								'<span class="label label-success">Да</span>' :
								'<span class="label label-warning">Нет</span>',
						'format'=>'raw',
					],
					[
						'attribute'=>'image_before_label',
						'value'=>($model->image_before_label == 1) ?
								'<span class="label label-success">Да</span>' :
								'<span class="label label-warning">Нет</span>',
						'format'=>'raw',
						'visible'=>($model->with_image == 1),
					],
					'name',
					[
						'attribute'=>'type',
						'value'=>($model->type == PagePlace::TYPE_BASE_MENU) ? 'Основное меню' : 'Боковое меню',
					],
					'code',
					'created_at:datetime',
					'updated_at:datetime',
				],
			]) ?>

		</div>
	</div>
</div>
