<?php
/* @var $this CourseController */
/* @var $data Course */
?>
<?php

?>
<div class="view">


	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />


	<b><?php echo CHtml::encode($data->getAttributeLabel('semester')); ?>:</b>
	<?php echo CHtml::encode($data->semester); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('duration')); ?>:</b>
	<?php echo CHtml::encode($data->duration); ?>
	<br />

	<a class="more" href="#" style="">更多</a>
	<div class="abstract" style="display: none;">
	<b><?php echo CHtml::encode($data->getAttributeLabel('description')); ?>:</b>
	<?php echo $data->getPurifiedDescription(); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('textbook')); ?>:</b>
	<?php echo $data->getPurifiedTextBook();?>
	<br />

	</div>
</div>