<?php
/* @var $this AwardTeachingController */
/* @var $model AwardTeaching */

$this->breadcrumbs=array(
	'教学成果'=>array('index'),
	'添加',
);

$this->menu=array(
	array('label'=>'List AwardTeaching', 'url'=>array('index')),
	array('label'=>'Manage AwardTeaching', 'url'=>array('admin')),
);
?>

<h1>添加教学成果</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>