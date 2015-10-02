<?php
/* @var $this UserController */
/* @var $model User */

//面包屑
$this->breadcrumbs=array(
    '用户管理',
);
?>

<div style="position:relative">
    <img src="images/lang1.jpg" alt="" />
    <div style="position:absolute;z-indent:2;left:0;top:0;">
        <br>
        <h2>用户管理</h2>
    </div>
</div>

<?php
$user = Yii::app()->user;
if(isset($user->is_admin) && $user->is_admin || isset($user->is_manager) && $user->is_manager) {
    echo CHtml::link('添加用户', 'index.php?r=user/create', array('class' => 'btn btn-primary'));
}
if(isset($user->is_admin) && $user->is_admin) {
    echo '&nbsp;&nbsp;';
    echo CHtml::link('清空用户', 'index.php?r=user/clear', array('class' => 'btn btn-primary', 'onclick' => 'return clear_firm()'));
}
if(isset($user->is_admin) && $user->is_admin || isset($user->is_manager) && $user->is_manager) {
    echo '&nbsp;&nbsp;';
    echo CHtml::link('导入用户数据表', 'index.php?r=user/upload', array('class' => 'btn btn-primary'));

}

?>

<br><br><br>

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

<p>您登陆的用户(超级管理员权限)： <?php echo Yii::app()->user->name; ?></p>

<br/>

<p>其余超级管理员权限： <?php if(count($arr_admin) == 0) echo '无'; ?></p>
<table class="table table-striped">
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


<p>管理员权限： <?php if(count($arr_manager) == 0) echo '无'; ?></p>
<table class="table table-striped">
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


<p>用户权限： <?php if(count($arr_user) == 0) echo '无'; ?></p>
<table class="table table-striped">
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
<hr/>

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
