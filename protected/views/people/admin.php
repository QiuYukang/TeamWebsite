<?php
/* @var $this PeopleController */
/* @var $model People */

$this->pageTitle=Yii::app()->name . ' - 团队成员';
//面包屑
$this->breadcrumbs=array(
    '团队成员',
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


<div class="cam-page-header">
    <div class="cam-wrap clearfix cam-page-sub-title cam-recessed-sub-title">
        <div class="cam-column">
            <div class="cam-content-container">
                <h1 class="cam-sub-title">
                    团队成员 Team members
                </h1>
            </div>
        </div>
    </div>
</div>
<div class="cam-content cam-recessed-content">
    <div class="cam-wrap clearfix">
        <ul class="index-list">
            <?php if(isset($user->is_admin) && $user->is_admin || isset($user->is_manager) && $user->is_manager) { ?>
                <li><a href="index.php?r=people/create">添加成员</a></li>
                <li><a href="index.php?r=people/upload">导入成员数据表</a></li>
                <li><a href="index.php?r=people/export">导出成员数据表</a></li>
            <?php } ?>
            <?php if(isset($user->is_admin) && $user->is_admin) { ?>
                <li><a href="index.php?r=people/clear" onclick="return clear_firm()">清空成员</a></li>
                <div class="clearfix"></div>
            <?php } ?>
        </ul>
        <div class="clearfix"></div>

        <div class="index-content">
            <?php if(count($dataProvider->getData()) == 0) {
            echo '<p>团队数据库中暂时没有记载团队成员数据。</p>';
            echo '<img style="margin: 10px 0 20px 0;" src="'.Yii::app()->request->baseUrl.'/images/no_data.png"/>';
            } else { ?>
            <p>在团队数据库中，所有团队成员（按教师、学生、合作者顺序，同一类别中按拼音首字母排序）如下。</p>
            <br/>
            <table class="index-table index-table-hover">
                <tbody>
                <?php
                echo '<tr>';
                $cnt = 0;
                $pos = People::POSITION_TEACHER;
                foreach($dataProvider->getData() as $data) {
                    if($data->position != $pos) {
                        //用空白补充一行剩下的
                        $blank = 10 - $cnt % 10;
                        if($blank != 10) {
                            while($blank--) echo '<td></td>';
                        }
                        echo '</tr></tbody></table><table class="index-table index-table-hover"><tbody><tr>';
                        $cnt = 0;
                        $pos = $data->position;
                    } else if(($cnt % 10) == 0) {
                        echo '</tr><tr>';
                    }
                    echo '<td>'.CHtml::link(CHtml::encode($data->name), array('people/view', 'id'=>$data->id)).'</td>';
                    $cnt++;
                }
                //用空白补充一行剩下的
                $blank = 10 - $cnt % 10;
                if($blank != 10) {
                    while($blank--) echo '<td></td>';
                }

                echo '</tr>';
                ?>
                </tbody>
            </table>
            <?php } ?>
        </div>
    </div>
</div>

<script>
    function clear_firm() {
        if(confirm("您确定要清空团队成员吗？")) {
            location.href = 'index.php?r=people/clear';
            return true;
        }

        else {
            return false;
        }
    }

</script>
