<?php

$this->pageTitle=Yii::app()->name . ' - 修改密码';
//面包屑
$this->breadcrumbs=array(
    '用户管理'=>array('user/admin'),
    '修改密码',
);

?>

<div class="cam-page-header">
    <div class="cam-wrap clearfix cam-page-sub-title cam-recessed-sub-title">
        <div class="cam-column">
            <div class="cam-content-container">
                <h1 class="cam-sub-title">
                    修改密码 Change password
                </h1>
            </div>
        </div>
    </div>
</div>
<div class="cam-content cam-recessed-content">
    <div class="cam-wrap clearfix">
        <div class="index-content">
            <?php $form=$this->beginWidget('CActiveForm', array(
                'id'=>'setting-form',
                'enableClientValidation'=>true,
                'enableAjaxValidation'=>false,
            )); ?>
            <p>您当前登录的用户是：<?php echo Yii::app()->user->name; ?>，</p>
            <p style="margin-bottom: 10px">请输入原密码和需要设置的新密码。</p>
            <div class="row">
                <div class="columns" style="width: 320px;">
                    <?php echo $form->labelEx($model,'old_password'); ?>
                    <?php echo $form->passwordField($model,'old_password',array('size'=>60,'maxlength'=>128,'class'=>'pwd_pro_input')); ?>
                    <?php echo $form->error($model,'old_password'); ?>
                </div>
                <div class="clearfix"></div>
            </div>

            <div class="row">
                <div class="columns" style="width: 320px;">
                    <?php echo $form->labelEx($model,'new_password'); ?>
                    <?php echo $form->passwordField($model,'new_password',array('size'=>60,'maxlength'=>128,'class'=>'pwd_pro_input')); ?>
                    <?php echo $form->error($model,'new_password'); ?>
                </div>
                <div class="clearfix"></div>
            </div>

            <div class="row">
                <div class="columns" style="width: 320px;">
                    <?php echo $form->labelEx($model,'repeat_password'); ?>
                    <?php echo $form->passwordField($model,'repeat_password',array('size'=>60,'maxlength'=>128,'class'=>'pwd_pro_input')); ?>
                    <?php echo $form->error($model,'repeat_password'); ?>
                </div>
                <div class="clearfix"></div>
            </div>
            <br/>

            <div class="row buttons">
                <?php echo CHtml::submitButton('提交',array('class'=>'btn btn-default')); ?>
                &nbsp;
                <input type="button" value="取消" class="btn btn-default" onclick="location='./index.php'"/>
                &nbsp;
                <?php echo empty($msg) ? '' : $msg; ?>
                <div class="clearfix"></div>
            </div>

            <?php $this->endWidget(); ?>
        </div>
    </div>
</div>
