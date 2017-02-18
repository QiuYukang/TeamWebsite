<?php
/* @var $this PatentController */
/* @var $model Patent */

$this->pageTitle=Yii::app()->name . ' - 编辑专利';
//面包屑
$this->breadcrumbs=array(
    '学术成果'=>array('paper/index'),
    '专利'=>array('index'),
    '管理'=>array('admin'),
    iconv_substr($model->name, 0, 30, "UTF-8").'...'=>array('view','id'=>$model->id),
    '编辑',
);

?>

<div class="cam-page-header">
    <div class="cam-wrap clearfix cam-local-navigation">
        <ul class="cam-unstyled-list cam-current">
            <li><a href="index.php?r=paper/admin">论文</a></li>
            <li class="cam-current-page"><a href="index.php?r=patent/admin" class="active-trail">专利</a></li>
            <li><a href="index.php?r=publication/admin">著作</a></li>
            <li><a href="index.php?r=software/admin">软件著作权</a></li>
        </ul>
    </div>
    <div class="cam-wrap clearfix cam-page-sub-title cam-recessed-sub-title">
        <div class="cam-column">
            <div class="cam-content-container">
                <h1 class="cam-sub-title">
                    编辑专利 Edit patent
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