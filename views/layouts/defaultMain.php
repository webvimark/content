<?php
/* @var $content string */
/* @var $this \yii\web\View */

use webvimark\helpers\Singleton;
use webvimark\modules\content\models\PageLayout;


$pageLayout =  PageLayout::findOne(['is_main'=>1]);

$layoutWidgets = $pageLayout->getWidgetsGroupedByPosition();

Singleton::setData('_contentLayoutWidgets', $layoutWidgets);

$layout = PageLayout::getLayoutBasedOnWidgetPositions($layoutWidgets);

$this->beginContent('@vendor/webvimark/module-content/views/layouts/' . $layout . '.php');

echo $content;

$this->endContent();
