<?php
/* @var $this PeopleController */
/* @var $model People */

$this->pageTitle=Yii::app()->name . ' - 团队成员详情';
//面包屑
$this->breadcrumbs=array(
    '团队成员'=>array('people/admin'),
    $model->name,
);
?>

<div class="cam-page-header">
    <div class="cam-wrap clearfix cam-page-sub-title cam-recessed-sub-title">
        <div class="cam-column">
            <div class="cam-content-container">
                <h1 class="cam-sub-title">
                    团队成员详情 Team member details
                </h1>
            </div>
        </div>
    </div>
</div>

<div class="cam-content cam-recessed-content">
    <div class="cam-wrap clearfix">
        <div class="index-content">
            <?php $this->widget('zii.widgets.CDetailView', array(
                'data'=>$model,
                'attributes'=>array(
                    'name',
                    'name_en',
                    'number',
                    'email',
                    array(
                        'label'=>'身份',
                        'type'=>'raw',
                        'value'=>$model->getPosition(),
                    ),
                    'last_update_date'
                )
            ));
            ?>
            <br/>
            <?php $this->widget('zii.widgets.CDetailView', array(
                'data'=>$model,
                'attributes'=>array(
                    array(
                        'label'=>'论文',
                        'type'=>'raw',
                        'value'=>$model->getPapersWithLink() ? $model->getPapersWithLink() : '无',
                    ),
                    array(
                        'label'=>'专利',
                        'type'=>'raw',
                        'value'=>$model->getPatentsWithLink() ? $model->getPatentsWithLink() : '无',
                    ),
                    array(
                        'label'=>'著作',
                        'type'=>'raw',
                        'value'=>$model->getPublicationsWithLink() ? $model->getPublicationsWithLink() : '无',
                    ),
                    array(
                        'label'=>'软件著作权',
                        'type'=>'raw',
                        'value'=>$model->getSoftwaresWithLink() ? $model->getSoftwaresWithLink() : '无',
                    ),
                    array(
                        'label'=>'作为执行人员的项目',
                        'type'=>'raw',
                        'value'=>$model->getProjectsWithLink(People::PROJECT_EXECUTE) ? $model->getProjectsWithLink(People::PROJECT_EXECUTE) : '无',
                    ),
                    array(
                        'label'=>'作为合同书人员的项目',
                        'type'=>'raw',
                        'value'=>$model->getProjectsWithLink(People::PROJECT_LIABILITY) ? $model->getProjectsWithLink(People::PROJECT_LIABILITY) : '无',
                    ),
                ),
            ));

            //var_dump($model->execute_peoples);
            ?>
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
        if(confirm("您确定要删除这个成员吗？")) {
            location.href = '<?php echo Yii::app()->controller->createUrl("delete",array("id"=>$model->id)); ?>';
            return true;
        }

        else {
            return false;
        }
    }
</script>
