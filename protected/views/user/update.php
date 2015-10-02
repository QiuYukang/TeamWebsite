<?php
/* @var $this UserController */
/* @var $model User */

//面包屑
$this->breadcrumbs=array(
    '用户管理'=>array('user/admin'),
    $model->username,
);

?>

<div style="position:relative">
    <img src="images/lang1.jpg" alt="" />
    <div style="position:absolute;z-indent:2;left:0;top:0;">
        <br>
        <h2>修改或删除用户</h2>
        <h4><?php echo $model->username; ?></h4>
    </div>
</div>


<?php $this->renderPartial('_form', array('model'=>$model)); ?>
