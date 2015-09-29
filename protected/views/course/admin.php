<?php
/* @var $this CourseController */
/* @var $model Course */

$this->breadcrumbs=array(
	'教学课程'=>array('index'),
	'管理',
);

$this->menu=array(
	array('label'=>'List Course', 'url'=>array('index')),
	array('label'=>'Create Course', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#course-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>管理教学课程</h1>

<?php echo CHtml::link('筛选与查找','#',array('class'=>'search-button button small radius')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'course-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'name',
		'description',
		'semester',
		'duration',
		'textbook',
		array(
			'class'=>'CButtonColumn',
			'htmlOptions'=>array('width'=>'70em'),
		),
	),
)); ?>
