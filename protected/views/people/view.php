<?php
/* @var $this PeopleController */
/* @var $model People */

//面包屑
$this->breadcrumbs=array(
    '人员管理'=>array('people/admin'),
    $model->name,
);
?>

<div style="position:relative">
    <img src="images/lang1.jpg" alt="" />
    <div style="position:absolute;z-indent:2;left:0;top:0;">
        <br>
        <h2>人员详细</h2>
        <h4><?php echo $model->name; ?></h4>
    </div>
</div>

<br>
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

<div class="view-more-information" style="display:none">
    <br/>
    <h4>更多信息</h4>
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
                'label'=>'专著',
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
</div>

<hr/>

<?php
//删除必须使用POST提交，这里写一个表单
//admin manager用户才能编辑、删除
$user = Yii::app()->user;
?>
<form name="operate" action="<?php echo Yii::app()->controller->createUrl("delete",array("id"=>$model->id)); ?>" method="post" onsubmit="return firm()">
    <input type="button" value="更多" class="btn btn-default" onclick="$('.view-more-information').toggle();"/>
    <?php if(isset($user->is_admin) && $user->is_admin || isset($user->is_manager) && $user->is_manager) { ?>
        <input type="button" value="编辑" class="btn btn-default" onclick="location='<?php echo Yii::app()->controller->createUrl("update",array("id"=>$model->id)); ?>'"/>
        <input type="submit" class="btn btn-default" id="drop"  value="删除"/>
    <?php } ?>
    <input type="button" class="btn btn-default" value="返回" onclick="location='<?php echo Yii::app()->controller->createUrl("admin"); ?>'"/>
</form>

<script>
    function firm() {
        if(confirm("您确定要删除这个人员吗？")) {
            location.href = '<?php echo Yii::app()->controller->createUrl("delete",array("id"=>$model->id)); ?>';
            return true;
        }

        else {
            return false;
        }
    }
</script>
