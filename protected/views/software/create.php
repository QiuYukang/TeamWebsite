<?php
/* @var $this SoftwareController */
/* @var $model Software */

//面包屑
$this->breadcrumbs=array(
    '学术成果'=>array('paper/index'),
    '软件著作权'=>array('index'),
    '管理'=>array('admin'),
    '添加',
);

?>

    <div style="position:relative">
        <img src="images/lang1.jpg" alt="" />
        <div style="position:absolute;z-indent:2;left:0;top:0;">
            <br>
            <h2>添加软件著作权</h2>
        </div>
    </div>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>