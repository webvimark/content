<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var webvimark\modules\content\models\PageCustomLayout $model
 */

$this->title = 'Создание custom layout';
$this->params['breadcrumbs'][] = ['label' => 'Custom layouts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="page-custom-layout-create">

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
