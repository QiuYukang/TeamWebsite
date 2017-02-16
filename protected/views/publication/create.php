<?php
/* @var $this PublicationController */
/* @var $model Publication */

//面包屑
$this->pageTitle=Yii::app()->name . ' - 添加著作';
$this->breadcrumbs=array(
    '学术成果'=>array('paper/index'),
    '著作'=>array('index'),
    '管理'=>array('admin'),
    '添加',
);

?>

<div class="cam-page-header">
    <div class="cam-wrap clearfix cam-local-navigation">
        <ul class="cam-unstyled-list cam-current">
            <li><a href="index.php?r=paper/admin">论文</a></li>
            <li><a href="index.php?r=patent/admin">专利</a></li>
            <li class="cam-current-page"><a href="index.php?r=publication/admin" class="active-trail">著作</a></li>
            <li><a href="index.php?r=software/admin">软件著作权</a></li>
        </ul>
    </div>
    <div class="cam-wrap clearfix cam-page-sub-title cam-recessed-sub-title">
        <div class="cam-column">
            <div class="cam-content-container">
                <h1 class="cam-sub-title">
                    添加著作 Add publication
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