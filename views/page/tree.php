<?php
/**
 * @var $this yii\web\View
 * @var $pagePlace webvimark\modules\content\models\PagePlace
 * @var $pages Page[]
 */
use webvimark\modules\content\models\Page;
use webvimark\modules\content\models\PagePlace;
use webvimark\extensions\jqtreewidget\JQTreeWidget;
use yii\bootstrap\ButtonDropdown;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = $pagePlace ? $pagePlace->name : PagePlace::NO_PLACE_NAME;
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="panel panel-default">
	<div class="panel-heading">
		<strong>
			<i class='fa fa-th'></i> <?= $this->title ?>
		</strong>
	</div>
	<div class="panel-body">

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
								'place' => @$pagePlace->code
							])
					],
					[
						'label' => 'Ссылку на страницу',
						'url'   => Url::to([
								'create',
								'type'=>Page::TYPE_LINK,
								'place' => @$pagePlace->code
							])
					],
				],
			],

		]) ?>
		<?= JQTreeWidget::widget([
			'models'        => $pages,
			'modelName'     => 'webvimark\modules\content\models\Page',
			'parentIdField' => 'parent_id',
			'statusField'   => 'active',
			'orderField'    => 'sorter',
			'leafName'      => function ($model) {
					$pageName = $model->is_main == 1 ? '<span style="color:green; font-style: italic;">'.$model->name.'</span>' : $model->name;

					if ( $model->type == Page::TYPE_TEXT )
					{
						$pageType = ' <span class="page-tree-type">Текстовая страница</span>';

						$viewUrl = ['/content/view/page', 'url'=>$model->url];
					}
					else
					{
						$pageType = ' <span class="page-tree-type">Ссылка</span>';

						$viewUrl = $model->link_url;
					}

					$editLink = Html::a($pageName . $pageType, ['/content/page/update', 'id'=>$model->id]);

					$viewLink = Html::a('<i class="fa fa-eye"></i>', $viewUrl, ['target'=>'_blank']);

					return $editLink . ' ' .$viewLink;
				},
		]) ?>

	</div>
</div>
