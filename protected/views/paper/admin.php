<?php
/* @var $this PaperController */
/* @var $model Paper */

//已废弃，菜单用前台完成
//$this->menu=array(
//    array('label'=>'列出论文', 'url'=>array('index')),
//    array('label'=>'创建论文', 'url'=>array('create')),
//    array('label'=>'导入论文', 'url'=>array('upload')),
//    array('label'=>'导出全部论文', 'url'=>array('exportAll')),
//);

//面包屑
$this->breadcrumbs=array(
    '学术成果'=>array('index'),
    '论文'=>array('index'),
    '管理',
);

?>

<div style="position:relative">
    <img src="images/lang1.jpg" alt="" />
    <div style="position:absolute;z-indent:2;left:0;top:0;">
        <br>
        <h2>管理论文</h2>
    </div>
</div>


<?php
$user = Yii::app()->user;
//admin用户才显示清空，manager才显示添加、导入
echo CHtml::link('查询与导出','#',array('class'=> 'search search-info btn btn-primary'));
if(isset($user->is_admin) && $user->is_admin || isset($user->is_manager) && $user->is_manager) {
    echo '&nbsp;&nbsp;';
    echo CHtml::link('添加论文', 'index.php?r=paper/create', array('class' => 'btn btn-primary'));
}
if(isset($user->is_admin) && $user->is_admin) {
    echo '&nbsp;&nbsp;';
    echo CHtml::link('清空论文', 'index.php?r=paper/clear', array('class' => 'btn btn-primary', 'onclick' => 'return clear_firm()'));
}

if(isset($user->is_admin) && $user->is_admin || isset($user->is_manager) && $user->is_manager) {
    echo '&nbsp;&nbsp;';
    echo CHtml::link('导入论文数据表', 'index.php?r=paper/upload', array('class' => 'btn btn-primary'));
    echo '&nbsp;&nbsp;';
    echo CHtml::link('导入论文原文', 'index.php?r=paper/uploadfile', array('class' => 'btn btn-primary'));
}
?>


<div class="search-form" style="display:none">
    <?php $this->renderPartial('_search',array(
        'now_criteria' => $now_criteria, //用于让_search显示当前的搜索条件
    )); ?>
</div>

<br><br><br>
<h4><?php echo $search_info.'如下：'; ?></h4>

<?php
$data_count = $dataProvider->itemCount;

$page = isset($page) ? $page : 1;
$page_size = 20;
$page_count = ceil($data_count/$page_size);

$offset = ($page-1) * $page_size;


