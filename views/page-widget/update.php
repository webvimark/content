<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var webvimark\modules\content\models\PageWidget $model
 */

$this->title = 'Редактирование виджета шаблонов: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Виджеты шаблонов', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Редактирование';
?>
<div class="page-widget-update">

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
