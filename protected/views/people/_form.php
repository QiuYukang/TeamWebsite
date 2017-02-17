<?php
/* @var $this PeopleController */
/* @var $model People */
/* @var $form CActiveForm */
?>

<?php
$peoples = People::model()->findAllBySql('SELECT * FROM `tbl_people` ORDER BY `position` DESC, CONVERT( `name` USING gbk );'); //先以职位排序，在以汉字首字母顺序排序
$projects = Project::model()->findAllBySql('SELECT * FROM `tbl_project` ORDER BY latest_date DESC;'); //以最新时间顺序排序
?>

<div class="form">
    <?php
    $form = $this->beginWidget('CActiveForm',
        array(
            'id'=>'people-form',
            // Please note: When you enable ajax validation, make sure the corresponding
            // controller action is handling ajax validation correctly.
            // There is a call to performAjaxValidation() commented in generated controller code.
            // See class documentation of CActiveForm for details on this.
//                'enableAjaxValidation'=>false,
            'htmlOptions' => array(
                'method' => 'post',
                'enctype' => 'multipart/form-data' //上传文件会用到
            ),
        )); ?>

    <!--	<p class="note">Fields with <span class="required">*</span> are required.</p>-->
    <?php
    //        echo $form->errorSummary($model);  //提示所有错误
    ?>

    <div class="row">
        <div class="columns" style="width: 120px">
            <?php echo $form->labelEx($model,'name'); ?>
            <?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
            <?php echo $form->error($model,'name'); ?>
        </div>
        <div class="columns" style="width: 160px">
            <?php echo $form->labelEx($model,'name_en'); ?>
            <?php echo $form->textField($model,'name_en',array('size'=>60,'maxlength'=>255)); ?>
            <?php echo $form->error($model,'name_en'); ?>
        </div>
        <div class="columns" style="width: 260px">
            <?php echo $form->labelEx($model,'number'); ?>
            <?php echo $form->textField($model,'number',array('size'=>60,'maxlength'=>255)); ?>
            <?php echo $form->error($model,'number'); ?>
        </div>
        <div class="clearfix"></div>
    </div>

    <div class="row">
        <div class="columns" style="width: 400px">
            <?php echo $form->labelEx($model,'email'); ?>
            <?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>255)); ?>
            <?php echo $form->error($model,'email'); ?>
        </div>

        <div class="columns" style="width: 150px">
            <?php echo $form->labelEx($model,'position'); ?>
            <?php echo $form->dropDownList(
                $model,'position',
                array(1 => $model::LABEL_TEACHER, 0 => $model::LABEL_STUDENT, -1 => $model::LABEL_PARTNER),
                array('style'=>'width: 100%;')); ?>
            <?php echo $form->error($model,'position'); ?>
        </div>
        <div class="clearfix"></div>
    </div>


    <div class="row">
        <div class="columns" style="width: 100%; margin-top: 10px">
            <?php
            //依model是否为新对象判断该表单用于创建还是编辑，使用不同的按钮和返回URL
            echo CHtml::submitButton(
                $model->isNewRecord ? '添加' : '保存',
                array('class' => 'btn btn-default')
            ); ?>
            &nbsp;
            <input type="button" value="返回" class="btn btn-default" onclick="location='<?php echo $model->isNewRecord ? Yii::app()->controller->createUrl("admin") : Yii::app()->controller->createUrl("view",array("id"=>$model->id)); ?>'"/>
        </div>
        <div class="clearfix"></div>
    </div>

    <?php $this->endWidget(); ?>


    <script type="text/javascript">
        //阻止textarea文本域中回车键换行
        $(document).ready(function() {
            $("textarea").keydown(function(e) {
                if (e.keyCode == 13) {
                    e.preventDefault();
                }
            });


        });
        //下拉框搜索
        $('select').select2();
    </script>

</div><!-- form -->
