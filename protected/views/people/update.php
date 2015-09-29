<?php
/* @var $this PeopleController */
/* @var $model People */

//面包屑
$this->breadcrumbs=array(
    '人员管理'=>array('people/admin'),
    $model->name,
    '编辑',
);

?>

<div style="position:relative">
    <img src="images/lang1.jpg" alt="" />
    <div style="position:absolute;z-indent:2;left:0;top:0;">
        <br>
        <h2>编辑人员</h2>
        <h4><?php echo $model->name; ?></h4>
    </div>
</div>


<?php $this->renderPartial('_form', array('model'=>$model)); ?>
