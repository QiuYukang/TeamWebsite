<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - 登录';
$this->breadcrumbs=array(
	'登录',
);
?>

<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'login-form',
    'enableClientValidation'=>true,
    'clientOptions'=>array(
        'validateOnSubmit'=>true,
    ),
)); ?>

<div class="top_div"></div>
<div style="background: rgb(255, 255, 255); margin: -120px auto 320px; border: 1px solid rgb(231, 231, 231); border-image: none; width: 400px; text-align: center;">
    <div style="width: 165px; height: 96px; position: absolute;">
        <div class="tou"></div>
        <div class="initial_left_hand" id="left_hand"></div>
        <div class="initial_right_hand" id="right_hand"></div>
    </div>
    <div class="login-username" style="padding: 30px 0 0 0; position: relative;">
        <?php echo $form->labelEx($model,'username'); ?>
        <?php echo $form->textField($model,'username'); ?>
        <?php echo $form->error($model,'username'); ?>
    </div>
    <div class="login-password" style="position: relative;">
        <?php echo $form->labelEx($model,'password'); ?>
        <?php echo $form->passwordField($model,'password'); ?>
        <?php echo $form->error($model,'password'); ?>
    </div>
    <div class="login-remember" style="position: relative;">
        <?php echo $form->checkBox($model,'rememberMe'); ?>
        <?php echo $form->label($model,'rememberMe'); ?>
        <?php echo $form->error($model,'rememberMe'); ?>
    </div>
    <div style="margin-top: 10px; border-top-color: rgb(231, 231, 231); border-top-width: 1px; border-top-style: solid;">
        <div style="margin: 10px 35px 10px 45px;">
            <span style="float: left; color: rgb(204, 204, 204); font-size: 14px; line-height: 34px;">
                没有用户？请向团队导师询问</span>
            <span style="float: right;">
                <?php echo CHtml::submitButton('登录',array('style'=>'background: #28828a; padding: 7px 20px; border-radius: 4px; border: 1px solid rgb(26, 117, 152); color: #fff; cursor: pointer;')); ?>
            </span>
            <div class="clearfix"></div>
        </div>
    </div>
</div>
<div class="clearfix"></div>

<?php $this->endWidget(); ?>
<script type="text/javascript">
    $(function(){
        //得到焦点
        $("#LoginForm_password").focus(function(){
            $("#left_hand").animate({
                left: "150",
                top: " -38"
            },{step: function(){
                if(parseInt($("#left_hand").css("left"))>140){
                    $("#left_hand").attr("class","left_hand");
                }
            }}, 2000);
            $("#right_hand").animate({
                right: "-64",
                top: "-38px"
            },{step: function(){
                if(parseInt($("#right_hand").css("right"))> -70){
                    $("#right_hand").attr("class","right_hand");
                }
            }}, 2000);
        });
        //失去焦点
        $("#LoginForm_password").blur(function(){
            $("#left_hand").attr("class","initial_left_hand");
            $("#left_hand").attr("style","left:100px;top:-12px;");
            $("#right_hand").attr("class","initial_right_hand");
            $("#right_hand").attr("style","right:-112px;top:-12px");
        });
    });
</script>
