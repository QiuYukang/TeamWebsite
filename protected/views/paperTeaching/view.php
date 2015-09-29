<?php
/* @var $this PaperTeachingController */
/* @var $model PaperTeaching */

$this->breadcrumbs=array(
	'Paper Teachings'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List PaperTeaching', 'url'=>array('index')),
	array('label'=>'Create PaperTeaching', 'url'=>array('create')),
	array('label'=>'Update PaperTeaching', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete PaperTeaching', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage PaperTeaching', 'url'=>array('admin')),
);
?>

<h1>View PaperTeaching #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'info',
        array(
            'label'=>'作者',
            'type'=>'raw',
            'value'=>$model->getPeoples(),
        ),
        array(
            'label'=>'状态',
            'type'=>'raw',
            'value'=>$model->getStatusString(),
        ),
        array(
            'label'=>'级别',
            'type'=>'raw',
            'value'=>$model->getLevelString(),
        ),
		'pass_date',
		'pub_date',
		'index_date',
		'sci_number',
		'ei_number',
		'istp_number',
        array(
            'label'=>'支助项目',
            'type'=>'raw',
            'value'=>$model->getFundProjects(),
        ),
        array(
            'label'=>'报账项目',
            'type'=>'raw',
            'value'=>$model->getReimProjects(),
        ),
        array(
            'label'=>'成果项目',
            'type'=>'raw',
            'value'=>$model->getAchievementProjects(),
        ),
        array(
            'label'=>'维护人员',
            'type'=>'raw',
            'value'=>
                isset($model->maintainer) ? 
                $model->maintainer->name :
                null,
        ),
	),
)); ?>
