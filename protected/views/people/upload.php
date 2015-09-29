<?php
/**
 * Created by PhpStorm.
 * User: ZLY
 * Date: 13-12-31
 * Time: 下午2:52
 */


//面包屑
$this->breadcrumbs=array(
    '人员管理'=>array('people/admin'),
    '导入人员数据表',
);

?>

<style>
    .file-box{ position:relative;width:340px}
    .file-txt{ height:22px; border:1px solid #cdcdcd; width:180px;}
</style>

<div style="position:relative">
    <img src="images/lang1.jpg" alt="" />
    <div style="position:absolute;z-indent:2;left:0;top:0;">
        <h2>导入人员数据表</h2>
        <h4>请选择标准导入格式的Excel文件进行导入</h4>
    </div>
</div>

<br/>

<div class="file-box">
    <form action="" method="post" enctype="multipart/form-data">
        <input type='text' name='textField' id='textField' class='file-txt' onfocus="this.blur()"/>
        <input type='button' class='btn btn-default' value='浏览...' onclick="document.getElementById('fileField').click()"/>
        <input type="file" name="fileField" class="file" id="fileField" style="display: none;" onchange="document.getElementById('textField').value=getNameByPath(this.value)" />
        <input type="submit" class="btn btn-default" value="上传文件" />
        &nbsp;&nbsp;&nbsp;
        <input type="button" value="下载标准导入格式文件" class="btn btn-default" onclick="location='index.php?r=people/downloadformat'"/>
    </form>
</div>
<br><br>


<script>
    //路径获得文件名
    function getNameByPath(path){
        path = path.split("\\");
        return path[path.length-1];
    }

</script>

<!--<form method="POST" enctype="multipart/form-data">-->
<!--    <input type="file" name="spreedSheet" value="" />-->
<!--    <input type="submit" value="上传文件" class="btn btn-primary"/>'-->
<!--</form>-->
