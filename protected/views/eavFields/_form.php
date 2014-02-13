<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'eav-fields-form',
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldRow($model,'name',array('class'=>'span5','maxlength'=>255)); ?>

	<?php echo $form->textFieldRow($model,'eavType',array('class'=>'span5','maxlength'=>255)); ?>

	<?php echo $form->textFieldRow($model,'min',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'max',array('class'=>'span5')); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? Yii::t('app',"Create") : Yii::t('app',"Save"),
		)); ?>
	</div>

<?php $this->endWidget(); ?>
