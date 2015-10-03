<?php
/* @var $this UserController */
/* @var $model User */

//面包屑
$this->breadcrumbs=array(
    '用户管理'=>array('user/admin'),
    '添加',
);

?>

<div style="position:relative">
    <img src="images/lang1.jpg" alt="" />
    <div style="position:absolute;z-indent:2;left:0;top:0;">
        <br>
        <h2>添加用户</h2>
    </div>
</div>


<?php $this->renderPartial('_form', array('model'=>$model)); ?>
