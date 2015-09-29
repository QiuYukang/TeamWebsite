<?php
/* @var $this AwardTeachingController */
/* @var $model AwardTeaching */

$this->breadcrumbs=array(
	'教学成果'=>array('index'),
	'管理',
);

$this->menu=array(
	array('label'=>'List AwardTeaching', 'url'=>array('index')),
	array('label'=>'Create AwardTeaching', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#award-teaching-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>管理教学成果</h1>

<?php echo CHtml::link('筛选与查找','#',array('class'=>'search-button button small radius')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'award-teaching-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'project_name',
		'award_name',
		'award_date',
		'org_from',
		array(
			'name'=>'level',
			'type'=>'raw',
			'value'=>'$data->getLevelString()',
			'filter' => false,
			'htmlOptions'=>array('width'=>'80em'),
		),
		array(
			'name'=>'peoples',
			'type'=>'raw',
			'value'=>'$data->getPeoples()',
			'filter' => false,
			'htmlOptions'=>array('width'=>'200em'),
		),
		array(
			'class'=>'CButtonColumn',
			'htmlOptions'=>array('width'=>'70em'),
		),
	),
)); ?>
