<div class="form">

<?php $form=$this->beginWidget('CActiveForm'); ?>
	
	
		<?php echo $form->dropDownList($model, 'itemname', $itemnameSelectOptions); ?>
		<?php echo $form->error($model, 'itemname'); ?>
	
	
	<div class="buttons">
		<?php echo CHtml::submitButton(Rights::t('core', 'Add')); ?>
	</div>
<br /><br /><br /><br /><br /><br />
<?php $this->endWidget(); ?>

</div>