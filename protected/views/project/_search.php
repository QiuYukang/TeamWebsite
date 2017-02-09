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

<form id="search_form" method="get" action="">
    <div class="row">
        <div class="columns" style="width: 450px">
            <label for="keyword">关键词</label>
            <input id="keyword" name="keyword" type="text" placeholder="输入关键词" value="<?php echo isset($now_criteria['keyword']) ? $now_criteria['keyword'] : ''?>">
        </div>
        <div class="columns" style="width: 220px">
            <label for="number">项目编号</label>
            <input id="number" name="number" type="text" placeholder="输入项目编号" value="<?php echo isset($now_criteria['number']) ? $now_criteria['number'] : ''?>">
        </div>
        <div class="columns" style="width: 218px">
            <label for="fund_number">经费本编号</label>
            <input id="fund_number" name="fund_number" type="text" placeholder="输入经费本编号" value="<?php echo isset($now_criteria['fund_number']) ? $now_criteria['fund_number'] : ''?>">
        </div>
        <div class="clearfix"></div>
    </div>

    <div class="row">
        <div class="columns" style="width: 297px">
            <label for="execute_people">执行人员</label>
            <select id="execute_people" name="execute_people" style="width: 100%">
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
        <div class="columns" style="width: 297px">
            <label for="liability_people">合同书人员</label>
            <select id="liability_people" name="liability_people" style="width: 100%">
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
        <div class="columns" style="width: 296px">
            <label for="maintainer">维护人员</label>
            <select id="maintainer" name="maintainer" style="width: 100%">
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
        <div class="clearfix"></div>
    </div>
    <div class="row">
        <div class="columns" style="width: 120px">
            <label for="level">级别</label>
            <select id="level" name="level" style="width: 100%">
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
        <div class="columns">
            <label for="category">类别</label>
            <div class="clearfix"></div>
            <input id="category" name="category" type="text" style="float: left; width:220px;" placeholder="输入类别或在右侧选择" value="<?php echo isset($now_criteria['category']) ? $now_criteria['category'] : ''?>">
            <select id="category_list" name="category_list" class="category_list" style="float: left; width:220px; margin-left: 5px;" onchange="document.getElementById('category').value = this.value;">
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

        <div class="columns" style="width: 325px">
            <label for="unit">合作/牵头单位</label>
            <select id="unit" name="unit" style="width: 100%">
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
        <div class="clearfix"></div>
    </div>

    <div class="row">
        <div class="columns" style="width: 220px">
            <label for="start_date">开始时间</label>
            <input id="start_date" name="start_date" type="text" value="<?php echo isset($now_criteria['start_date']) ? $now_criteria['start_date'] : ''?>" placeholder="yyyy-mm-dd" />
        </div>
        <div class="columns" style="width: 220px">
            <label for="end_date">截至时间</label>
            <input id="end_date" name="end_date" type="text" value="<?php echo isset($now_criteria['end_date']) ? $now_criteria['end_date'] : ''?>" placeholder="yyyy-mm-dd" />
        </div>
        <div class="columns" style="width: 220px">
            <label for="start_fund">经费大于</label>
            <input id="start_fund" name="start_fund" type="text" placeholder="万元" value="<?php echo isset($now_criteria['start_fund']) ? $now_criteria['start_fund'] : ''?>" />
        </div>
        <div class="columns" style="width: 220px">
            <label for="end_fund">小于</label>
            <input id="end_fund" name="end_fund" type="text" placeholder="万元" value="<?php echo isset($now_criteria['end_fund']) ? $now_criteria['end_fund'] : ''?>" />
        </div>
        <div class="clearfix"></div>
    </div>

    <div class="row">
        <div class="columns" style="width: 220px">
            <label for="order">排序</label>
            <select id="order" name="order" style="width: 100%">
                <option value="-1">按时间排序</option>
                <option value="2" <?php echo (isset($now_criteria['order']) && $now_criteria['order'] == 2) ? 'selected="selected"' : ''?>>按最近更新时间排序</option>
            </select>
        </div>
        <div class="clearfix"></div>
    </div>

    <div class="row">
        <div class="columns" style="width: 920px">
            <input type="checkbox" id="incomplete" name="incomplete" <?php echo isset($now_criteria['incomplete']) ? 'checked="checked"' : ''?> />
            <label for="incomplete">仅显示信息不完整或有误的科研项目（该选项用于查找信息不完整的数据以方便更改或补全）</label>
        </div>
        <div class="clearfix"></div>
    </div>

    <div class="row" style="margin: 0">
        <div class="columns" style="width: 920px">
            <input type="button" id="search_btn" class="btn btn-default" value="查询" onclick="validate(0)" />
            &nbsp;
            <input type="button" id="export_btn" class="btn btn-default" value="导出" onclick="validate(1)" />
            &nbsp;
            <input type="button" class="btn btn-default" value="重置" onclick="location='index.php?r=project/admin'"/>
        </div>
        <div class="clearfix"></div>
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
//                matcher: function(term,text) {
//                    var pinyin = new Pinyin();
//                    var mod=pinyin.getCamelChars(text.toUpperCase());
//                    return mod.indexOf(term.toUpperCase())==0;
//                }
    });
</script>


