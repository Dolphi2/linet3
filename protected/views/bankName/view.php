<?php
$this->params["breadcrumbs"]=array(
	'Bank Names'=>array('index'),
	$model->name,
);

$this->params["menu"]=array(
	array('label'=>'List BankName','url'=>array('index')),
	array('label'=>'Create BankName','url'=>array('create')),
	array('label'=>'Update BankName','url'=>array('update','id'=>$model->id)),
	array('label'=>'Delete BankName','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage BankName','url'=>array('admin')),
);
?>

<h1>View BankName #<?php echo $model->id; ?></h1>

<?= kartik\detail\DetailView::widget(array(
	'model'=>$model,
	'attributes'=>array(
		'id',
		'name',
	),
)); ?>
