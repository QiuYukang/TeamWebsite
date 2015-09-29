<?php
/* @var $this CourseController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'教学课程',
);

$this->menu=array(
	array('label'=>'Create Course', 'url'=>array('create')),
	array('label'=>'Manage Course', 'url'=>array('admin')),
);
?>

<h1>教学课程</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
<script>
    $(document).ready(function(){
        $('.more').click(function (e) {
            e.preventDefault();
            //console.log(e);
            var text = ($(this).text() == "更多") ? "收起" : "更多";
            $(this).siblings('.abstract').fadeToggle();
            $(this).text(text);
        });
    })
    // $(document).on('click','.more',function(e) {
    //     e.preventDefault();
    //     var text = ($(this).text() == "更多") ? "收起" : "更多";
    //     $(this).siblings('.abstract').fadeToggle();
    //     $(this).text(text);
    // });
</script>
