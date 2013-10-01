<?php
$this->breadcrumbs=array(
	'Items'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Item', 'url'=>array('index')),
	array('label'=>'Create Item', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('item-grid', {
		data: $(this).serialize()
	});
	return false;
});
");


$this->beginWidget('MiniForm',array(
    'haeder' => "Manage Items",
    //'width' => '800',
)); 
?>


<?php $this->widget('bootstrap.widgets.TbGridView', array(
	'id'=>'item-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		//'account_id',
                //array('name' => 'account_id','value' => '$data->Account->name',),
		'name',
		//'category_id',
                 array(
                    'name' => 'category_id',
                     'value' => 'isset($data->Category)?$data->Category->name:0',   //where name is Client model attribute 
                   ),
		'parent_item_id',
                
		'isProduct',
		/*
		'profit',
		'unit_id',
		'purchaseprice',
		'saleprice',
		'currency_id',
		'pic',
		'owner',
		*/
		array(
			'class'=>'CButtonColumn',
			'template'=>'{edit}{remove}{display}',
			'buttons'=>array
		    (
		        'edit' => array
		        (
                            'label'=>'<i class="icon-edit"></i>',
		            //'imageUrl'=>Yii::app()->request->baseUrl.'/images/email.png',
		            'url'=>'Yii::app()->createUrl("item/update", array("id"=>$data->id))',
		        	
		        ),
		        'remove' => array
		        (
		            'label'=>'<i class="icon-remove"></i>',
		            //'imageUrl'=>Yii::app()->request->baseUrl.'/images/email.png',
		        	'url'=>'Yii::app()->createUrl("item/delete", array("id"=>$data->id))',
		            //'url'=>'Yii::app()->createUrl("users/email", array("id"=>$data->id))',
		        ),
		        'display' => array
		        (
		            'label'=>'<i class="icon-search"></i>',
		            'url'=>'Yii::app()->createUrl("item/view", array("id"=>$data->id))',
		            //'visible'=>'$data->score > 0',
		            //'click'=>'function(){alert("Going down!");}',
		        ),
		    ),
		),
	),
)); 







 $this->endWidget(); ?>
