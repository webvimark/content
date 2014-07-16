<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var app\modules\content\models\TextBlockPlace $model
 */

$this->title = 'Создание места расположения текстовых блоков';
$this->params['breadcrumbs'][] = ['label' => 'Места расположения текстовых блоков', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="text-block-place-create">

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
