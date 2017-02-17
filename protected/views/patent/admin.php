<?php
/* @var $this PatentController */
/* @var $model Patent */


$this->pageTitle=Yii::app()->name . ' - 管理专利';
//面包屑
$this->breadcrumbs=array(
    '学术成果'=>array('index'),
    '专利'=>array('index'),
    '管理',
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
$data_count = $dataProvider->itemCount;

$page = isset($page) ? $page : 1;
$page_size = 20;
$page_count = ceil($data_count/$page_size);

$offset = ($page-1) * $page_size;
?>

<div class="cam-page-header">
    <div class="cam-wrap clearfix cam-local-navigation">
        <ul class="cam-unstyled-list cam-current">
            <li><a href="index.php?r=paper/admin">论文</a></li>
            <li class="cam-current-page"><a href="index.php?r=patent/admin" class="active-trail">专利</a></li>
            <li><a href="index.php?r=publication/admin">著作</a></li>
            <li><a href="index.php?r=software/admin">软件著作权</a></li>
        </ul>
    </div>
    <div class="cam-wrap clearfix cam-page-sub-title cam-recessed-sub-title">
        <div class="cam-column">
            <div class="cam-content-container">
                <h1 class="cam-sub-title">
                    管理专利 Manage patent
                </h1>
            </div>
        </div>
    </div>
</div>
<div class="cam-content cam-recessed-content">
    <div class="cam-wrap clearfix">
        <ul class="index-list">
            <li><a href="#" class="search search-info">查询与导出</a></li>
            <?php if(isset($user->is_admin) && $user->is_admin || isset($user->is_manager) && $user->is_manager) { ?>
                <li><a href="index.php?r=patent/create" style="width: 150px">添加专利</a></li>
                <li><a href="index.php?r=patent/upload">导入专利数据表</a></li>
                <li><a href="index.php?r=patent/uploadfile">导入专利文件</a></li>
            <?php } ?>
            <?php if(isset($user->is_admin) && $user->is_admin) { ?>
                <li><a href="index.php?r=patent/clear" style="width: 150px" onclick="return clear_firm()">清空专利</a></li>
                <div class="clearfix"></div>
            <?php } ?>
        </ul>
        <div class="clearfix"></div>
        <div class="search-form" style="display:none">
            <?php $this->renderPartial('_search',array(
                'now_criteria' => $now_criteria, //用于让_search显示当前的搜索条件
            )); ?>
        </div>
        <div class="index-content">
            <?php
            echo "<p>在团队数据库中，".$search_info."一共有 $data_count 项";
            echo $data_count == 0 ? "。</p>" : "，当前页显示第 ".($offset + 1)." - ".min( $offset + $page_size, $data_count)." 项，共 $page_count 页。";
            if($data_count == 0) {
                echo '<img style="margin: 10px 0 20px 0;" src="'.Yii::app()->request->baseUrl.'/images/no_data.png"/>';
            } else {
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

                <table class="index-table index-table-hover">
                    <thead>
                    <tr>
                        <th style="width:40px; text-align: center">序号</th>
                        <th>专利</th>
                        <th style="width:100px;">专利号</th>
                        <th style="width:40px;">级别</th>
                        <th style="width:70px;">类别</th>
                        <th style="width:150px;">发明人</th>
                        <?php
                        //user权限不提供编辑和删除功能
                        if(isset($user->is_admin) && $user->is_admin || isset($user->is_manager) && $user->is_manager) { ?>
                            <th style="width:80px;">操作</th>
                        <?php } ?>
                    </tr>
                    </thead>
                    <?php

                    for($i = $offset; $i <min( $offset + $page_size, $data_count); $i++){
                        ?>
                        <form id="_form<?php echo $i; ?>"  name="_form<?php echo $i; ?>" method="post" action="index.php?r=patent/delete&id=<?php echo $dataProvider->getData()[$i]->id; ?>">
                            <tbody>
                            <tr>
                                <td class="index-table-id"><?php echo $i+1;?></td>
                                <td><a href="index.php?r=patent/view&id=<?php echo $dataProvider->getData()[$i]->id; ?>"><?php echo $dataProvider->getData()[$i]->getContentToGuest(); ?></a></td>
                                <td><?php
                                    echo $dataProvider->getData()[$i]->number; ?>
                                </td>
                                <td><?php
                                    echo $dataProvider->getData()[$i]->level; ?>
                                </td>
                                <td><?php
                                    echo $dataProvider->getData()[$i]->category; ?>
                                </td>
                                <td><?php
                                    //这里不能使用$dataProvider->getData()[$i]->peoples，该数组中只有一个作者，不明原因
                                    echo Patent::getAuthorsStatic($dataProvider->getData()[$i]->id); ?>
                                </td>
                                <?php
                                //user权限不提供编辑和删除功能
                                if(isset($user->is_admin) && $user->is_admin || isset($user->is_manager) && $user->is_manager) { ?>
                                    <td>
                                        <a href="index.php?r=patent/update&id=<?php echo $dataProvider->getData()[$i]->id; ?>">编辑</a>&nbsp;
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
                <div class="clearfix"></div>
            <?php } ?>
        </div>
    </div>
</div>

<script>
    function firm_submit(obj){
        if(confirm("您确定要删除这项专利吗？")) {
            obj.submit();
        }
    }
    function clear_firm() {
        if(confirm("您确定要清空专利吗？")) {
            location.href = 'index.php?r=patent/clear';
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
