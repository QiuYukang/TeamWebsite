<?php
/* @var $this UserController */
/* @var $model User */
/* @var $form CActiveForm */
?>

<br/>

<div class="form">

    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'user-form',
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // There is a call to performAjaxValidation() commented in generated controller code.
        // See class documentation of CActiveForm for details on this.
//	'enableAjaxValidation'=>false,
        'htmlOptions' => array(
            'method' => 'post',
        ),
    )); ?>

    <!--	--><?php //echo $form->errorSummary($model); ?>

    <div class="row">
        <div class="medium-6 columns end">
            <?php echo $form->labelEx($model,'username'); ?>
            <?php if($model->isNewRecord)
                echo $form->textField($model,'username',array('size'=>30,'maxlength'=>30));
            else
                echo $form->textField($model,'username',array('size'=>30,'maxlength'=>30,'readonly'=>'readonly'));
                ?>
            <?php echo $form->error($model,'username'); ?>
        </div>
    </div>

    <div class="row">
        <div class="medium-6 columns end">
            <?php echo $form->labelEx($model,'password'); ?>
            <?php echo $form->passwordField($model,'password',array('size'=>30,'maxlength'=>30)); ?>
            <?php echo $form->error($model,'password'); ?>
        </div>
    </div>
    <div class="row">
        <div class="medium-6 columns end">
            <?php echo $form->labelEx($model,'repeat_password'); ?>
            <?php echo $form->passwordField($model,'repeat_password',array('size'=>60,'maxlength'=>30)); ?>
            <?php echo $form->error($model,'repeat_password'); ?>
        </div>
    </div>
    <div class="row">
        <div class="medium-2 columns">
            <?php echo $form->labelEx($model,'is_admin'); ?>
            <?php echo $form->checkBox($model,'is_admin'); ?>
            <?php echo $form->error($model,'is_admin'); ?>
        </div>

        <div class="medium-2 columns">
            <?php echo $form->labelEx($model,'is_manager'); ?>
            <?php echo $form->checkBox($model,'is_manager'); ?>
            <?php echo $form->error($model,'is_manager'); ?>
        </div>

        <div class="medium-2 columns end">
            <?php echo $form->labelEx($model,'is_user'); ?>
            <?php echo $form->checkBox($model,'is_user'); ?>
            <?php echo $form->error($model,'is_user'); ?>
        </div>
    </div>
    <br/>
    <div class="buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? '创建' : '保存',array('class'=>'btn btn-default')); ?>
        <?php if(!$model->isNewRecord) { ?>
        <input type="button" value="删除" class="btn btn-default" onclick="return firm();" />
        <?php } ?>
        <input type="button" value="返回" class="btn btn-default" onclick="location='index.php?r=user/admin'" />
    </div>

    <?php $this->endWidget(); ?>

    <hr/>

</div><!-- form -->


<script>
    function firm() {
        if(confirm("您确定要删除这个用户吗？")) {
            location.href = '<?php echo Yii::app()->controller->createUrl("delete",array("id"=>$model->id)); ?>';
            return true;
        }

        else {
            return false;
        }
    }
</script>