<?php

//面包屑

$this->breadcrumbs=array(
    '学术成果'=>array('paper/index'),
    '软件著作权'=>array('index'),
    '管理'=>array('admin'),
    '导入软件著作权资料',
);

?>

<style>
    .file-box{ position:relative;width:340px}
    .file-txt{ height:22px; border:1px solid #cdcdcd; width:180px;}
</style>

<div style="position:relative">
    <img src="images/lang1.jpg" alt="" />
    <div style="position:absolute;z-indent:2;left:0;top:0;">
        <h2>导入软件著作权资料</h2>
        <h4>请选择软件著作权资料文件进行导入(可多选，单次上传请勿超过100M)</h4>
    </div>
</div>

<br/>

<div class="file-box">
    <form action="" method="post" enctype="multipart/form-data">
        <input type='text' name='textField' id='textField' class='file-txt' onfocus="this.blur()"/>
        <input type='button' class='btn btn-default' value='浏览...' onclick="document.getElementById('fileField').click()"/>
        <input type="file" name="fileField[]" class="file" id="fileField" multiple="true" style="display: none;" onchange="document.getElementById('textField').value=getNamesByFiles(this.files)" />
        <input type="submit" class="btn btn-default" value="上传文件" />
    </form>
</div>


<br><br>


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

<!--<form method="POST" enctype="multipart/form-data">-->
<!--    <input type="file" name="spreedSheet" value="" />-->
<!--    <input type="submit" value="上传文件" class="btn btn-primary"/>'-->
<!--</form>-->
