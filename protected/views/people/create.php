<?php
/* @var $this PeopleController */
/* @var $model People */

$this->pageTitle=Yii::app()->name . ' - 添加团队成员';
//面包屑
$this->breadcrumbs=array(
    '团队成员'=>array('people/admin'),
    '添加',
);

?>

<div class="cam-page-header">
    <div class="cam-wrap clearfix cam-page-sub-title cam-recessed-sub-title">
        <div class="cam-column">
            <div class="cam-content-container">
                <h1 class="cam-sub-title">
                    添加团队成员 Add team member
                </h1>
            </div>
        </div>
    </div>
</div>
<div class="cam-content cam-recessed-content">
    <div class="cam-wrap clearfix">
        <div class="index-content">
            <?php $this->renderPartial('_form', array('model'=>$model)); ?>
        </div>
    </div>
</div>
