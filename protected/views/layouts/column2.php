<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>

	
	
		<?php echo $content; ?>
	
	
<!-- 	<div class="small-3 columns" id="sidebar">
		<?php
			$this->beginWidget('zii.widgets.CPortlet', array(
				'title'=>'Operations',
			));
			$this->widget('zii.widgets.CMenu', array(
				'items'=>$this->menu,
				'htmlOptions'=>array('class'=>'operations'),
			));
			$this->endWidget();
		?>
	</div> -->


<?php $this->endContent(); ?>
