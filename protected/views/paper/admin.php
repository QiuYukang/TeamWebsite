<?php
/* @var $this PaperController */
/* @var $model Paper */

$this->breadcrumbs=array(
	'论文'=>array('index'),
	'管理',
);

$this->menu=array(
	array('label'=>'列出论文', 'url'=>array('index')),
	array('label'=>'创建论文', 'url'=>array('create')),
	array('label'=>'导入论文', 'url'=>array('upload')),
	array('label'=>'导出全部论文', 'url'=>array('exportAll')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#paper-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Papers</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('查询','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'paper-grid',
	'dataProvider'=>$dataProvider,
    'ajaxUpdate'=>true,
	'filter'=>$model,
	'columns'=>array(
		'info',

		array(
			'name'=>'level',
			'type'=>'raw',
			'value'=>'$data->getLevelString()',
			'filter' => false,
			'htmlOptions'=>array('width'=>'80em'),
		),
        /*
		'status',
		'pass_date',
		'pub_date',
		'index_date',

		'sci_number',
		'ei_number',
		'istp_number',
		'is_first_grade',
		'is_core',
		'other_pub',
		'is_journal',
		'is_conference',
		'is_intl',
		'is_domestic',
		'file_name',
		'is_high_level',
		'maintainer_id',
        */
		array(
			'class'=>'CButtonColumn',
			'htmlOptions'=>array('width'=>'70em'),
		),
	),
)); ?>
