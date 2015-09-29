<?php
/* @var $this PatentController */
/* @var $model Patent */

//面包屑
$this->breadcrumbs=array(
    '学术成果'=>array('paper/index'),
    '专利'=>array('index'),
    '管理'=>array('admin'),
    mb_substr($model->name, 0, 30).'...',
);
?>

<div style="position:relative">
    <img src="images/lang1.jpg" alt="" />
    <div style="position:absolute;z-indent:2;left:0;top:0;">
        <br>
        <h2>专利详细</h2>
        <h4><?php echo mb_substr($model->name, 0, 30).'...'; ?></h4>
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
        'name',
        'number',
        array(
            'label'=>'发明人',
            'type'=>'raw',
            'value'=>$model->getAuthorsWithLink() != '' ? $model->getAuthorsWithLink() : null,
        ),
        array(
            'label'=>'状态',
            'type'=>'raw',
            'value'=>$model->getStatusString(true) != '' ? $model->getStatusString(true) : null,
        ),
        'level',
        'category',
        'app_date',
        'auth_date',
        array(
            'label'=>'专利文件',
            'type'=>'raw',
            'value'=>
                isset($model->file_name) ?
                    ( isset($model->file_content) ? CHtml::link($model->file_name,array('download','id'=>$model->primaryKey)) : CHtml::encode($model->file_name.'  (未上传文件)') )
                    : null,
        ),
        array(
            'label'=>'报账项目',
            'type'=>'raw',
            'value'=>$model->getProjectsWithLink(Patent::PROJECT_REIM) != '' ?
                $model->getProjectsWithLink(Patent::PROJECT_REIM) :
                null,
        ),
        array(
            'label'=>'成果项目',
            'type'=>'raw',
            'value'=>$model->getProjectsWithLink(Patent::PROJECT_ACHIEVEMENT) != '' ?
                $model->getProjectsWithLink(Patent::PROJECT_ACHIEVEMENT) :
                null,
        ),
        'abstract',
        array(
            'label'=>'维护人员',
            'type'=>'raw',
            'value'=>
                isset($model->maintainer) ?
                    CHtml::link(CHtml::encode($model->maintainer->name), array('people/view', 'id'=>$model->maintainer->id)) :
                    null,
        ),
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
        if(confirm("您确定要删除这篇专利吗？")) {
            location.href = '<?php echo Yii::app()->controller->createUrl("delete",array("id"=>$model->id)); ?>';
            return true;
        }

        else {
            return false;
        }
    }
</script>
