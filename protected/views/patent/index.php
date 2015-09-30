<?php
/* @var $this PatentController */
/* @var $dataProvider CActiveDataProvider */



//面包屑
$this->breadcrumbs=array(
    '学术成果'=>array('paper/index'),
    '专利',
);

?>
<style>
    li.patent {
        margin-bottom: 10px;
    }
</style>


<div style="position:relative">
    <img src="images/lang1.jpg" alt="" />
    <div style="position:absolute;z-indent:2;left:0;top:0;">
        <br>
        <h2>专利</h2>
    </div>
</div>

<?php
//权限用户显示功能按钮
$user = Yii::app()->user;
if((isset($user->is_admin) && $user->is_admin) ||
    (isset($user->is_manager) && $user->is_manager) ||
    (isset($user->is_user) && $user->is_user)) {
    echo CHtml::link('管理专利', 'index.php?r=patent/admin', array('class' => 'btn btn-primary'));
}

?>

<?php
//分页过程
$data_count = $dataProvider->itemCount;

$page = isset($page) ? $page : 1;
$page_size = 20;
$page_count = ceil($data_count/$page_size);

$offset = ($page-1) * $page_size;

if($data_count == 0) {
    echo "<br><br><br><h4>没有专利</h4><br><br>";
}

else {
    ?>

    <?php
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

    <div class="row">
        <div class="col-xs-8">
        </div>
        <div class="col-xs-4">
            <ul class="pagination">

                <?php  if($page!=1) echo '<li><a href="index.php?r=patent/index&page=1">首页</a></li>'; else echo '<li><a href="#">已是首页</a></li>';?>
    <?php if($page!=1) echo '<li><a href=index.php?r=patent/index&page='.($page-1).'>&laquo;</a></li>' ?>

    <?php if($page_count >= 5) { ?>
        <li <?php if($page == 1) echo 'class="active"'; ?>><a href="index.php?r=patent/index&page=<?php echo $p1; ?>"><?php echo $p1; ?></a></li>
        <li <?php if($page == 2) echo 'class="active"'; ?>><a href="index.php?r=patent/index&page=<?php echo $p2; ?>"><?php echo $p2; ?></a></li>
        <li <?php if($page != 1 && $page != 2 && $page != $page_count - 1 && $page != $page_count) echo 'class="active"'; ?>><a href="index.php?r=patent/index&page=<?php echo $p3; ?>"><?php echo $p3; ?></a></li>
        <li <?php if($page == $page_count - 1) echo 'class="active"'; ?>><a href="index.php?r=patent/index&page=<?php echo $p4; ?>"><?php echo $p4; ?></a></li>
        <li <?php if($page == $page_count) echo 'class="active"'; ?>><a href="index.php?r=patent/index&page=<?php echo $p5; ?>"><?php echo $p5; ?></a></li>
    <?php }

    //页数在5页以下的情况
    else {
        for($i = 1; $i <= $page_count; $i++) {
            if($i == $page) echo '<li class = "active">';
            else echo '<li>';
            echo "<a href='index.php?r=patent/index&page=$i'>$i</a></li>";
        }
    }
    ?>

    <?php if($page<$page_count) echo '<li><a href=index.php?r=patent/index&page='.($page+1).'>&raquo;</a></li>'?>
                <li><a href="index.php?r=patent/index&page=<?php echo $page_count?>"><?php if($page<=$page_count-1) echo '尾页'; else echo "已是尾页";?></a></li>
            </ul>
        </div>
    </div>
<table class="table table-hover">
    <thead>
    <tr>
        <th>序号</th>
        <th>信息</th>
    </tr>
    </thead>
        <?php

    for($i = $offset; $i <min( $offset + $page_size, $data_count); $i++){
        ?>
        <tbody>
        <tr>
            <td width="4%">&nbsp;&nbsp;&nbsp;<?php echo $i+1;?>&nbsp;&nbsp;&nbsp;</td>
            <td><?php echo $dataProvider->getData()[$i]->getContentToGuest(); ?>
            <?php if(!empty($dataProvider->getData()[$i]->abstract)) { ?>
                &nbsp;&nbsp;<a onclick="javascript:TestBlack('divc<?php echo $i;?>');">更多</a></td>
            <?php } ?>
        </tr>
        <tr id="divc<?php echo $i;?>" style="display: none">
            <td></td>
            <td><?php /*信息*/ echo $dataProvider->getData()[$i]->abstract;?></td>
        </tr>
        </tbody>
    <?php
    }
    ?>
</table>
    <div class="row">
        <div class="col-xs-8">
            <h4>&nbsp;&nbsp;页次:<?php echo $page;?>/<?php echo $page_count;?>页
            &nbsp;&nbsp;&nbsp;记录:<?php echo $data_count;?> 条&nbsp;</h4>
        </div>
        <div class="col-xs-4">
            <ul class="pagination">

                <?php  if($page!=1) echo '<li><a href="index.php?r=patent/index&page=1">首页</a></li>'; else echo '<li><a href="index.php?r=patent/index&page=1">已是首页</a></li>';?>
    <?php if($page!=1) echo '<li><a href=index.php?r=patent/index&page='.($page-1).'>&laquo;</a></li>' ?>

    <?php if($page_count >= 5) { ?>
        <li <?php if($page == 1) echo 'class="active"'; ?>><a href="index.php?r=patent/index&page=<?php echo $p1; ?>"><?php echo $p1; ?></a></li>
        <li <?php if($page == 2) echo 'class="active"'; ?>><a href="index.php?r=patent/index&page=<?php echo $p2; ?>"><?php echo $p2; ?></a></li>
        <li <?php if($page != 1 && $page != 2 && $page != $page_count - 1 && $page != $page_count) echo 'class="active"'; ?>><a href="index.php?r=patent/index&page=<?php echo $p3; ?>"><?php echo $p3; ?></a></li>
        <li <?php if($page == $page_count - 1) echo 'class="active"'; ?>><a href="index.php?r=patent/index&page=<?php echo $p4; ?>"><?php echo $p4; ?></a></li>
        <li <?php if($page == $page_count) echo 'class="active"'; ?>><a href="index.php?r=patent/index&page=<?php echo $p5; ?>"><?php echo $p5; ?></a></li>
    <?php }

    //页数在5页以下的情况
    else {
        for($i = 1; $i <= $page_count; $i++) {
            if($i == $page) echo '<li class = "active">';
            else echo '<li>';
            echo "<a href='index.php?r=patent/index&page=$i'>$i</a></li>";
        }
    }
    ?>

    <?php if($page<$page_count) echo '<li><a href=index.php?r=patent/index&page='.($page+1).'>&raquo;</a></li>'?>
                <li><a href="index.php?r=patent/index&page=<?php echo $page_count?>"><?php if($page<=$page_count-1) echo '尾页'; else echo "已是尾页";?></a></li>
            </ul>
        </div>
    </div>

</br></br></br></br></br>


<?php } ?>
<script>
    function firm() {
        if(confirm("您确定要清空专利吗？")) {
            location.href = 'index.php?r=patent/clear';
            return true;
        }
        else {
            return false;
        }
    }

    function TestBlack(TagName){
        var obj = document.getElementById(TagName);
        if(obj.style.display==""){
            obj.style.display = "none";
        }else{
            obj.style.display = "";
        }
    }
</script>


