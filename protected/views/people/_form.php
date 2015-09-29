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

        <br/>

        <div class="row">
            <div class="medium-4 columns">
                <?php echo $form->labelEx($model,'name'); ?>
                <?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
                <?php echo $form->error($model,'name'); ?>
            </div>
            <div class="medium-4 columns end">
                <?php echo $form->labelEx($model,'name_en'); ?>
                <?php echo $form->textField($model,'name_en',array('size'=>60,'maxlength'=>255)); ?>
                <?php echo $form->error($model,'name_en'); ?>
            </div>
        </div>

        <div class="row">
            <div class="medium-3 columns">
                <?php echo $form->labelEx($model,'number'); ?>
                <?php echo $form->textField($model,'number',array('size'=>60,'maxlength'=>255)); ?>
                <?php echo $form->error($model,'number'); ?>
            </div>

            <div class="medium-3 columns">
                <?php echo $form->labelEx($model,'email'); ?>
                <?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>255)); ?>
                <?php echo $form->error($model,'email'); ?>
            </div>

            <div class="medium-2 columns end" id="position">
                <?php echo $form->labelEx($model,'position'); ?>
                <?php echo $form->dropDownList(
                    $model,'position',
                    array(1 => $model::LABEL_TEACHER, 0 => $model::LABEL_STUDENT, -1 => $model::LABEL_PARTNER),
                    array()); ?>
                <?php echo $form->error($model,'position'); ?>
            </div>
        </div>

        <br/>

        <div class="row buttons">
            <div class="medium-12 columns end">
                <?php
                //依model是否为新对象判断该表单用于创建还是编辑，使用不同的按钮和返回URL
                echo CHtml::submitButton(
                    $model->isNewRecord ? '添加' : '保存',
                    array('class' => 'btn btn-default')
                ); ?>
                <input type="button" value="返回" class="btn btn-default" onclick="location='<?php echo $model->isNewRecord ? Yii::app()->controller->createUrl("admin") : Yii::app()->controller->createUrl("view",array("id"=>$model->id)); ?>'"/>
            </div>
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
            $('select').select2({
                width: 'resolve'
//                matcher: function(term,text) {
//                    var pinyin = new Pinyin();
//                    var mod=pinyin.getCamelChars(text.toUpperCase());
//                    return mod.indexOf(term.toUpperCase())==0;
//                }
            });

//            function categoryChange() {
//                var obj = document.getElementById("category_list");
//                var text = document.getElementById("category").value;
//
//                $(".category_list").val("").trigger("change");
//                $(".category_list").val(text).trigger("change");
//            }

        </script>


    </div><!-- form -->



<?php
//下拉框搜索相关css和js文件
Yii::app()->getClientScript()->
registerCssFile(yii::app()->request->baseUrl.'/css/select2.css');
Yii::app()->getClientScript()
    ->registerScriptFile(yii::app()->request->baseUrl.'/js/select2.js');
?>