<?php 
//$this->widget('zii.widgets.CListView', array(
//	'dataProvider'=>$dataProvider,
//	'itemView'=>'_view',
//)); ?>

<?php $this->widget('bootstrap.widgets.TbGridView', array(
	'id'=>'accounts-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
     /*'pager' => array('class' => 'CLinkPager', 'header' => '',
         'firstPageLabel' => '&lt;&lt;',
        'prevPageLabel'  => '<img src="images/pagination/left.png">',
        'nextPageLabel'  => '<img src="images/pagination/right.png">',
        'lastPageLabel'  => '&gt;&gt;',
         'pageSize'=>100,
         
         ),
    'template'=>'{pager}{items}{pager}',*/
	'columns'=>array(
		'id',
		//'prefix',
		//'company',
		array(
	            'name' => 'name',
	            'type' => 'raw',
	            'value' => 'CHtml::link(CHtml::encode($data->name), "index.php?r=accounts/update&id=".CHtml::encode($data->id))',
	        ),
		//'type',
		'id6111',
		'pay_terms',
		'src_tax',
		/*
		'src_date',
		'grp',
		'company',
		'contact',
		'department',
		'vatnum',
		'email',
		'phone',
		'dir_phone',
		'cellular',
		'fax',
		'web',
		'address',
		'city',
		'zip',
		'comments',
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
		            'url'=>'Yii::app()->createUrl("accounts/update", array("id"=>$data->id))',
		        	
		        ),
		        'remove' => array
		        (
		            'label'=>'<i class="icon-remove"></i>',
		            //'imageUrl'=>Yii::app()->request->baseUrl.'/images/email.png',
		        	'url'=>'Yii::app()->createUrl("accounts/delete", array("id"=>$data->id))',
		            //'url'=>'Yii::app()->createUrl("users/email", array("id"=>$data->id))',
		        ),
		        'display' => array
		        (
		            'label'=>'<i class="icon-search"></i>',
		            'url'=>'Yii::app()->createUrl("accounts/transaction", array("id"=>$data->id))',
		            //'visible'=>'$data->score > 0',
		            'click'=>'function(){alert("Going down!");}',
		        ),
		    ),
		),
	),
)); ?>
