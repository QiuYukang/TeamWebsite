<?php
/* @var $this PatentController */
/* @var $model Patent */

$this->pageTitle=Yii::app()->name . ' - 专利详情';
//面包屑
$this->breadcrumbs=array(
    '学术成果'=>array('paper/index'),
    '专利'=>array('index'),
    '管理'=>array('admin'),
    $model->getAbbr(),
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
                    专利详情 Patent details
                </h1>
            </div>
        </div>
    </div>
</div>

<div class="cam-content cam-recessed-content">
    <div class="cam-wrap clearfix">
        <div class="index-content">
            <?php
            echo '<div class="errorMessage">'.$model->getIncompleteInfo().'</div>';
            ?>
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
            <br/>

            <?php
            //删除必须使用POST提交，这里写一个表单
            //admin manager用户才能编辑、删除
            $user = Yii::app()->user;
            ?>
            <form name="operate" action="<?php echo Yii::app()->controller->createUrl("delete",array("id"=>$model->id)); ?>" method="post" onsubmit="return firm()">
                <?php if(isset($user->is_admin) && $user->is_admin || isset($user->is_manager) && $user->is_manager) { ?>
                    <input type="button" value="编辑" class="btn btn-default" onclick="location='<?php echo Yii::app()->controller->createUrl("update",array("id"=>$model->id)); ?>'"/>
                    &nbsp;
                    <input type="submit" class="btn btn-default" id="drop"  value="删除"/>
                    &nbsp;
                <?php } ?>
                <input type="button" class="btn btn-default" value="返回" onclick="location='<?php echo Yii::app()->controller->createUrl("admin"); ?>'"/>
            </form>
        </div>
    </div>
</div>

<script>
    function firm() {
        if(confirm("您确定要删除这项专利吗？")) {
            location.href = '<?php echo Yii::app()->controller->createUrl("delete",array("id"=>$model->id)); ?>';
            return true;
        }

        else {
            return false;
        }
    }
</script>
