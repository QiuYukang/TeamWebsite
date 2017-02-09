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
                'enctype' => 'multipart/form-data', //上传文件会用到
            ),
        )); ?>

    <!--	<p class="note">Fields with <span class="required">*</span> are required.</p>-->
    <?php
    //        echo $form->errorSummary($model);  //提示所有错误
    ?>


    <div class="row">
        <div class="columns" style="width: 920px" id="name">
            <?php echo $form->labelEx($model,'name'); ?>
            <?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>500)); ?>
            <?php echo $form->error($model,'name'); ?>
        </div>
        <div class="clearfix"></div>
    </div>

    <div class="row">
        <div class="columns" style="width: 160px">
            <?php echo $form->labelEx($model,'number'); ?>
            <?php echo $form->textField($model,'number',array('size'=>60,'maxlength'=>255)); ?>
            <?php echo $form->error($model,'number'); ?>
        </div>
        <div class="columns" style="width: 160px">
            <?php echo $form->labelEx($model,'fund_number'); ?>
            <?php echo $form->textField($model,'fund_number',array('size'=>60,'maxlength'=>255)); ?>
            <?php echo $form->error($model,'fund_number'); ?>
        </div>
        <div class="columns" style="width: 120px">
            <?php
            echo $form->label($model,'级别');
            $listData = array_merge(array('国际级'=>'国际级', '国家级'=>'国家级', '省部级'=>'省部级', '横向'=>'横向'), CHtml::listData(Project::model()->findAll(),'level','level'));
            $listData = array(null => '选择级别')+$listData;
            echo $form->dropDownList($model,'level',$listData,array('style'=>'width: 100%'));
            ?>
        </div>
        <div class="columns">
            <label for="category">类别</label>
            <div class="clearfix"></div>
            <input id="category" name="category" type="text" style="float: left; width:220px;" placeholder="输入类别或在右侧选择" value="<?php echo isset($model->category) ? $model->category : ''?>">
            <select id="category_list" name="category_list" class="category_list" style="float: left; width:220px; margin-left: 10px;" onchange="document.getElementById('category').value = this.value;">
            <option value="">选择类别</option>
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
        </div>
        <div class="clearfix"></div>
    </div>

    <div class="row">
        <div class="columns" style="width: 330px">
            <?php echo $form->labelEx($model,'unit'); ?>
            <?php echo $form->textField($model,'unit',array('size'=>60,'maxlength'=>255)); ?>
            <?php echo $form->error($model,'unit'); ?>
        </div>
        <div class="columns" style="width: 130px">
            <?php echo $form->labelEx($model,'fund'); ?>
            <?php echo $form->textField($model,'fund'); ?>
            <?php echo $form->error($model,'fund'); ?>
        </div>
        <div class="columns" style="width: 140px">
            <?php echo $form->labelEx($model,'start_date'); ?>
            <?php echo $form->textField($model,'start_date',array('placeholder'=>'yyyy-mm-dd')); ?>
            <?php echo $form->error($model,'start_date'); ?>
        </div>
        <div class="columns" style="width: 140px">
            <?php echo $form->labelEx($model,'deadline_date'); ?>
            <?php echo $form->textField($model,'deadline_date',array('placeholder'=>'yyyy-mm-dd')); ?>
            <?php echo $form->error($model,'deadline_date'); ?>
        </div>
        <div class="columns" style="width: 140px">
            <?php echo $form->labelEx($model,'conclude_date'); ?>
            <?php echo $form->textField($model,'conclude_date',array('placeholder'=>'yyyy-mm-dd')); ?>
            <?php echo $form->error($model,'conclude_date'); ?>
        </div>
        <div class="clearfix"></div>
    </div>

    <div class="row">
        <?php
        //execute_peoples是关联项，因此使用html写，update时可以直接从execute_peoples中获得数据显示在页面上，保存时通过POST向create/update控制器传值，控制器将值存入save_execute_peoples_id项，再调用save()储存execute_people信息
        //liability_peoples下同
        $execute_peoples = $model->execute_peoples;
        for($i=0; $i<20; $i++) {
            echo '<div class="columns" style="width: 176px">';
            echo $form->label($model,'执行人员'.($i+1));
            $select = '<select style="width: 100%" name="Project[execute_peoples]['.$i.']">';
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
            if($i == 4 || $i == 9 || $i == 14 || $i == 19) {
                echo '<div class="clearfix"></div>';
                echo '</div>';
                echo '<div class="row">';
            }
        }
        ?>
        <div class="clearfix"></div>
    </div>

    <div class="row">
        <?php
        $liability_peoples = $model->liability_peoples;
        for($i=0; $i<20; $i++) {
            echo '<div class="columns" style="width: 176px">';
            echo $form->label($model,'合同书人员'.($i+1));
            $select = '<select style="width: 100%" name="Project[liability_peoples]['.$i.']">';
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
            if($i == 4 || $i == 9 || $i == 14 || $i == 19) {
                echo '<div class="clearfix"></div>';
                echo '</div>';
                echo '<div class="row">';
            }
        }
        ?>
        <div class="clearfix"></div>
    </div>

    <div class="row">
        <div class="columns" style="width: 920px;">
            <?php echo $form->labelEx($model,'description'); ?>
            <?php echo $form->textArea($model,'description',array('size'=>120,'maxlength'=>2048,'rows'=>'4')); ?>
            <?php echo $form->error($model,'description'); ?>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="row">
        <div class="columns" style="width: 145px">
            <?php
            //$maintainer = $model->maintainer;
            echo $form->label($model,'维护人员');
            $listData = CHtml::listData($peoples,'id','name');
            $listData = array(null => '选择维护人员')+$listData; //维护人员没有进行后续处理，因此“选择维护人员”这里必须为null不能为-1之类
            //var_dump(($listData));
            echo $form->dropDownList($model,'maintainer_id',$listData,array('style'=>'width: 100%'));
            ?>
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
