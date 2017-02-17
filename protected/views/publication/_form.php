<?php
/* @var $this PublicationController */
/* @var $model Publication */
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
            'id'=>'publication-form',
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
        <div class="columns" style="width: 920px">
            <?php echo $form->labelEx($model,'info'); ?>
            <?php echo $form->textArea($model,'info',array('size'=>60,'maxlength'=>500)); ?>
            <?php echo $form->error($model,'info'); ?>
        </div>
        <div class="clearfix"></div>
    </div>

    <div class="row">
        <div class="columns" style="width: 200px">
            <?php echo $form->labelEx($model,'press'); ?>
            <?php echo $form->textField($model,'press',array('maxlength'=>255)); ?>
            <?php echo $form->error($model,'press'); ?>
        </div>
        <div class="columns" style="width: 160px">
            <?php echo $form->labelEx($model,'isbn_number'); ?>
            <?php echo $form->textField($model,'isbn_number',array('maxlength'=>255)); ?>
            <?php echo $form->error($model,'isbn_number'); ?>
        </div>
        <div class="columns">
            <label for="category">类别</label>
            <div class="clearfix"></div>
            <input id="category" name="category" type="text" style="float: left; width:180px;" placeholder="输入类别或在右侧选择" value="<?php echo isset($model->category) ? $model->category : ''?>">
            <select id="category_list" name="category_list" class="category_list" style="float: left; width:180px; margin-left: 10px;" onchange="document.getElementById('category').value = this.value;">
                <option value="">选择类别</option>
                <?php
                $hasSelected = isset($model->category);
                $categories = CHtml::listData(Publication::model()->findAll(),'category', 'category');
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

        <div class="columns" style="width: 160px">
            <?php echo $form->labelEx($model,'pub_date'); ?>
            <?php echo $form->textField($model,'pub_date',array('placeholder'=>'yyyy-mm-dd')); ?>
            <?php echo $form->error($model,'pub_date'); ?>
        </div>
        <div class="clearfix"></div>
    </div>

    <div class="row">
        <?php
        //peoples是关联项，因此使用html写，update时可以直接从peoples中获得数据显示在页面上，保存时通过POST向create/update控制器传值，控制器将值存入save_peoples_id项，再调用save()储存people信息
        $authors = $model->peoples;
        //var_dump($authors);
        for($i=0;$i<8;$i++) {
            echo '<div class="columns" style="width: 223px">';

            echo $form->label($model,'发明人'.($i+1));
            $select = '<select style="width: 100%" name="Publication[peoples]['.$i.']">';
            $select .= '<option value="-1">选择发明人</option>';
            foreach($peoples as $p) {
                $selected = "";
                if($i<count($authors) && $authors[$i]->id == $p->id)
                    $selected = 'selected="selected"';
                $select .= '<option '.$selected.' value="'.$p->id.'">'.$p->getContentToList().'</option>';
            }
            $select .= '</select>';
            echo $select;

            echo '</div>';
            if($i == 3) {
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
        //projects是关联项，因此使用html写，update时可以直接从projects中获得数据显示在页面上，保存时通过POST向create/update控制器传值，控制器将值存入save_projects_id项，再调用save()储存projects信息
        $fund_projects = $model->fund_projects;
        for($i=0;$i<6;$i++) {
            echo '<div class="columns" style="width: 456px">';

            echo $form->label($model,'支助项目'.($i+1));
            $select = '<select style="width: 100%" name="Project[fund_projects]['.$i.']">';
            $select .= '<option value="-1">无</option>';
            foreach($projects as $p) {
                $selected = "";
                if($i<count($fund_projects) && $fund_projects[$i]->id == $p->id)
                    $selected = 'selected="selected"';
                $select .= '<option '.$selected.' value="'.$p->id.'">'.'(' . $p->number . ')' . $p->name . '[' . $p->fund_number . ']</option>';
            }
            $select .= '</select>';
            echo $select;

            echo '</div>';
            if($i == 1 || $i == 3) {
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
        $reim_projects = $model->reim_projects;
        for($i=0;$i<2;$i++) {
            echo '<div class="columns" style="width: 456px">';

            echo $form->label($model,'报账项目'.($i+1));
            $select = '<select style="width: 100%" name="Project[reim_projects]['.$i.']">';
            $select .= '<option value="-1">无</option>';
            foreach($projects as $p) {
                $selected = "";
                if($i<count($reim_projects) && $reim_projects[$i]->id == $p->id)
                    $selected = 'selected="selected"';
                $select .= '<option '.$selected.' value="'.$p->id.'">'.'(' . $p->number . ')' . $p->name . '[' . $p->fund_number . ']</option>';
            }
            $select .= '</select>';
            echo $select;

            echo '</div>';
        }
        ?>
        <div class="clearfix"></div>
    </div>

    <div class="row">
        <?php
        $achievement_projects = $model->achievement_projects;
        for($i=0;$i<5;$i++) {
            echo '<div class="columns" style="width: 456px">';

            echo $form->label($model,'成果项目'.($i+1));
            $select = '<select style="width: 100%" name="Project[achievement_projects]['.$i.']">';
            $select .= '<option value="-1">无</option>';
            foreach($projects as $p) {
                $selected = "";
                if($i<count($achievement_projects) && $achievement_projects[$i]->id==$p->id)
                    $selected = 'selected="selected"';
                $select .= '<option '.$selected.' value="'.$p->id.'">'.'(' . $p->number . ')' . $p->name . '[' . $p->fund_number . ']</option>';
            }
            $select .= '</select>';
            echo $select;

            echo '</div>';
            if($i == 1 || $i == 3) {
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
            <?php echo $form->textArea($model,'description',array('size'=>120,'maxlength'=>500)); ?>
            <?php echo $form->error($model,'description'); ?>
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
