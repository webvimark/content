<?php
/**
 * @var $this yii\web\View
 * @var $page webvimark\modules\content\models\Page
 */

$this->title = $page->meta_title ? $page->meta_title : $page->name;

if ( $page->meta_keywords )
{
	$this->registerMetaTag([
		'name'=>'keywords',
		'content'=>$page->meta_keywords,
	], 'keywords');
}

if ( $page->meta_description )
{
	$this->registerMetaTag([
		'name'=>'description',
		'content'=>$page->meta_description,
	], 'description');
}
?>

<?= $page->body ?>