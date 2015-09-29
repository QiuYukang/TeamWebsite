<?php
/* @var $this AwardTeachingController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'教学成果',
);

$this->menu=array(
	array('label'=>'Create AwardTeaching', 'url'=>array('create')),
	array('label'=>'Manage AwardTeaching', 'url'=>array('admin')),
);
?>

<h1>教学成果</h1>
<table>
	<tr>
		<th><?php echo CHtml::encode(Award::model()->getAttributeLabel('project_name')); ?></th>
		<th><?php echo CHtml::encode(Award::model()->getAttributeLabel('award_name')); ?></th>
		<th><?php echo CHtml::encode(Award::model()->getAttributeLabel('award_date')); ?></th>
		<th><?php echo CHtml::encode(Award::model()->getAttributeLabel('org_from')); ?></th>
		<th><?php echo CHtml::encode(Award::model()->getAttributeLabel('peoples')); ?></th>
	</tr>
<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
	'itemsTagName' => 'tbody',

)); ?>
</table>
