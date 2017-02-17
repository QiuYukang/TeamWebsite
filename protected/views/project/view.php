<?php
/* @var $this ProjectController */
/* @var $model Project */

$this->pageTitle=Yii::app()->name . ' - 科研项目详情';
//面包屑
$this->breadcrumbs=array(
    '科研'=>array('project/index'),
    '科研项目'=>array('index'),
    '管理'=>array('admin'),
    substr($model->name, 0, 30).'...',
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
                    科研项目详情 Project details
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
                    'fund_number',
                    'level',
                    'category',
                    'unit',
                    'fund',
                    'start_date',
                    'deadline_date',
                    'conclude_date',
                    array(
                        'label'=>'实际执行人员',
                        'type'=>'raw',
                        'value'=>$model->getAuthorsWithLink(Project::PEOPLE_EXECUTE),
                    ),
                    array(
                        'label'=>'合同书人员',
                        'type'=>'raw',
                        'value'=>$model->getAuthorsWithLink(Project::PEOPLE_LIABILITY),
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
            ));
            //var_dump($model->execute_peoples);
            ?>
            <br/>
            <?php $this->widget('zii.widgets.CDetailView', array(
                'data'=>$model,
                'attributes'=>array(
                    array(
                        'label'=>'以其支助的论文',
                        'type'=>'raw',
                        'value'=>$model->getPapersWithLink(Project::PAPER_FUND) ? $model->getPapersWithLink(Project::PAPER_FUND) : '无',
                    ),
                    array(
                        'label'=>'以其报账的论文',
                        'type'=>'raw',
                        'value'=>$model->getPapersWithLink(Project::PAPER_REIM) ? $model->getPapersWithLink(Project::PAPER_REIM) : '无',
                    ),
                    array(
                        'label'=>'以其成果的论文',
                        'type'=>'raw',
                        'value'=>$model->getPapersWithLink(Project::PAPER_ACHIEVEMENT) ? $model->getPapersWithLink(Project::PAPER_ACHIEVEMENT) : '无',
                    ),
                    array(
                        'label'=>'以其报账的专利',
                        'type'=>'raw',
                        'value'=>$model->getPatentsWithLink(Project::PATENT_REIM) ? $model->getPatentsWithLink(Project::PATENT_REIM) : '无',
                    ),
                    array(
                        'label'=>'以其成果的专利',
                        'type'=>'raw',
                        'value'=>$model->getPatentsWithLink(Project::PATENT_ACHIEVEMENT) ? $model->getPatentsWithLink(Project::PATENT_ACHIEVEMENT) : '无',
                    ),
                    array(
                        'label'=>'以其支助的著作',
                        'type'=>'raw',
                        'value'=>$model->getPublicationsWithLink(Project::PUBLICATION_FUND) ? $model->getPublicationsWithLink(Project::PUBLICATION_FUND) : '无',
                    ),
                    array(
                        'label'=>'以其报账的著作',
                        'type'=>'raw',
                        'value'=>$model->getPublicationsWithLink(Project::PUBLICATION_REIM) ? $model->getPublicationsWithLink(Project::PUBLICATION_REIM) : '无'
                    ),
                    array(
                        'label'=>'以其成果的著作',
                        'type'=>'raw',
                        'value'=>$model->getPublicationsWithLink(Project::PUBLICATION_ACHIEVEMENT) ? $model->getPublicationsWithLink(Project::PUBLICATION_ACHIEVEMENT) : '无',
                    ),
                    array(
                        'label'=>'以其支助的软件著作权',
                        'type'=>'raw',
                        'value'=>$model->getSoftwaresWithLink(Project::SOFTWARE_FUND) ? $model->getSoftwaresWithLink(Project::SOFTWARE_FUND) : '无',
                    ),
                    array(
                        'label'=>'以其报账的软件著作权',
                        'type'=>'raw',
                        'value'=>$model->getSoftwaresWithLink(Project::SOFTWARE_REIM) ? $model->getSoftwaresWithLink(Project::SOFTWARE_REIM) : '无',
                    ),
                    array(
                        'label'=>'以其成果的软件著作权',
                        'type'=>'raw',
                        'value'=>$model->getSoftwaresWithLink(Project::SOFTWARE_ACHIEVEMENT) ? $model->getSoftwaresWithLink(Project::SOFTWARE_ACHIEVEMENT) : '无',
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
        if(confirm("您确定要删除这个科研项目吗？")) {
            location.href = '<?php echo Yii::app()->controller->createUrl("delete",array("id"=>$model->id)); ?>';
            return true;
        }

        else {
            return false;
        }
    }
</script>


