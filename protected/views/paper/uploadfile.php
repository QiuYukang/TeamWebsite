<?php

//已废弃，菜单用前台完成
//$this->menu=array(
//    array('label'=>'列出论文', 'url'=>array('index')),
//    array('label'=>'增加论文', 'url'=>array('create')),
//    array('label'=>'管理论文', 'url'=>array('admin')),
//    array('label'=>'导出全部论文', 'url'=>array('exportAll')),
//);

$this->pageTitle=Yii::app()->name . ' - 导入论文原文';
//面包屑
$this->breadcrumbs=array(
    '学术成果'=>array('paper/index'),
    '论文'=>array('index'),
    '管理'=>array('admin'),
    '导入原文',
);

?>

<div class="cam-page-header">
    <div class="cam-wrap clearfix cam-local-navigation">
        <ul class="cam-unstyled-list cam-current">
            <li class="cam-current-page"><a href="index.php?r=paper/admin" class="active-trail">论文</a></li>
            <li><a href="index.php?r=patent/admin">专利</a></li>
            <li><a href="index.php?r=publication/admin">专著</a></li>
            <li><a href="index.php?r=software/admin">软件著作权</a></li>
        </ul>
    </div>
    <div class="cam-wrap clearfix cam-page-sub-title cam-recessed-sub-title">
        <div class="cam-column">
            <div class="cam-content-container">
                <h1 class="cam-sub-title">
                    导入论文原文 Upload paper file
                </h1>
            </div>
        </div>
    </div>
</div>
<div class="cam-content cam-recessed-content">
    <div class="cam-wrap clearfix">
        <div class="index-content">

            <div class="create-upload">
                <p>批量导入原文（上传文件，可多选，单次请勿超过50M）</p>
                <form action="" method="post" enctype="multipart/form-data">
                    <input type='text' name='textField' id='textField' class='file-txt' onfocus="this.blur()"/>
                    <div style="margin-top: 10px">
                        <input type='button' class='btn btn-default' value='浏览...' style="float: left" onclick="document.getElementById('fileField').click()"/>
                        <input type="file" name="fileField[]" class="file" id="fileField" multiple="true" style="display: none;" onchange="document.getElementById('textField').value=getNamesByFiles(this.files)" />
                        <input type="submit" class="btn btn-default" style="float: left; margin-left: 15px" value="上传文件" />
                    </div>
                </form>
                <div class="clearfix"></div>
            </div>
            </form>
            <br/>
            <p>小提示：</p>
            <p>1. 批量导入文件适合为一批没有上传文件的论文（批量导入的论文）一次性导入文件，若单个添加文件可在添加或编辑页面进行</p>
            <p>2. 批量导入文件时文件名（不包括后缀）一定要与论文名保持完全一致，包括标点符号</p>
            <p>3. 由于数据库响应时间和网络速度的限制，单次上传请勿超过50M</p>
            <p>4. 更多说明请查看<a href="#" style="color: #2a959e">使用手册/开发者手册</a></p>
        </div>
    </div>
</div>

<script>
    //获得文件名
    function getNamesByFiles(files){
        if(files.length >= 1) {
            return (files[0].name.length > 16 ? files[0].name.substr(0, 16) + '...' : files[0].name)
                + (files.length == 1 ? ' ' : ' 等' )
                + files.length + '个文件';
        } else {
            return '';
        }
    }

</script>
