<?php
/* @var $this ProjectController */
/* @var $model Project */


$this->pageTitle=Yii::app()->name . ' - 编辑科研项目';
//面包屑
$this->breadcrumbs=array(
    '科研'=>array('project/index'),
    '科研项目'=>array('index'),
    '管理'=>array('admin'),
    substr($model->name, 0, 30).'...'=>array('view','id'=>$model->id),
    '编辑',
);

?>

<div class="cam-page-header">
    <div class="cam-wrap clearfix cam-local-navigation">
        <ul class="cam-unstyled-list cam-current">
            <li><a href="index.php?r=site/introduction">团队介绍</a></li>
            <li><a href="index.php?r=site/direction">研究方向</a></li>
            <li class="cam-current-page"><a href="index.php?r=project/admin" class="active-trail">科研项目</a></li>
            <li><a href="#">科研成果</a></li>
        </ul>
    </div>
    <div class="cam-wrap clearfix cam-page-sub-title cam-recessed-sub-title">
        <div class="cam-column">
            <div class="cam-content-container">
                <h1 class="cam-sub-title">
                    编辑科研项目 Edit project
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