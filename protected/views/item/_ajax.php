<?php 
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



$this->widget('bootstrap.widgets.TbGridView', array(
	'id'=>'item-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
        'template' => '{items}{pager}',
        'ajaxUpdate'=>true,
        'ajaxType'=>'POST',
	'columns'=>array(
		'id',
		//'account_id',
                //array('name' => 'account_id','value' => '$data->Account->name',),
		'name',
		//'category_id',
                 array(
                    'name' => 'category_id',
                     'filter'=>CHtml::listData(Itemcategory::model()->findAll(), 'id', 'name'),
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
			'class'=>'bootstrap.widgets.TbButtonColumn',
		),
            /*
		array(
			'class'=>'CButtonColumn',
			'template'=>'{edit}{remove}{display}',
			'buttons'=>array
		    (
		        'edit' => array
		        (
                            'label'=>'<i class="glyphicon glyphicon-edit"></i>',
		            //'imageUrl'=>Yii::app()->request->baseUrl.'/images/email.png',
		            'url'=>'Yii::app()->createUrl("item/update", array("id"=>$data->id))',
		        	
		        ),
		        'remove' => array
		        (
		            'label'=>'<i class="glyphicon glyphicon-remove"></i>',
		            //'imageUrl'=>Yii::app()->request->baseUrl.'/images/email.png',
		        	'url'=>'Yii::app()->createUrl("item/delete", array("id"=>$data->id))',
		            //'url'=>'Yii::app()->createUrl("users/email", array("id"=>$data->id))',
		        ),
		        'display' => array
		        (
		            'label'=>'<i class="glyphicon glyphicon-search"></i>',
		            'url'=>'Yii::app()->createUrl("item/view", array("id"=>$data->id))',
		            //'visible'=>'$data->score > 0',
		            //'click'=>'function(){alert("Going down!");}',
		        ),
		    ),
		),*/
	),
)); 
?>





