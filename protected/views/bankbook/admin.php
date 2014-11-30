<?php

$this->menu=array(
	//array('label'=>'List Doctype', 'url'=>array('index')),
	array('label'=>Yii::t('app','Create Bankbook'), 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('doctype-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
$this->beginWidget('MiniForm',array(
    'header' => Yii::t('app',"Manage Bankbooks"),
)); 
?>

 <?php 
 
 $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'user-form',
	'enableAjaxValidation'=>false,
     'htmlOptions' => array('enctype' => 'multipart/form-data'),
        )
    );
 
    $temp=CHtml::listData(Accounts::model()->AutoComplete('',7), 'value', 'label');
    $temp[0]=Yii::t('app','Chose Bank');
    $model->account_id=0;
 
        echo $form->dropDownList($model, "account_id", $temp,array('class'=>''));
        ?>
<div id ="result">
    <br />
    <br />
    <br />
    <br />
    <br />
    <br />
    <br />
    <br />
    <br />
</div>

<?php
 $this->endWidget();
 $this->endWidget();
?>

<script type="text/javascript">
    jQuery(document).ready(function(){
        $( "#Bankbook_account_id" ).change(function() {
            var value=$("#Bankbook_account_id").val();

            $.post( "<?php echo $this->createUrl('/bankbook/ajax');?>", { Bankbook: {account_id: value}} ).done(
                function( data )
                {
                    $( "#result" ).html( data );
                }
        
        );
          });



    });
        
</script>