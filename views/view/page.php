<?php
/**
 * @var $this yii\web\View
 * @var $page webvimark\modules\content\models\Page
 */

use webvimark\extensions\ckeditor\CKEditor;
use webvimark\modules\UserManagement\models\User;
use yii\helpers\Url;
use yii\web\View;

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

<div style="position: relative; width: 100%">

	<?php if ( User::canRoute(['/content/page/inline-save']) ): ?>
		<div id="page-inline-edit-btn" style="cursor: pointer; position: absolute; top: -20px; right: -10px">
			<span class="glyphicon glyphicon-edit" style="color: #008000"></span>
		</div>
	<?php endif; ?>

	<div class="page-inline-editor page-wrapper" id="content-page-<?= $page->id ?>">
		<?= $page->body ?>

	</div>
</div>

<?php if ( User::canRoute(['/content/page/inline-save']) ): ?>

	<?php
	$js = <<<JS

	var inlineEditor = $('.page-inline-editor');
	var inlineEditBtn = $('#page-inline-edit-btn');


	// Clicking on edit btn make content editable and invoke CKEditor
	inlineEditBtn.on('click', function(){
		var _t = $(this);

		_t.hide();

		CKEDITOR.inline( inlineEditor.attr('id') );

		inlineEditor.attr('contenteditable', true).focus();
	});
JS;

	$this->registerJs($js);

	// For CKEditor inline save plugin
	$this->registerJs("var inline_save_url = '".Url::to(['/content/page/inline-save'])."'", View::POS_BEGIN);
	?>

	<?php CKEditor::widget(['type'=>CKEditor::TYPE_INLINE]) ?>

<?php endif; ?>
