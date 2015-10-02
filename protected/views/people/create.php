<?php
/* @var $this PeopleController */
/* @var $model People */

//面包屑
$this->breadcrumbs=array(
    '团队人员'=>array('people/admin'),
    '添加',
);

?>

    <div style="position:relative">
        <img src="images/lang1.jpg" alt="" />
        <div style="position:absolute;z-indent:2;left:0;top:0;">
            <br>
            <h2>添加人员</h2>
        </div>
    </div>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>