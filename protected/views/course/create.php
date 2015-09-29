<?php
/* @var $this CourseController */
/* @var $model Course */

$this->breadcrumbs=array(
	'教学课程'=>array('index'),
	'添加',
);

$this->menu=array(
	array('label'=>'List Course', 'url'=>array('index')),
	array('label'=>'Manage Course', 'url'=>array('admin')),
);
?>

<h1>添加教学课程</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>