<?php

//面包屑
$this->breadcrumbs=array(
    '修改密码'=>array('user/setting'),
    Yii::app()->user->name,
);

?>

<div style="position:relative">
    <img src="images/lang1.jpg" alt="" />
    <div style="position:absolute;z-indent:2;left:0;top:0;">
        <br>
        <h2>修改密码</h2>
        <h4><?php echo Yii::app()->user->name; ?></h4>
    </div>
</div>

<br/>


<?php
$authStrArr=null;
if(isset(Yii::app()->user->is_user) && Yii::app()->user->is_user) {
    $authStrArr = '普通用户';
}
if(isset(Yii::app()->user->is_manager) && Yii::app()->user->is_manager) {
    $authStrArr = '管理员';
}
if(isset(Yii::app()->user->is_admin) && Yii::app()->user->is_admin) {
    $authStrArr = '超级管理员';
}
?>

<br/>

<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'setting-form',
    'enableClientValidation'=>true,
    'enableAjaxValidation'=>false,
)); ?>


<?php //echo $form->errorSummary($model); ?>

<div class="row">
    <div class="medium-6 columns end">
        <?php echo $form->labelEx($model,'old_password'); ?>
        <?php echo $form->passwordField($model,'old_password',array('size'=>60,'maxlength'=>128,'class'=>'pwd_pro_input')); ?>
        <?php echo $form->error($model,'old_password'); ?>
    </div>
</div>

<div class="row">
    <div class="medium-6 columns end">
        <?php echo $form->labelEx($model,'new_password'); ?>
        <?php echo $form->passwordField($model,'new_password',array('size'=>60,'maxlength'=>128,'class'=>'pwd_pro_input')); ?>
        <?php echo $form->error($model,'new_password'); ?>
    </div>
</div>

<div class="row">
    <div class="medium-6 columns end">
        <?php echo $form->labelEx($model,'repeat_password'); ?>
        <?php echo $form->passwordField($model,'repeat_password',array('size'=>60,'maxlength'=>128,'class'=>'pwd_pro_input')); ?>
        <?php echo $form->error($model,'repeat_password'); ?>
    </div>
</div>

<br/>

<div class="buttons">
    <?php echo CHtml::submitButton('修改密码',array('class'=>'btn btn-default')); ?>&nbsp;&nbsp;&nbsp;<?php echo empty($msg) ? '' : $msg; ?>
</div>

<hr/>

<?php $this->endWidget(); ?>


<!---->
<!--<div class="form">-->
<!--    <form id="setting_form" method="post" action="index.php?r=user/setting">-->
<!---->
<!--        <!--	<p class="note">Fields with <span class="required">*</span> are required.</p>-->
<!--        --><?php
//        //        echo $form->errorSummary($model);  //提示所有错误
//        ?>
<!---->
<!--        <br/>-->
<!---->
<!--        <div class="row">-->
<!--            <div class="row">-->
<!--                <div class="medium-4 columns">-->
<!--                    <label for="username">用户名</label>-->
<!--                    <input readonly="readonly" id="username" name="username" type="text" value="--><?php //echo Yii::app()->user->name.' ('.$authStrArr.')'; ?><!--">-->
<!--                </div>-->
<!--                <div class="medium-4 columns end">-->
<!--                    <label for="old_password">密码*</label>-->
<!--                    <input type="password" id="old_password" name="old_password" type="text" placeholder="账户设置需输入账号密码" value="" required="required">-->
<!--                    --><?php //if(isset($errorMessage)) echo "<p>$errorMessage</p>"; ?>
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!---->
<!--        <div class="row">-->
<!--            <div class="row">-->
<!--                <div class="medium-3 columns">-->
<!--                    <label for="password">新密码</label>-->
<!--                    <input type="password" id="password" name="password" type="text" placeholder="若需修改密码在此输入新密码" value="">-->
<!--                </div>-->
<!--                <div class="medium-3 columns">-->
<!--                    <label for="repeat_password">重复密码</label>-->
<!--                    <input type="password" id="repeat_password" name="repeat_password" type="text" placeholder="若需修改密码在此重复输入新密码" value="">-->
<!--                </div>-->
<!--                <div class="medium-2 columns end">-->
<!--                    <label for="email">邮箱</label>-->
<!--                    <input id="email" name="email" type="text" placeholder="填写邮箱" value="--><?php //echo User::model()->findByAttributes(array('id' => Yii::app()->user->id))->email; ?><!--">-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!---->
<!--        <br/>-->
<!---->
<!--        <div class="row buttons">-->
<!--            <input type="submit" class="btn btn-default" value="保存设置"/>-->
<!--        </div>-->
<!---->
<!--        <hr/>-->
<!---->
<!--    </form>-->
<!--</div><!-- form -->


<!--<div style="width: 40%;margin:0 auto;">-->
<!---->
<!--    <form class="form-signin">-->
<!--        <h5 class="form-signin-heading">用户名：--><?php //echo Yii::app()->user->name;  ?><!--</h5>-->
<!---->
<!--        <label for="inputPassword" class="sr-only">Password</label>-->
<!--        <h5 class="form-signin-heading">原密码：</h5><input type="password" id="inputPassword" class="form-control" placeholder="旧密码" required>-->
<!--        <input type="password" id="inputPassword" class="form-control" placeholder="新密码" required>-->
<!--        <input type="password" id="inputPassword" class="form-control" placeholder="二次新密码" required>-->
<!--        <label for="inputEmail" class="sr-only">Email address</label>-->
<!--        <input type="email" id="inputEmail" class="form-control" placeholder="您的email" required autofocus>-->
<!--        <div class='btn-group' style="text-align: center">-->
<!---->
<!--            <a class='btn'>权限</a>-->
<!---->
<!--            <a class='btn dropdown-toggle' data-toggle='dropdown' href='javascript:;'><span class='caret'></span></a>-->
<!---->
<!--            <ul class='dropdown-menu'>-->
<!---->
<!--                <li><a href='javascript:;'>item1</a></li>-->
<!---->
<!--                <li><a href='javascript:;'>item2</a></li>-->
<!---->
<!--                <li><a href='javascript:;'>item3</a></li>-->
<!---->
<!--            </ul>-->
<!---->
<!--        </div>-->
<!--        <div class="checkbox">-->
<!--            <label>-->
<!--                <input type="checkbox" value="remember-me"> Remember me-->
<!--            </label>-->
<!--        </div>-->
<!--        <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>-->
<!--    </form>-->
<!---->
<!--</div> <!-- /container -->
