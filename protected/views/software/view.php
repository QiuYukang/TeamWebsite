<?php
/* @var $this SoftwareController */
/* @var $model Software */

$this->pageTitle=Yii::app()->name . ' - 软件著作权详情';
//面包屑
$this->breadcrumbs=array(
    '学术成果'=>array('paper/index'),
    '软件著作权'=>array('index'),
    '管理'=>array('admin'),
    substr($model->name, 0, 30).'...',
);
?>


<div class="cam-page-header">
    <div class="cam-wrap clearfix cam-local-navigation">
        <ul class="cam-unstyled-list cam-current">
            <li><a href="index.php?r=paper/admin">论文</a></li>
            <li><a href="index.php?r=patent/admin">专利</a></li>
            <li><a href="index.php?r=publication/admin">著作</a></li>
            <li class="cam-current-page"><a href="index.php?r=software/admin" class="active-trail">软件著作权</a></li>
        </ul>
    </div>
    <div class="cam-wrap clearfix cam-page-sub-title cam-recessed-sub-title">
        <div class="cam-column">
            <div class="cam-content-container">
                <h1 class="cam-sub-title">
                    软件著作权详情 Software Copyright details
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
                    'reg_number',
                    array(
                        'label'=>'作者',
                        'type'=>'raw',
                        'value'=>$model->getAuthorsWithLink() != '' ? $model->getAuthorsWithLink() : null,
                    ),
                    'reg_date',
                    array(
                        'label'=>'软件著作权资料',
                        'type'=>'raw',
                        'value'=>
                            isset($model->file_name) ?
                                ( isset($model->file_content) ? CHtml::link($model->file_name,array('download','id'=>$model->primaryKey)) : CHtml::encode($model->file_name.'  (未上传文件)') )
                                : null,
                    ),
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
        if(confirm("您确定要删除这篇软件著作权吗？")) {
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