if($data_count == 0) {
    echo "<br><br><br><h4>没有论文</h4><br><br>";
}
else {
?>

<?php
    //对分页URL处理
    function getPageUrl($p) {
        $queries = explode('&', $_SERVER['QUERY_STRING']); //获得当前所有GET消息
        $new_queries = array();
        foreach($queries as $query) {
            if(!preg_match('/^page=\d*$/', $query)) { //去掉page的GET消息，保留其他所有的GET消息
                $new_queries[] = $query;
            }
        }
        if($p != 1) $new_queries[] = 'page='.$p; //第一页不显示page=1

//        if(preg_match('/&page=\d*?[&$]/', $_SERVER['QUERY_STRING'])) {
//            $query_str = preg_replace('/&page=\d*?[&$]/', '', $_SERVER['QUERY_STRING']);
//        } else {
//            $query_str = $_SERVER['QUERY_STRING'];
//        }
        return 'index.php?'.implode('&', $new_queries); //以所有GET消息和页码生成URL
    }

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

            <?php if($page > 1) echo '<li><a href="'.getPageUrl(1).'">首页</a></li>'; else echo '<li><a href="#">已是首页</a></li>';?>
            <?php if($page > 1) echo '<li><a href="'.getPageUrl($page - 1).'">&laquo;</a></li>' ?>

            <?php if($page_count >= 5) { ?>
                <li <?php if($page == 1) echo 'class="active"'; ?>><a href="<?php echo getPageUrl($p1); ?>"><?php echo $p1; ?></a></li>
                <li <?php if($page == 2) echo 'class="active"'; ?>><a href="<?php echo getPageUrl($p2); ?>"><?php echo $p2; ?></a></li>
                <li <?php if($page != 1 && $page != 2 && $page != $page_count - 1 && $page != $page_count) echo 'class="active"'; ?>><a href="<?php echo getPageUrl($p3); ?>"><?php echo $p3; ?></a></li>
                <li <?php if($page == $page_count - 1) echo 'class="active"'; ?>><a href="<?php echo getPageUrl($p4); ?>"><?php echo $p4; ?></a></li>
                <li <?php if($page == $page_count) echo 'class="active"'; ?>><a href="<?php echo getPageUrl($p5); ?>"><?php echo $p5; ?></a></li>
            <?php }

            //一共还没有5页的情形
            else {
                for($i = 1; $i <= $page_count; $i++) {
                    if($i == $page) echo '<li class = "active">';
                    else echo '<li>';
                    echo '<a href="'.getPageUrl($i).'">'.$i.'</a></li>';
                }
            }
            ?>

            <?php if($page < $page_count) echo '<li><a href="'.getPageUrl($page + 1).'">&raquo;</a></li>'?>
            <?php if($page < $page_count) echo '<li><a href="'.getPageUrl($page_count).'">尾页</a></li>'; else echo '<li><a href="#">已是尾页</a></li>';?>
        </ul>
    </div>
</div>
<table class="table table-hover" width="100%">
    <thead>
    <tr>
        <th width="4%">序号</th>
        <th>论文</th>
        <th width="8%">类别</th>
        <th width="13%">作者</th>
        <?php
        //user权限不提供编辑和删除功能
        if(isset($user->is_admin) && $user->is_admin || isset($user->is_manager) && $user->is_manager) { ?>
            <th width="8%">操作</th>
        <?php } ?>
    </tr>
    </thead>
    <?php

    for($i = $offset; $i <min( $offset + $page_size, $data_count); $i++){
        ?>
        <form id="_form<?php echo $i; ?>"  name="_form<?php echo $i; ?>" method="post" action="index.php?r=paper/delete&id=<?php echo $dataProvider->getData()[$i]->id; ?>">
        <tbody>
        <tr>
            <td><?php echo $i+1;?></td>
            <td><a href="index.php?r=paper/view&id=<?php echo $dataProvider->getData()[$i]->id; ?>"><?php echo $dataProvider->getData()[$i]->info; ?></a></td>
            <td><?php
                echo $dataProvider->getData()[$i]->getCategoryString(true)?>
            </td>
            <td><?php
                //这里不能使用$dataProvider->getData()[$i]->peoples，该数组中只有一个作者，不明原因
                echo Paper::getAuthorsStatic($dataProvider->getData()[$i]->id); ?>
            </td>
            <?php
            //user权限不提供编辑和删除功能
            if(isset($user->is_admin) && $user->is_admin || isset($user->is_manager) && $user->is_manager) { ?>
                <td>
                    <a href="index.php?r=paper/update&id=<?php echo $dataProvider->getData()[$i]->id; ?>">编辑</a>&nbsp;
                    <a onclick="javascript:firm_submit(document._form<?php echo $i; ?>);">删除</a>
                </td>
            <?php } ?>
        </tr>
        </tbody>
        </form>
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

            <?php if($page > 1) echo '<li><a href="'.getPageUrl(1).'">首页</a></li>'; else echo '<li><a href="#">已是首页</a></li>';?>
            <?php if($page > 1) echo '<li><a href="'.getPageUrl($page - 1).'">&laquo;</a></li>' ?>

            <?php if($page_count >= 5) { ?>
                <li <?php if($page == 1) echo 'class="active"'; ?>><a href="<?php echo getPageUrl($p1); ?>"><?php echo $p1; ?></a></li>
                <li <?php if($page == 2) echo 'class="active"'; ?>><a href="<?php echo getPageUrl($p2); ?>"><?php echo $p2; ?></a></li>
                <li <?php if($page != 1 && $page != 2 && $page != $page_count - 1 && $page != $page_count) echo 'class="active"'; ?>><a href="<?php echo getPageUrl($p3); ?>"><?php echo $p3; ?></a></li>
                <li <?php if($page == $page_count - 1) echo 'class="active"'; ?>><a href="<?php echo getPageUrl($p4); ?>"><?php echo $p4; ?></a></li>
                <li <?php if($page == $page_count) echo 'class="active"'; ?>><a href="<?php echo getPageUrl($p5); ?>"><?php echo $p5; ?></a></li>
            <?php }

            //一共还没有5页的情形
            else {
                for($i = 1; $i <= $page_count; $i++) {
                    if($i == $page) echo '<li class = "active">';
                    else echo '<li>';
                    echo '<a href="'.getPageUrl($i).'">'.$i.'</a></li>';
                }
            }
            ?>

            <?php if($page < $page_count) echo '<li><a href="'.getPageUrl($page + 1).'">&raquo;</a></li>'?>
            <?php if($page < $page_count) echo '<li><a href="'.getPageUrl($page_count).'">尾页</a></li>'; else echo '<li><a href="#">已是尾页</a></li>';?>
        </ul>
    </div>
</div>

<?php } ?>

<script>
    function firm_submit(obj){
        if(confirm("您确定要删除这篇论文吗？")) {
            obj.submit();
        }
    }
    function clear_firm() {
        if(confirm("您确定要清空论文吗？")) {
            location.href = 'index.php?r=paper/clear';
            return true;
        }

        else {
            return false;
        }
    }

    //搜索框折叠
    $('.search-info').click(function(){
        $('.search-form').toggle();
        return false;
    });

</script>
