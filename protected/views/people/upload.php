<?php
/**
 * Created by PhpStorm.
 * User: ZLY
 * Date: 13-12-31
 * Time: 下午2:52
 */


$this->pageTitle=Yii::app()->name . ' - 导入团队成员';
//面包屑
$this->breadcrumbs=array(
    '团队成员'=>array('people/admin'),
    '导入',
);

?>

<div class="cam-page-header">
    <div class="cam-wrap clearfix cam-page-sub-title cam-recessed-sub-title">
        <div class="cam-column">
            <div class="cam-content-container">
                <h1 class="cam-sub-title">
                    导入团队成员 Upload team member
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
                        <input type="button" value="下载标准导入格式文件" class="btn btn-default" style="float: right" onclick="location='index.php?r=people/downloadformat'"/>
                    </div>
                    <div class="clearfix"></div>
                </form>
            </div>
            <br/>
            <p>小提示：</p>
            <p>1. 请严格使用标准导入格式文件填写数据后导入，否则会出现不可预计的错误</p>
            <p>2. 管理页面中导出的数据是标准导入格式文件，可以直接在上面修改后导入</p>
            <p>3. 为保证链接关系，导入的文件中所有的人员名在多个文件中保持完全一致，包括标点符号</p>
            <p>4. 为了保证项目、人员、论文间的链接关系，在数据库为空的时候应该按照导入人员->科研项目->论文/专利/著作/软件著作权的顺序导入</p>
            <p>5. 更多说明请查看<a href="#" style="color: #2a959e">使用手册/开发者手册</a></p>
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

<!--<form method="POST" enctype="multipart/form-data">-->
<!--    <input type="file" name="spreedSheet" value="" />-->
<!--    <input type="submit" value="上传文件" class="btn btn-primary"/>'-->
<!--</form>-->
