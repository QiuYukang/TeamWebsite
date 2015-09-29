<?php
/* @var $this PublicationController */
/* @var $model Publication */


//面包屑
$this->breadcrumbs=array(
    '学术成果'=>array('paper/index'),
    '著作'=>array('index'),
    '管理'=>array('admin'),
    substr($model->info, 0, 30).'...',
);
?>

<div style="position:relative">
    <img src="images/lang1.jpg" alt="" />
    <div style="position:absolute;z-indent:2;left:0;top:0;">
        <br>
        <h2>著作详细</h2>
        <h4><?php echo substr($model->info, 0, 30).'...'; ?></h4>
    </div>
</div>

<br>
<?php
echo '<div class="errorMessage">'.$model->getIncompleteInfo().'</div>';
?>
<br>
<?php $this->widget('zii.widgets.CDetailView', array(
    'data'=>$model,
    'attributes'=>array(
        'info',
        'press',
        'isbn_number',
        array(
            'label'=>'作者',
            'type'=>'raw',
            'value'=>$model->getAuthorsWithLink() != '' ? $model->getAuthorsWithLink() : null,
        ),
        array(
            'label'=>'类别',
            'type'=>'raw',
            'value'=>$model->getCategoryString() != '' ? $model->getCategoryString() : null,
        ),
        'pub_date',
        array(
            'label'=>'支助项目',
            'type'=>'raw',
            'value'=>$model->getProjectsWithLink(Paper::PROJECT_FUND) != '' ?
                $model->getProjectsWithLink(Paper::PROJECT_FUND) :
                null,
        ),
        array(
            'label'=>'报账项目',
            'type'=>'raw',
            'value'=>$model->getProjectsWithLink(Paper::PROJECT_REIM) != '' ?
                $model->getProjectsWithLink(Paper::PROJECT_REIM) :
                null,
        ),
        array(
            'label'=>'成果项目',
            'type'=>'raw',
            'value'=>$model->getProjectsWithLink(Paper::PROJECT_ACHIEVEMENT) != '' ?
                $model->getProjectsWithLink(Paper::PROJECT_ACHIEVEMENT) :
                null,
        ),
        'description',
        'last_update_date',
    ),
)); ?>
<hr/>

<?php
//删除必须使用POST提交，这里写一个表单
//admin manager用户才能编辑、删除
$user = Yii::app()->user;
?>
<form name="operate" action="<?php echo Yii::app()->controller->createUrl("delete",array("id"=>$model->id)); ?>" method="post" onsubmit="return firm()">
    <?php if(isset($user->is_admin) && $user->is_admin || isset($user->is_manager) && $user->is_manager) { ?>
        <input type="button" value="编辑" class="btn btn-default" onclick="location='<?php echo Yii::app()->controller->createUrl("update",array("id"=>$model->id)); ?>'"/>
        <input type="submit" class="btn btn-default" id="drop"  value="删除"/>
    <?php } ?>
    <input type="button" class="btn btn-default" value="返回" onclick="location='<?php echo Yii::app()->controller->createUrl("admin"); ?>'"/>
</form>

<script>
    function firm() {
        if(confirm("您确定要删除这篇著作吗？")) {
            location.href = '<?php echo Yii::app()->controller->createUrl("delete",array("id"=>$model->id)); ?>';
            return true;
        }

        else {
            return false;
        }
    }
</script>

<?php
//echo CHtml::link('编辑', Yii::app()->controller->createUrl("update",array("id"=>$model->id)), array('class' => 'search-button button small radius'));
//echo '&nbsp;&nbsp;';
//echo CHtml::ajaxSubmitButton('删除', Yii::app()->controller->createUrl("delete",array("id"=>$model->id)), null, array('class' => 'search-button button small radius'));
////echo CHtml::link('删除', 'index.php?r=paper/delete&id='.$model->id, array('class' => 'search-button button small radius'));
//
?>

<!-- <table class="detail-view" id="detail_view">

</table> -->