<?php
/* @var $this UserController */
/* @var $model User */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'user-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">带<span class="required">*</span>的为必填项.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="">
		<?php echo $form->labelEx($model,'username'); ?>
		<?php echo $form->textField($model,'username',array('size'=>30,'maxlength'=>30)); ?>
		<?php echo $form->error($model,'username'); ?>
	</div>

	<div class="">
		<?php echo $form->labelEx($model,'password'); ?>
		<?php echo $form->passwordField($model,'password',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'password'); ?>
	</div>
	<div class="">
		<?php echo $form->labelEx($model,'password'); ?>
		<?php echo $form->passwordField($model,'passwordRepeat',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'passwordRepeat'); ?>
	</div>
	<div class="">
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'email'); ?>
	</div>
	<div class="row">
		<div class="medium-3 columns">
			<?php echo $form->labelEx($model,'is_admin'); ?>
			<?php echo $form->checkBox($model,'is_admin'); ?>
			<?php echo $form->error($model,'is_admin'); ?>
		</div>

		<div class="medium-3 columns">
			<?php echo $form->labelEx($model,'is_manager'); ?>
			<?php echo $form->checkBox($model,'is_manager'); ?>
			<?php echo $form->error($model,'is_manager'); ?>
		</div>

		<div class="medium-3 columns end">
			<?php echo $form->labelEx($model,'is_user'); ?>
			<?php echo $form->checkBox($model,'is_user'); ?>
			<?php echo $form->error($model,'is_user'); ?>
		</div>
	</div>
	<div class="buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? '创建' : '保存',array('class'=>'button small radius')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->