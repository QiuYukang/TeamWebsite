<?php
/* @var $this UserController */
/* @var $model User */

$this->pageTitle=Yii::app()->name . ' - 用户管理';
//面包屑
$this->breadcrumbs=array(
    '用户管理',
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
$arr_admin = array();
$arr_manager = array();
$arr_user = array();
foreach($dataProvider->getData() as $data) {
    if($data->id == Yii::app()->user->id) continue;
    if($data->is_admin == 1) $arr_admin[] = $data;
    if($data->is_manager == 1) $arr_manager[] = $data;
    if($data->is_user == 1) $arr_user[] = $data;
}

?>

<div class="cam-page-header">
    <div class="cam-wrap clearfix cam-page-sub-title cam-recessed-sub-title">
        <div class="cam-column">
            <div class="cam-content-container">
                <h1 class="cam-sub-title">
                    用户管理 Manage user
                </h1>
            </div>
        </div>
    </div>
</div>
<div class="cam-content cam-recessed-content">
    <div class="cam-wrap clearfix">
        <ul class="index-list">
            <?php if(isset($user->is_admin) && $user->is_admin) { ?>
                <li><a href="index.php?r=user/create" style="width: 160px">添加用户</a></li>
                <li><a href="index.php?r=user/upload">导入用户数据表</a></li>
                <li><a href="index.php?r=user/clear" onclick="return clear_firm()">清空用户</a></li>
            <?php } ?>
        </ul>
        <div class="clearfix"></div>
        <div class="index-content">
            <p style="margin-bottom: 5px">用户共有3种权限，超级管理员权限、管理员权限、普通用户权限。</p>
            <p style="margin-bottom: 5px">您当前登陆的超级管理员用户如下，为了保证用户中至少有一个超级管理员权限，您不能删除当前登录的用户，点击修改密码。</p>
            <table class="index-table index-table-hover">
                <tbody>
                    <tr></tr>
                    <tr>
                        <td><a href="index.php?r=user/setting"><?php echo Yii::app()->user->name; ?></a></td>
                    </tr>
                </tbody>
            </table>

            <?php if(count($arr_admin) != 0) { ?>
            <p style="margin-bottom: 5px">其他超级管理员用户如下，点击修改或删除用户。</p>
            <table class="index-table index-table-hover">
                <tbody>
                <?php
                echo '<tr>';
                $cnt = 0;
                foreach($arr_admin as $data) {
                    if(($cnt % 10) == 0) {
                        echo '</tr><tr>';
                    }
                    echo '<td width="10%">'.CHtml::link(CHtml::encode($data->username), array('user/update', 'id'=>$data->id)).'</td>';
                    $cnt++;
                }
                //用空白补充一行剩下的
                $blank = 10 - count($arr_admin) % 10;
                if($blank != 10) {
                    while($blank--) echo '<td width="10%"></td>';
                }
                echo '</tr>';
                ?>
                </tbody>
            </table>
            <?php } else { ?>
            <p style="margin: -10px 0 15px 0">暂时没有其他超级管理员用户。</p>
            <?php } ?>

            <?php if(count($arr_manager) != 0) { ?>
            <p style="margin-bottom: 5px">所有管理员用户如下，点击修改或删除用户。</p>
            <table class="index-table index-table-hover">
                <tbody>
                <?php
                echo '<tr>';
                $cnt = 0;
                foreach($arr_manager as $data) {
                    if(($cnt % 10) == 0) {
                        echo '</tr><tr>';
                    }
                    echo '<td width="10%">'.CHtml::link(CHtml::encode($data->username), array('user/update', 'id'=>$data->id)).'</td>';
                    $cnt++;
                }
                //用空白补充一行剩下的
                $blank = 10 - count($arr_manager) % 10;
                if($blank != 10) {
                    while($blank--) echo '<td width="10%"></td>';
                }
                echo '</tr>';
                ?>
                </tbody>
            </table>
            <?php } ?>

            <?php if(count($arr_user) != 0) { ?>
            <p style="margin-bottom: 5px">所有普通用户如下，点击修改或删除用户。</p>
            <table class="index-table index-table-hover">
                <tbody>
                <?php
                echo '<tr>';
                $cnt = 0;
                foreach($arr_user as $data) {
                    if(($cnt % 10) == 0) {
                        echo '</tr><tr>';
                    }
                    echo '<td width="10%">'.CHtml::link(CHtml::encode($data->username), array('user/update', 'id'=>$data->id)).'</td>';
                    $cnt++;
                }
                //用空白补充一行剩下的
                $blank = 10 - count($arr_user) % 10;
                if($blank != 10) {
                    while($blank--) echo '<td width="10%"></td>';
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
        if(confirm("您确定要清空用户吗？")) {
            location.href = 'index.php?r=user/clear';
            return true;
        }

        else {
            return false;
        }
    }

</script>
