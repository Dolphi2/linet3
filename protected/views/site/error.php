<?php
$this->pageTitle=Yii::app()->name . ' - Error';
 $this->beginWidget('MiniForm',array(
    'haeder' => Yii::t('app',"Error"),
)); 
?>

<h2>Error <?php echo $code; ?></h2>

<div class="error">
<?php echo CHtml::encode($message); ?>
</div>

<?php $this->endWidget(); ?>