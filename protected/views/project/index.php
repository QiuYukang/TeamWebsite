<?php
/* @var $this ProjectController */
/* @var $dataProvider CActiveDataProvider */


$this->pageTitle=Yii::app()->name . ' - 科研项目';
//面包屑
$this->breadcrumbs=array(
    '科研'=>array('project/index'),
    '科研项目',
);

?>
<?php
$authStrArr=null;
$auth = false;
if(isset(Yii::app()->user->is_user) && Yii::app()->user->is_user) {
    $authStrArr = '普通用户';
    $auth = true;
}
if(isset(Yii::app()->user->is_manager) && Yii::app()->user->is_manager) {
    $authStrArr = '管理员';
    $auth = true;
}
if(isset(Yii::app()->user->is_admin) && Yii::app()->user->is_admin) {
    $authStrArr = '超级管理员';
    $auth = true;
}
?>
<?php $user = Yii::app()->user; ?>
<?php
//分页过程
$data_count = $dataProvider->itemCount;

$page = isset($page) ? $page : 1;
$page_size = 20;
$page_count = ceil($data_count/$page_size);

$offset = ($page-1) * $page_size;
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
                    科研项目 Project
                </h1>
            </div>
        </div>
    </div>
</div>
<div class="cam-content cam-recessed-content">
    <div class="cam-wrap clearfix">

        <?php
        //权限用户显示功能按钮
        if((isset($user->is_admin) && $user->is_admin) ||
            (isset($user->is_manager) && $user->is_manager) ||
            (isset($user->is_user) && $user->is_user)) {?>

            <ul class="index-list">
                <li><a href="index.php?r=project/admin">进入管理页面</a></li>
                <span>*本页面为对外展示页面，已登录用户请进入管理页面获取更多操作（该提示不对未登录用户显示）</span>
                <div class="clearfix"></div>
            </ul>

        <?php } ?>

        <div class="index-content">
            <?php
            if($data_count == 0) {
                echo "<p>团队数据库中暂时没有记载科研项目数据";
                echo $auth ? '。</p>' : '，更多操作请<a href="./index.php?r=site/login" style="color: #2a959e">登录</a>。</p>';
                echo '<img style="margin: 10px 0 20px 0;" src="'.Yii::app()->request->baseUrl.'/images/no_data.png"/>';
            } else {
                echo "<p>截止目前，团队数据库中共记录了 $data_count 个科研项目，当前页显示第 ".($offset + 1)." - ".min( $offset + $page_size, $data_count)." 个，共 $page_count 页";
                echo $auth ? '。</p>' : '，更多操作请<a href="./index.php?r=site/login" style="color: #2a959e">登录</a>。</p>';
                ?>
                <?php
                //用于计算页码按钮上的显示
                if($page_count >= 5) {
                    if($page <= 3) {
                        $p1 = 1; $p2 = 2; $p3 = 3; $p4 = 4; $p5 = 5;
                    } else if($page > $page_count - 3) {
                        $p1 = $page_count - 4; $p2 = $page_count - 3; $p3 = $page_count - 2; $p4 = $page_count - 1; $p5 = $page_count;
                    } else {
                        $p1 = $page - 2; $p2 = $page - 1; $p3 = $page; $p4 = $page + 1; $p5 = $page + 2;
                    }
                }
                ?>

                <ul class="pagination">

                    <?php  if($page!=1) echo '<li><a href="index.php?r=project/index&page=1">首页</a></li>'; else echo '<li><a href="#">已是首页</a></li>';?>
                    <?php if($page!=1) echo '<li><a href=index.php?r=project/index&page='.($page-1).'>&laquo;</a></li>' ?>

                    <?php if($page_count >= 5) { ?>
                        <li <?php if($page == 1) echo 'class="active"'; ?>><a href="index.php?r=project/index&page=<?php echo $p1; ?>"><?php echo $p1; ?></a></li>
                        <li <?php if($page == 2) echo 'class="active"'; ?>><a href="index.php?r=project/index&page=<?php echo $p2; ?>"><?php echo $p2; ?></a></li>
                        <li <?php if($page != 1 && $page != 2 && $page != $page_count - 1 && $page != $page_count) echo 'class="active"'; ?>><a href="index.php?r=project/index&page=<?php echo $p3; ?>"><?php echo $p3; ?></a></li>
                        <li <?php if($page == $page_count - 1) echo 'class="active"'; ?>><a href="index.php?r=project/index&page=<?php echo $p4; ?>"><?php echo $p4; ?></a></li>
                        <li <?php if($page == $page_count) echo 'class="active"'; ?>><a href="index.php?r=project/index&page=<?php echo $p5; ?>"><?php echo $p5; ?></a></li>
                    <?php }

                    //页数在5页以下的情况
                    else {
                        for($i = 1; $i <= $page_count; $i++) {
                            if($i == $page) echo '<li class = "active">';
                            else echo '<li>';
                            echo "<a href='index.php?r=project/index&page=$i'>$i</a></li>";
                        }
                    }
                    ?>

                    <?php if($page<$page_count) echo '<li><a href=index.php?r=project/index&page='.($page+1).'>&raquo;</a></li>'?>
                    <li><a href="index.php?r=project/index&page=<?php echo $page_count?>"><?php if($page<=$page_count-1) echo '尾页'; else echo "已是尾页";?></a></li>
                </ul>
                <div class="clearfix"></div>

                <table class="index-table index-table-hover">
                    <thead>
                    <tr>
                        <th style="width:40px; text-align: center">序号</th>
                        <th>科研项目</th>
                    </tr>
                    </thead>
                    <?php
                    for($i = $offset; $i < min( $offset + $page_size, $data_count); $i++){
                        ?>
                        <tbody>
                        <tr>
                            <td class="index-table-id"><?php /*序号*/ echo $i+1;?></td>
                            <td><?php /*信息*/ echo $dataProvider->getData()[$i]->getContentToGuest();?>
                                <?php if(!empty($dataProvider->getData()[$i]->description)) { ?>
                                <a onclick="javascript:TestBlack('divc<?php echo $i;?>');">更多</a></td>
                            <?php } ?>
                        </tr>
                        <tr id="divc<?php echo $i;?>" style="display: none">
                            <td></td>
                            <td><?php /*信息*/ echo $dataProvider->getData()[$i]->description;?></td>
                        </tr>
                        </tbody>
                        <?php
                    }
                    ?>
                </table>

                <ul class="pagination">

                    <?php  if($page!=1) echo '<li><a href="index.php?r=project/index&page=1">首页</a></li>'; else echo '<li><a href="#">已是首页</a></li>';?>
                    <?php if($page!=1) echo '<li><a href=index.php?r=project/index&page='.($page-1).'>&laquo;</a></li>' ?>

                    <?php if($page_count >= 5) { ?>
                        <li <?php if($page == 1) echo 'class="active"'; ?>><a href="index.php?r=project/index&page=<?php echo $p1; ?>"><?php echo $p1; ?></a></li>
                        <li <?php if($page == 2) echo 'class="active"'; ?>><a href="index.php?r=project/index&page=<?php echo $p2; ?>"><?php echo $p2; ?></a></li>
                        <li <?php if($page != 1 && $page != 2 && $page != $page_count - 1 && $page != $page_count) echo 'class="active"'; ?>><a href="index.php?r=project/index&page=<?php echo $p3; ?>"><?php echo $p3; ?></a></li>
                        <li <?php if($page == $page_count - 1) echo 'class="active"'; ?>><a href="index.php?r=project/index&page=<?php echo $p4; ?>"><?php echo $p4; ?></a></li>
                        <li <?php if($page == $page_count) echo 'class="active"'; ?>><a href="index.php?r=project/index&page=<?php echo $p5; ?>"><?php echo $p5; ?></a></li>
                    <?php }

                    //页数在5页以下的情况
                    else {
                        for($i = 1; $i <= $page_count; $i++) {
                            if($i == $page) echo '<li class = "active">';
                            else echo '<li>';
                            echo "<a href='index.php?r=project/index&page=$i'>$i</a></li>";
                        }
                    }
                    ?>

                    <?php if($page<$page_count) echo '<li><a href=index.php?r=project/index&page='.($page+1).'>&raquo;</a></li>'?>
                    <li><a href="index.php?r=project/index&page=<?php echo $page_count?>"><?php if($page<=$page_count-1) echo '尾页'; else echo "已是尾页";?></a></li>
                </ul>

                <div class="clearfix"></div>

            <?php } ?>
        </div>
    </div>
</div>


<script>
    function TestBlack(TagName){
        var obj = document.getElementById(TagName);
        if(obj.style.display==""){
            obj.style.display = "none";
        }else{
            obj.style.display = "";
        }
    }
</script>

<?php
//yii框架生成表格，已废弃，前台重写
//$this->widget('zii.widgets.CListView', array(
//    'dataProvider'=>$dataProvider,
//    'itemsTagName'=>'ol',
//    'itemView'=>'_view',
//));
?>
