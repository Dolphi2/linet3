<div class="view">

	<b><?php echo \yii\helpers\Html::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo \yii\helpers\Html::link(\yii\helpers\Html::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />

	<b><?php echo \yii\helpers\Html::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo \yii\helpers\Html::encode($data->name); ?>
	<br />

	<b><?php echo \yii\helpers\Html::encode($data->getAttributeLabel('eavType')); ?>:</b>
	<?php echo \yii\helpers\Html::encode($data->eavType); ?>
	<br />

	<b><?php echo \yii\helpers\Html::encode($data->getAttributeLabel('min')); ?>:</b>
	<?php echo \yii\helpers\Html::encode($data->min); ?>
	<br />

	<b><?php echo \yii\helpers\Html::encode($data->getAttributeLabel('max')); ?>:</b>
	<?php echo \yii\helpers\Html::encode($data->max); ?>
	<br />


</div>