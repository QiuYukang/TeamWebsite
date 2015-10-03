<?php
/* @var $this ProjectController */
/* @var $model Project */
/* @var $form CActiveForm */
?>

<?php
$peoples = People::model()->findAllBySql('SELECT * FROM `tbl_people` ORDER BY `position` DESC, CONVERT( `name` USING gbk );'); //先以职位排序，在以汉字首字母顺序排序
?>

    <div class="form">
        <?php
        $form = $this->beginWidget('CActiveForm',
            array(
                'id'=>'project-form',
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


        <div class="row" id="name">
            <div class="medium-12 columns end">
                <?php echo $form->labelEx($model,'name'); ?>
                <?php echo $form->textArea($model,'name',array('size'=>60,'maxlength'=>500)); ?>
                <?php echo $form->error($model,'name'); ?>
            </div>
        </div>

        <div class="row">
            <div class="medium-6 columns" id="number">
                <?php echo $form->labelEx($model,'number'); ?>
                <?php echo $form->textField($model,'number',array('size'=>60,'maxlength'=>255)); ?>
                <?php echo $form->error($model,'number'); ?>
            </div>
            <div class="medium-6 columns end" id="fund_number">
                <?php echo $form->labelEx($model,'fund_number'); ?>
                <?php echo $form->textField($model,'fund_number',array('size'=>60,'maxlength'=>255)); ?>
                <?php echo $form->error($model,'fund_number'); ?>
            </div>
        </div>

        <div class="row">
            <div class="medium-3 columns">
                <?php
                echo $form->label($model,'级别');
                $listData = array_merge(array('国际级'=>'国际级', '国家级'=>'国家级', '省部级'=>'省部级', '横向'=>'横向'), CHtml::listData(Project::model()->findAll(),'level','level'));
                $listData = array(null => '选择级别')+$listData;
                echo $form->dropDownList($model,'level',$listData);
                ?>
            </div>
            <div class="medium-3 columns">
                <label for="category">类别</label>
                <div style="position:relative;">
            <span style="margin-left:100px;width:20px;overflow:hidden;">
                <select id="category_list" name="category_list" class="category_list" style="width:265px;margin-left:-100px" onchange="document.getElementById('category').value = this.value;">
                    <option value="">选择或输入类别</option>
                    <?php
                    $hasSelected = isset($model->category);
                    $categories = CHtml::listData(Project::model()->findAll(),'category', 'category');
                    foreach($categories as $k => $v) {
                        if($k == '') continue; //null值会被listData()函数解释出来为空值
                        if($hasSelected && $v == $model->category) {
                            echo '<option selected="selected" value="'.$k.'">'.$v.'</option>';
                            $hasSelected = false;
                        }
                        else echo '<option value="'.$k.'">'.$v.'</option>';
                    }
                    ?>
                </select>
                <input id="category" name="category" style="width:247px;height:26px;position:absolute;left:0px;" placeholder="&nbsp;&nbsp;选择或输入类别" value="<?php echo isset($model->category) ? $model->category : ''?>">
                </div>
            </div>
            <div class="medium-4 columns end" id="unit">
                <?php echo $form->labelEx($model,'unit'); ?>
                <?php echo $form->textField($model,'unit',array('size'=>60,'maxlength'=>255)); ?>
                <?php echo $form->error($model,'unit'); ?>
            </div>
            <div class="medium-2 columns" id="fund">
                <?php echo $form->labelEx($model,'fund'); ?>
                <?php echo $form->textField($model,'fund'); ?>
                <?php echo $form->error($model,'fund'); ?>
            </div>
        </div>

        <div class="row">
            <div class="medium-4 columns" id="start_date">
                <?php echo $form->labelEx($model,'start_date'); ?>
                <?php echo $form->textField($model,'start_date',array('placeholder'=>'日期格式: yyyy-mm-dd')); ?>
                <?php echo $form->error($model,'start_date'); ?>
            </div>
            <div class="medium-4 columns" id="deadline_date">
                <?php echo $form->labelEx($model,'deadline_date'); ?>
                <?php echo $form->textField($model,'deadline_date',array('placeholder'=>'日期格式: yyyy-mm-dd')); ?>
                <?php echo $form->error($model,'deadline_date'); ?>
            </div>
            <div class="medium-4 columns end" id="conclude_date">
                <?php echo $form->labelEx($model,'conclude_date'); ?>
                <?php echo $form->textField($model,'conclude_date',array('placeholder'=>'日期格式 :yyyy-mm-dd')); ?>
                <?php echo $form->error($model,'conclude_date'); ?>
            </div>
        </div>

        <div class="row" id="execute_peoples">
            <?php
            //execute_peoples是关联项，因此使用html写，update时可以直接从execute_peoples中获得数据显示在页面上，保存时通过POST向create/update控制器传值，控制器将值存入save_execute_peoples_id项，再调用save()储存execute_people信息
            //liability_peoples下同
            $execute_peoples = $model->execute_peoples;
            for($i=0; $i<20; $i++) {
                if($i == 5 || $i == 11 || $i == 17 || $i== 19) echo '<div class="medium-2 columns end" id="execute_peoples">';
                else echo '<div class="medium-2 columns" id="execute_peoples">';

                echo $form->label($model,'执行人员'.($i+1));
                $select = '<select name="Project[execute_peoples]['.$i.']">';
                $select .= '<option value="-1">选择执行人员</option>';
                foreach($peoples as $p) {
                    $selected = "";
                    if($i<count($execute_peoples) && $execute_peoples[$i]->id == $p->id)
                        $selected = 'selected="selected"';
                    $select .= '<option '.$selected.' value="'.$p->id.'">'.$p->getContentToList().'</option>';
                }
                $select .= '</select>';
                echo $select;

                echo '</div>';
                if($i == 5 || $i == 11) echo '</div><div class="row" id="execute_peoples">';
            }
            ?>
        </div>
        <br/>
        <div class="row" id="liability_peoples">
            <?php
            $liability_peoples = $model->liability_peoples;
            for($i=0; $i<20; $i++) {
                if($i == 5 || $i == 11 || $i == 17 || $i== 19) echo '<div class="medium-2 columns end" id="liability_peoples">';
                else echo '<div class="medium-2 columns" id="liability_peoples">';

                echo $form->label($model,'合同书人员'.($i+1));
                $select = '<select name="Project[liability_peoples]['.$i.']">';
                $select .= '<option value="-1">选择合同书人员</option>';
                foreach($peoples as $p) {
                    $selected = "";
                    if($i<count($liability_peoples) && $liability_peoples[$i]->id == $p->id)
                        $selected = 'selected="selected"';
                    $select .= '<option '.$selected.' value="'.$p->id.'">'.$p->getContentToList().'</option>';
                }
                $select .= '</select>';
                echo $select;

                echo '</div>';
                if($i == 5 || $i == 11) echo '</div><div class="row" id="$liability_peoples">';
            }
            ?>
        </div>

        <br/>

        <div class="row" id="description">
            <div class="medium-12 columns end">
                <?php echo $form->labelEx($model,'description'); ?>
                <?php echo $form->textArea($model,'description',array('size'=>120,'maxlength'=>2048)); ?>
                <?php echo $form->error($model,'description'); ?>
            </div>
        </div>
        <br/>
        <div class="row">
            <div class="medium-3 columns end" id="maintainer">
                <?php
                //$maintainer = $model->maintainer;
                echo $form->label($model,'维护人员');
                $listData = CHtml::listData($peoples,'id','name');
                $listData = array(null => '选择维护人员')+$listData; //维护人员没有进行后续处理，因此“选择维护人员”这里必须为null不能为-1之类
                //var_dump(($listData));
                echo $form->dropDownList($model,'maintainer_id',$listData);
                ?>
            </div>
        </div>
        </br>
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