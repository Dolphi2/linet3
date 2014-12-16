<?php

$this->beginWidget('MiniForm', array(
    'header' => Yii::t('app', "Customers owing money"),
));


$this->widget('EExcelView', array(
    'id' => 'accounts-grid',
    'dataProvider' => $model->owes(),
     'pager' =>false,
    //'filter'=>$model,
    'columns' => array(
        'id',
        array(
            'name' => 'name',
            'type' => 'raw',
            'value' => 'CHtml::link(CHtml::encode($data["name"]), Yii::app()->createAbsoluteUrl("/accounts/transaction/".CHtml::encode($data["id"])))',
        ),
        //'type',
         
        array(
            'cssClassExpression' => "'number'",
            'name'=>'sum',
        )
          
    ),
));

$this->endWidget();
?>
