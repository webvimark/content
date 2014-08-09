<?php

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
		</div>
		<div class="panel-body">

			<?= $this->render('_form', compact('model')) ?>
		</div>
	</div>

</div>
