<?php
$this->params["breadcrumbs"]=array(
	Yii::t('app','Bankbooks')=>array('index'),
	'Create',
);

$this->params["menu"]=array(
	array('label'=>Yii::t('app','Create Bankbooks'),'url'=>array('create')),
	array('label'=>Yii::t('app','Manage Bankbooks'),'url'=>array('admin')),
);

app\widgets\MiniForm::begin(array(
    'header' => Yii::t('app',"Update Bankbooks")." ".$model->id,
)); 
?>


<?php echo $this->render('_form', array('model'=>$model)); ?>

<?php app\widgets\MiniForm::end(); ?>