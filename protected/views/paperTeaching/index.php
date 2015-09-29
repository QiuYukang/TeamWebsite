<?php
/* @var $this PaperTeachingController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'教改论文',
);

$this->menu=array(
	array('label'=>'Create PaperTeaching', 'url'=>array('create')),
	array('label'=>'Manage PaperTeaching', 'url'=>array('admin')),
);
?>

<h1>教改论文</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
    'itemsTagName'=>'ol',
	'itemView'=>'_view',
)); ?>
