<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var app\modules\content\models\TextBlockPlace $model
 */

$this->title = 'Редактирование места расположения текстовых блоков: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Места расположения текстовых блоков', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Редактирование';
?>
<div class="text-block-place-update">

	<div class="panel panel-default">
		<div class="panel-heading">
			<strong>
				<span class="glyphicon glyphicon-th"></span> <?= Html::encode($this->title) ?>
			</strong>
		</div>
		<div class="panel-body">

			<?= $this->render('_form', compact('model')) ?>
		</div>
	</div>

</div>
