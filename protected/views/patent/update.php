<?php
/* @var $this PatentController */
/* @var $model Patent */

//面包屑
$this->breadcrumbs=array(
    '学术成果'=>array('paper/index'),
    '专利'=>array('index'),
    '管理'=>array('admin'),
    substr($model->name, 0, 30).'...'=>array('view','id'=>$model->id),
    '编辑',
);

?>

<div style="position:relative">
    <img src="images/lang1.jpg" alt="" />
    <div style="position:absolute;z-indent:2;left:0;top:0;">
        <br>
        <h2>编辑专利</h2>
        <h4><?php echo substr($model->name, 0, 30).'...'; ?></h4>
    </div>
</div>


<?php $this->renderPartial('_form', array('model'=>$model)); ?>
