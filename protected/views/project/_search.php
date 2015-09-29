<?php
/* @var $this ProjectController */
/* @var $model Project */
/* @var $form CActiveForm */

//已用前端重写，create、update采用yii框架生成form，search部分因为没有$model对应，所以没有必要
//传入的$now_criteria中存在当前的所有搜索条件，应显示在搜索界面上
?>

<?php
$peoples = People::model()->findAllBySql('SELECT * FROM `tbl_people` ORDER BY `position` DESC, CONVERT( `name` USING gbk );'); //先以职位排序，在以汉字首字母顺序排序
?>

<br>

<div class="wide form">
    <form id="search_form" method="get" action="">

        <div class="row">
            <div class="medium-8 columns end">
                <label for="keyword">关键词</label>
                <input id="keyword" name="keyword" type="text" value="<?php echo isset($now_criteria['keyword']) ? $now_criteria['keyword'] : ''?>">
            </div>
        </div>

        <div class="row">
            <div class="medium-4 columns">
                <label for="number">项目编号</label>
                <select id="number" name="number">
                    <option value="-1">选择项目编号</option>
                    <?php
                    $hasSelected = isset($now_criteria['number']);
                    foreach(CHtml::listData(Project::model()->findAll(), 'number', 'number') as $num) {
                        if($num == '') continue; //去空值
                        if($hasSelected && $num == $now_criteria['number']) {
                            echo '<option selected="selected" value ="'.$num.'">'.$num.'</option>';
                            $hasSelected = false;
                        }
                        else echo '<option value ="'.$num.'">'.$num.'</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="medium-4 columns end">
                <label for="fund_number">经费本编号</label>
                <select id="fund_number" name="fund_number">
                    <option value="-1">选择经费本编号</option>
                    <?php
                    $hasSelected = isset($now_criteria['fund_number']);
                    foreach(CHtml::listData(Project::model()->findAll(), 'fund_number', 'fund_number') as $num) {
                        if($num == '') continue; //去空值
                        if($hasSelected && $num == $now_criteria['fund_number']) {
                            echo '<option selected="selected" value ="'.$num.'">'.$num.'</option>';
                            $hasSelected = false;
                        }
                        else echo '<option value ="'.$num.'">'.$num.'</option>';
                    }
                    ?>
                </select>
            </div>
        </div>

        <div class="row">
            <div class="medium-2 columns" id="level">
                <label for="level">级别</label>
                <select id="level" name="level">
                    <option value="-1">选择级别</option>
                    <?php
                    $hasSelected = isset($now_criteria['level']);
                    foreach(CHtml::listData(Project::model()->findAll(),'level', 'level') as $p) {
                        if($hasSelected && $p == $now_criteria['level']) {
                            echo '<option selected="selected" value ="'.$p.'">'.$p.'</option>';
                            $hasSelected = false;
                        }
                        else echo '<option value ="'.$p.'">'.$p.'</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="medium-2 columns">
                <label for="category">类别</label>
                <div style="position:relative;">
            <span style="margin-left:100px;width:20px;overflow:hidden;">
                <select id="category_list" name="category_list" class="category_list" style="width:168px;margin-left:-100px" onchange="document.getElementById('category').value = this.value;">
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
                <input id="category" name="category" style="width:150px;height:26px;position:absolute;left:0px;" placeholder="&nbsp;&nbsp;选择或输入类别" value="<?php echo isset($now_criteria['category']) ? $now_criteria['category'] : ''?>">
                </div>
            </div>
            <div class="medium-4 columns end" id="unit">
                <label for="unit">合作/牵头单位</label>
                <select id="unit" name="unit">
                    <option value="-1">选择合作/牵头单位</option>
                    <?php
                    $hasSelected = isset($now_criteria['unit']);
                    foreach(CHtml::listData(Project::model()->findAll(),'unit', 'unit') as $p) {
                        if($p == '') continue; //去空值
                        if($hasSelected && $p == $now_criteria['unit']) {
                            echo '<option selected="selected" value ="'.$p.'">'.$p.'</option>';
                            $hasSelected = false;
                        }
                        else echo '<option value ="'.$p.'">'.$p.'</option>';
                    }
                    ?>
                </select>
            </div>
        </div>

        <br/>

        <div class="row">
            <div class="medium-2 columns">
                <label for="start_date">开始时间</label>
                <input id="start_date" name="start_date" type="text" value="<?php echo isset($now_criteria['start_date']) ? $now_criteria['start_date'] : ''?>" placeholder="yyyy-mm-dd" />
            </div>
            <div class="medium-2 columns">
                <label for="end_date">截至时间</label>
                <input id="end_date" name="end_date" type="text" value="<?php echo isset($now_criteria['end_date']) ? $now_criteria['end_date'] : ''?>" placeholder="yyyy-mm-dd" />
            </div>
            <div class="medium-2 columns">
                <label for="start_fund">经费大于</label>
                <input id="start_fund" name="start_fund" type="text" value="<?php echo isset($now_criteria['start_fund']) ? $now_criteria['start_fund'] : ''?>" />
            </div>
            <div class="medium-2 columns end">
                <label for="end_fund">小于</label>
                <input id="end_fund" name="end_fund" type="text" value="<?php echo isset($now_criteria['end_fund']) ? $now_criteria['end_fund'] : ''?>" />
            </div>
        </div>

        <div class="row">
            <div class="medium-3 columns">
                <label for="execute_people">执行人员</label>
                <select id="execute_people" name="execute_people">
                    <option value="-1">选择执行人员</option>
                    <?php
                    $hasSelected = isset($now_criteria['execute_people']);
                    foreach($peoples as $p) {
                        if($hasSelected && $p->id == $now_criteria['execute_people']) {
                            echo '<option selected="selected" value ="'.$p->id.'">'.$p->getContentToList().'</option>';
                            $hasSelected = false;
                        }
                        else echo '<option value ="'.$p->id.'">'.$p->getContentToList().'</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="medium-3 columns">
                <label for="liability_people">合同书人员</label>
                <select id="liability_people" name="liability_people">
                    <option value="-1">选择合同书人员</option>
                    <?php
                    $hasSelected = isset($now_criteria['liability_people']);
                    foreach($peoples as $p) {
                        if($hasSelected && $p->id == $now_criteria['liability_people']) {
                            echo '<option selected="selected" value ="'.$p->id.'">'.$p->getContentToList().'</option>';
                            $hasSelected = false;
                        }
                        else echo '<option value ="'.$p->id.'">'.$p->getContentToList().'</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="medium-2 columns end">
                <label for="maintainer">维护人员</label>
                <select id="maintainer" name="maintainer">
                    <option value="-1">选择维护人员</option>
                    <?php
                    $hasSelected = isset($now_criteria['maintainer']);
                    foreach($peoples as $p) {
                        if($hasSelected && $p->id == $now_criteria['maintainer']) {
                            echo '<option selected="selected" value ="'.$p->id.'">'.$p->getContentToList().'</option>';
                            $hasSelected = false;
                        }
                        else echo '<option value ="'.$p->id.'">'.$p->getContentToList().'</option>';
                    }
                    ?>
                </select>
            </div>

        </div>

        <br/>
        <div class="row">
            <div class="medium-4 columns end">
                <label for="order">显示顺序</label>
                <select id="order" name="order">
                    <option value="-1">按时间排序</option>
                    <option value="2" <?php echo (isset($now_criteria['order']) && $now_criteria['order'] == 2) ? 'selected="selected"' : ''?>>按最近更新时间排序</option>
                </select>
            </div>
        </div>
        <br/>
        <div class="row">
            <div class="medium-3 columns end">
                <input type="checkbox" id="incomplete" name="incomplete" <?php echo isset($now_criteria['incomplete']) ? 'checked="checked"' : ''?> />
                <label for="incomplete">信息不完整或有误的科研项目</label>
            </div>
        </div>

        <br/>

        <div class="row buttons">
            <div class="medium-4 columns end">
                <input type="button" id="search_btn" class="btn btn-default" value="查询" onclick="validate(0)" />
                &nbsp;&nbsp;
                <input type="button" id="export_btn" class="btn btn-default" value="导出" onclick="validate(1)" />
                &nbsp;&nbsp;
                <input type="button" class="btn btn-default" value="重置" onclick="location='index.php?r=project/admin'"/>
            </div>
        </div>

    </form>




    <script type="text/javascript">

        //表单提交URL简化，只提交有条件的表单，同时对导出和查询做区分
        function validate(isExport) {
            var location = "index.php?r=project/admin"
            var form = document.getElementById('search_form');
            for (var i = 0; i < form.elements.length; i++) {
                var element = form.elements[i];
                var tag = element.tagName;
                var type = element.type;
                if(element.id == "category_list") continue; //category_list作为隐藏元素不提交
                switch(tag) {
                    case "INPUT":
                        switch (type) {
                            case "text":
                                if (element.value != '') {
                                    location += ('&' + element.name + '=' + element.value);
                                }
                                break;
                            case "checkbox":
                                if(element.checked) {
                                    location += ('&' + element.name + '=' + 1);
                                }
                                break;
                        }
                        break;
                    case "SELECT":
                        if (element.value != -1) {
                            location += ('&' + element.name + '=' + element.value);
                        }
                }
            }
            if(isExport) location += "&export=1";
            window.location.href = location;
        }


        //下拉框搜索
        $('select').select2({
            width: 'resolve'
//                matcher: function(term,text) {
//                    var pinyin = new Pinyin();
//                    var mod=pinyin.getCamelChars(text.toUpperCase());
//                    return mod.indexOf(term.toUpperCase())==0;
//                }
        });
    </script>

</div>


<?php
//下拉框搜索的css和js文件
Yii::app()->getClientScript()->
registerCssFile(yii::app()->request->baseUrl.'/css/select2.css');

Yii::app()->getClientScript()
    ->registerScriptFile(yii::app()->request->baseUrl.'/js/select2.js');
?>

