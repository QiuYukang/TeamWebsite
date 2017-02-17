<?php
/**
 * Created by PhpStorm.
 * User: ZLY
 * Date: 13-12-31
 * Time: 下午2:52
 */


$this->pageTitle=Yii::app()->name . ' - 导入用户';
//面包屑
$this->breadcrumbs=array(
    '用户管理'=>array('user/admin'),
    '导入',
);

?>

<div class="cam-page-header">
    <div class="cam-wrap clearfix cam-page-sub-title cam-recessed-sub-title">
        <div class="cam-column">
            <div class="cam-content-container">
                <h1 class="cam-sub-title">
                    导入用户 Upload user
                </h1>
            </div>
        </div>
    </div>
</div>
<div class="cam-content cam-recessed-content">
    <div class="cam-wrap clearfix">
        <div class="index-content">

            <div class="create-upload">
                <p>批量添加（上传导入文件）</p>
                <form action="" method="post" enctype="multipart/form-data">
                    <input type='text' name='textField' id='textField' class='file-txt' onfocus="this.blur()"/>
                    <div style="margin-top: 10px">
                        <input type='button' class='btn btn-default' value='浏览...' style="float: left" onclick="document.getElementById('fileField').click()"/>
                        <input type="file" name="fileField" class="file" id="fileField" style="display: none;" onchange="document.getElementById('textField').value=getNameByPath(this.value)" />
                        <input type="submit" class="btn btn-default" value="上传文件" style="float: left; margin-left: 15px" />
                        <input type="button" value="下载标准导入格式文件" class="btn btn-default" style="float: right" onclick="location='index.php?r=user/downloadformat'"/>
                    </div>
                    <div class="clearfix"></div>
                </form>
            </div>
            <br/>
            <p>小提示：</p>
            <p>1. 为了保证用户安全，已登录的该用户不会被修改</p>
            <p>2. 请严格使用标准导入格式文件填写数据后导入，否则会出现不可预计的错误</p>
            <p>3. 更多说明请查看<a href="#" style="color: #2a959e">使用手册/开发者手册</a></p>
        </div>
    </div>
</div>


<script>
    //路径获得文件名
    function getNameByPath(path){
        path = path.split("\\");
        return path[path.length-1];
    }

</script>

