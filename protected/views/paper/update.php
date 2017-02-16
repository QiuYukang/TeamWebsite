<?php
/* @var $this PaperController */
/* @var $model Paper */

//已废弃，菜单用前台完成
//$this->menu=array(
//    array('label'=>'列出论文', 'url'=>array('index')),
//    array('label'=>'创建论文', 'url'=>array('create')),
//    array('label'=>'查看论文', 'url'=>array('view', 'id'=>$model->id)),
//    array('label'=>'管理论文', 'url'=>array('admin')),
//    array('label'=>'导入论文', 'url'=>array('upload')),
//    array('label'=>'导出全部论文', 'url'=>array('exportAll')),
//);

$this->pageTitle=Yii::app()->name . ' - 编辑论文';
//面包屑
$this->breadcrumbs=array(
    '学术成果'=>array('paper/index'),
	'论文'=>array('index'),
    '管理'=>array('admin'),
    substr($model->info, 0, 30).'...'=>array('view','id'=>$model->id),
	'编辑',
);

?>

<div class="cam-page-header">
    <div class="cam-wrap clearfix cam-local-navigation">
        <ul class="cam-unstyled-list cam-current">
            <li class="cam-current-page"><a href="index.php?r=paper/admin" class="active-trail">论文</a></li>
            <li><a href="index.php?r=patent/admin">专利</a></li>
            <li><a href="index.php?r=publication/admin">著作</a></li>
            <li><a href="index.php?r=software/admin">软件著作权</a></li>
        </ul>
    </div>
    <div class="cam-wrap clearfix cam-page-sub-title cam-recessed-sub-title">
        <div class="cam-column">
            <div class="cam-content-container">
                <h1 class="cam-sub-title">
                    编辑论文 Edit paper
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

