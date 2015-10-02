<?php
/* @var $this PeopleController */
/* @var $model People */

//面包屑
$this->breadcrumbs=array(
    '团队人员',
);
?>

<div style="position:relative">
    <img src="images/lang1.jpg" alt="" />
    <div style="position:absolute;z-indent:2;left:0;top:0;">
        <br>
        <h2>团队人员</h2>
    </div>
</div>

<?php
$user = Yii::app()->user;
if(isset($user->is_admin) && $user->is_admin || isset($user->is_manager) && $user->is_manager) {
echo '&nbsp;&nbsp;';
echo CHtml::link('添加人员', 'index.php?r=people/create', array('class' => 'btn btn-primary'));
}
if(isset($user->is_admin) && $user->is_admin) {
    echo '&nbsp;&nbsp;';
    echo CHtml::link('清空人员', 'index.php?r=people/clear', array('class' => 'btn btn-primary', 'onclick' => 'return clear_firm()'));
}
if(isset($user->is_admin) && $user->is_admin || isset($user->is_manager) && $user->is_manager) {
    echo '&nbsp;&nbsp;';
    echo CHtml::link('导入人员数据表', 'index.php?r=people/upload', array('class' => 'btn btn-primary'));

}if(isset($user->is_admin) && $user->is_admin || isset($user->is_manager) && $user->is_manager) {
    echo '&nbsp;&nbsp;';
    echo CHtml::link('导出人员数据表', 'index.php?r=people/export', array('class' => 'btn btn-primary'));
}

?>

<br><br><br>

<table class="table table-striped">
    <tbody>
<?php
echo '<tr>';
$cnt = 0;
foreach($dataProvider->getData() as $data) {
    if(($cnt % 10) == 0) {
        echo '</tr><tr>';
    }
    echo '<td>'.CHtml::link(CHtml::encode($data->name), array('people/view', 'id'=>$data->id)).'</td>';
    $cnt++;
}
//用空白补充一行剩下的
$blank = 10 - count($dataProvider->getData()) % 10;
if($blank != 10) {
    while($blank--) echo '<td></td>';
}

echo '</tr>';
?>
    </tbody>
</table>

<script>
    function clear_firm() {
        if(confirm("您确定要清空人员吗？")) {
            location.href = 'index.php?r=people/clear';
            return true;
        }

        else {
            return false;
        }
    }

</script>
