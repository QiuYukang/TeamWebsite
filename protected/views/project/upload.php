<?php
/**
 * Created by PhpStorm.
 * User: ZLY
 * Date: 13-12-31
 * Time: 下午2:52
 */

$this->pageTitle=Yii::app()->name . ' - 导入科研项目';
//面包屑
$this->breadcrumbs=array(
    '科研'=>array('project/index'),
    '科研项目'=>array('index'),
    '管理'=>array('admin'),
    '导入',
);
?>

<div class="cam-page-header">
    <div class="cam-wrap clearfix cam-local-navigation">
        <ul class="cam-unstyled-list cam-current">
            <li><a href="index.php?r=site/introduction">团队介绍</a></li>
            <li><a href="index.php?r=site/direction">研究方向</a></li>
            <li class="cam-current-page"><a href="#" class="active-trail">科研项目</a></li>
            <li><a href="#">科研成果</a></li>
        </ul>
    </div>
    <div class="cam-wrap clearfix cam-page-sub-title cam-recessed-sub-title">
        <div class="cam-column">
            <div class="cam-content-container">
                <h1 class="cam-sub-title">
                    添加科研项目 Add project
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
                        <input type="button" value="下载标准导入格式文件" class="btn btn-default" style="float: right" onclick="location='index.php?r=project/downloadformat'"/>
                    </div>
                    <div class="clearfix"></div>
                </form>
            </div>

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