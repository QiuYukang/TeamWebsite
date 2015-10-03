<?php
/* @var $this PatentController */
/* @var $model Patent */
/* @var $form CActiveForm */


//已用前端重写，create、update采用yii框架生成form，search部分因为没有$model对应，所以没有必要
//传入的$now_criteria中存在当前的所有搜索条件，应显示在搜索界面上
?>

<?php
$peoples = People::model()->findAllBySql('SELECT * FROM `tbl_people` ORDER BY `position` DESC, CONVERT( `name` USING gbk );'); //先以职位排序，在以汉字首字母顺序排序
$projects = Project::model()->findAllBySql('SELECT * FROM `tbl_project` ORDER BY latest_date DESC;'); //以最新时间顺序排序
?>

<br>

<div class="wide form">
    <form id="search_form" method="get" action="">

        <div class="row">
            <div class="medium-5 columns">
                <label for="keyword">关键词</label>
                <input id="keyword" name="keyword" type="text" value="<?php echo isset($now_criteria['keyword']) ? $now_criteria['keyword'] : ''?>">
            </div>
            <div class="medium-3 columns end">
                <label for="number">专利号</label>
                <input id="number" name="number" type="text" value="<?php echo isset($now_criteria['number']) ? $now_criteria['number'] : ''?>">
            </div>
        </div>

        <div class="row">
            <div class="medium-3 columns">
                <label for="author">发明人</label>
                <select id="author" name="author">
                    <option value="-1">选择发明人</option>
                    <?php
                    $hasSelected = isset($now_criteria['author']);
                    foreach($peoples as $p) {
                        if($hasSelected && $p->id == $now_criteria['author']) {
                            echo '<option selected="selected" value ="'.$p->id.'">'.$p->getContentToList().'</option>';
                            $hasSelected = false;
                        }
                        else echo '<option value ="'.$p->id.'">'.$p->getContentToList().'</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="medium-3 columns">
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
            <div class="medium-2 columns end">
                <label for="status">状态</label>
                <select id="status" name="status">
                    <option value="-1">选择状态</option>
                    <option <?php echo (isset($now_criteria['status']) && $now_criteria['status'] == 0) ? 'selected="selected"' : '' ?> value="0">已申请</option>
                    <option <?php echo (isset($now_criteria['status']) && $now_criteria['status'] == 1) ? 'selected="selected"' : '' ?> value="1">已授权</option>
                </select>
            </div>
        </div>
        <br/>
        <div class="row">
            <div class="medium-2 columns" id="level">
                <label for="level">级别</label>
                <select id="level" name="level">
                    <option value="-1">选择级别</option>
                    <?php
                    $hasSelected = isset($now_criteria['level']);
                    foreach(CHtml::listData(Patent::model()->findAll(),'level', 'level') as $p) {
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
                    $categories = CHtml::listData(Patent::model()->findAll(),'category', 'category');
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
            <div class="medium-2 columns">
                <label for="start_date">开始时间</label>
                <input id="start_date" name="start_date" type="text" value="<?php echo isset($now_criteria['start_date']) ? $now_criteria['start_date'] : ''?>" placeholder="yyyy-mm-dd" />
            </div>
            <div class="medium-2 columns end">
                <label for="end_date">截至时间</label>
                <input id="end_date" name="end_date" type="text" value="<?php echo isset($now_criteria['end_date']) ? $now_criteria['end_date'] : ''?>" placeholder="yyyy-mm-dd" />
            </div>
        </div>
        <div class="row">
            <div class="medium-8 columns end">
                <label for="reim_project">报账项目</label>
                <select id="reim_project" name="reim_project">
                    <option value="-1">选择报账项目</option>
                    <?php
                    $hasSelected = isset($now_criteria['reim_project']);
                    foreach($projects as $p) {
                        if($hasSelected && $p->id == $now_criteria['reim_project']) {
                            echo '<option selected="selected" value="'.$p->id.'">'.'(' . $p->number . ')' . $p->name . '[' . $p->fund_number . ']'.'</option>';
                            $hasSelected = false;
                        }
                        else echo '<option value="'.$p->id.'">'.'(' . $p->number . ')' . $p->name . '[' . $p->fund_number . ']'.'</option>';
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="medium-8 columns end">
                <label for="achievement_project">成果项目</label>
                <select id="achievement_project" name="achievement_project">
                    <option value="-1">选择成果项目</option>
                    <?php
                    $hasSelected = isset($now_criteria['achievement_project']);
                    foreach($projects as $p) {
                        if($hasSelected && $p->id == $now_criteria['achievement_project']) {
                            echo '<option selected="selected" value="'.$p->id.'">'.'(' . $p->number . ')' . $p->name . '[' . $p->fund_number . ']'.'</option>';
                            $hasSelected = false;
                        }
                        else echo '<option value="'.$p->id.'">'.'(' . $p->number . ')' . $p->name . '[' . $p->fund_number . ']'.'</option>';
                    }
                    ?>
                </select>
            </div>
        </div>
        <br/>
        <div class="row">
            <div class="medium-4 columns" id="category">
                <label for="category">类别</label>
                <select id="category" name="category">
                    <option value="-1">选择类别</option>
                    <?php
                    $hasSelected = isset($now_criteria['category']);
                    foreach(CHtml::listData(Paper::model()->findAll(),'category', 'category') as $p) {
                        if($hasSelected && $p == $now_criteria['category']) {
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
            <div class="medium-3 columns end">
                <input type="checkbox" id="incomplete" name="incomplete" <?php echo isset($now_criteria['incomplete']) ? 'checked="checked"' : ''?> />
                <label for="incomplete">信息不完整或有误的专利</label>
            </div>
        </div>

        <br/>

        <div class="row buttons">
            <div class="medium-4 columns end">
                <input type="button" id="search_btn" class="btn btn-default" value="查询" onclick="validate(0)" />
                &nbsp;&nbsp;
                <input type="button" id="export_btn" class="btn btn-default" value="导出" onclick="validate(1)" />
                &nbsp;&nbsp;
                <input type="button" class="btn btn-default" value="重置" onclick="location='index.php?r=patent/admin'"/>
            </div>
        </div>

    </form>




    <script type="text/javascript">

        //表单提交URL简化，只提交有条件的表单，同时对导出和查询做区分
        function validate(isExport) {
            var location = "index.php?r=patent/admin"
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

