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

//面包屑
$this->breadcrumbs=array(
    '学术成果'=>array('paper/index'),
	'论文'=>array('index'),
    '管理'=>array('admin'),
    substr($model->info, 0, 30).'...'=>array('view','id'=>$model->id),
	'编辑',
);

?>

<div style="position:relative">
    <img src="images/lang1.jpg" alt="" />
    <div style="position:absolute;z-indent:2;left:0;top:0;">
        <br>
        <h2>编辑论文</h2>
        <h4><?php echo substr($model->info, 0, 30).'...'; ?></h4>
    </div>
</div>


<?php $this->renderPartial('_form', array('model'=>$model)); ?>
