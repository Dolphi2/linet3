<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'bank-name-form',
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<?php //echo $form->textFieldRow($model,'id',array('class'=>'span5')); ?>

        <?php echo $form->labelEx($model, 'date'); ?>
                <?php
                $this->widget('application.extensions.CJuiDateTimePicker.CJuiDateTimePicker', array(
                    'model' => $model, //Model object
                    'attribute' => 'date', //attribute name
                    'mode' => 'date',
                    'language' => substr(Yii::app()->language, 0, 2),
                    'options' => array(
                        'showAnim' => 'fold',
                        'dateFormat' => Yii::app()->locale->getDateFormat('short'),
                    ) // jquery plugin options
                ));
                ?>
                <?php echo $form->error($model, 'date'); ?>


        <?php echo $form->textFieldRow($model,'details'); ?>

        <?php echo $form->textFieldRow($model,'refnum'); ?>

        <?php echo $form->textFieldRow($model,'sum'); ?>
        
        <?php echo $form->textFieldRow($model,'currency_id'); ?>
            
        <?php echo $form->textFieldRow($model,'account_id'); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? Yii::t('app',"Create") : Yii::t('app',"Save"),
		)); ?>
	</div>

<?php $this->endWidget(); ?>
