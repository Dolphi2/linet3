<?php

//$this->widget('zii.widgets.CListView', array(
//	'dataProvider'=>$dataProvider,
//	'itemView'=>'_view',
//)); 
$dateisOn = $this->widget('zii.widgets.jui.CJuiDatePicker', array(
            // 'model'=>$model,
            'name' => 'Transactions[from_date]',
            'language' => substr(Yii::app()->language, 0, 2),
            'value' => $model->from_date,
            // additional javascript options for the date picker plugin
            'options' => array(
                'showAnim' => 'fold',
                'dateFormat' => Yii::app()->locale->getDateFormat('short'),
                'changeMonth' => 'true',
                'changeYear' => 'true',
                'constrainInput' => 'false',
            ),
            'htmlOptions' => array(
                'style' => 'height:20px;width:70px;',
            ),
// DONT FORGET TO ADD TRUE this will create the datepicker return as string
                ), true) . '<br> To <br> ' . $this->widget('zii.widgets.jui.CJuiDatePicker', array(
            // 'model'=>$model,
            'name' => 'Transactions[to_date]',
            'language' => substr(Yii::app()->language, 0, 2),
            'value' => $model->to_date,
            // additional javascript options for the date picker plugin
            'options' => array(
                'showAnim' => 'fold',
                'dateFormat' => Yii::app()->locale->getDateFormat('short'),
                'changeMonth' => 'true',
                'changeYear' => 'true',
                'constrainInput' => 'false',
            ),
            'htmlOptions' => array(
                'style' => 'height:20px;width:70px',
            ),
// DONT FORGET TO ADD TRUE this will create the datepicker return as string
                ), true);
?>
<?php

$this->beginWidget('MiniForm', array(
    'haeder' => Yii::t('app', "Transactions"),
        //'width' => '800',
));



$yiidbdatetime = Yii::app()->locale->getDateFormat('yiidbdatetime');
$phpdatetime = Yii::app()->locale->getDateFormat('phpdatetime');

$this->widget('bootstrap.widgets.TbGridView', array(
    'id' => 'transactions-grid',
    'dataProvider' => $model->search(),
    //'enablePagination'=> false,
    'ajaxUpdate' => true,
    'ajaxType' => 'POST',
    'afterAjaxUpdate'=>"function() {
						jQuery('#Transactions_from_date').datepicker(jQuery.extend({showMonthAfterYear:false}, jQuery.datepicker.regional['".substr(Yii::app()->language,0,2)."'], {'showAnim':'fold','dateFormat':'".Yii::app()->locale->getDateFormat('short')."','changeMonth':'true','showButtonPanel':'true','changeYear':'true','constrainInput':'false'}));
						jQuery('#Transactions_to_date').datepicker(jQuery.extend({showMonthAfterYear:false}, jQuery.datepicker.regional['".substr(Yii::app()->language,0,2)."'], {'showAnim':'fold','dateFormat':'".Yii::app()->locale->getDateFormat('short')."','changeMonth':'true','showButtonPanel':'true','changeYear':'true','constrainInput':'false'}));
                                }",
    'filter' => $model,
    'columns' => array(
        'num',
        array(
            'name' => 'type',
            //'filter'=>CHtml::dropDownList('Transactions[type]', $model->type,CHtml::listData(TransactionType::model()->findAll(), 'id', 'name')),
            'filter' => CHtml::listData(TransactionType::model()->findAll(), 'id', 'name'),
            'value' => '$data->Type->name'
        ),
        array(
            'name' => 'account_id',
            //'type' => 'raw',
            'value' => 'CHtml::link(CHtml::encode(isset($data->Account)?$data->Account->name:$data->account_id),Yii::app()->createAbsoluteUrl("/accounts/transaction/id/".$data->account_id))',
            'type' => 'raw',
        //'value' => '$data->getOptAcc()',
        ),
        //'',
        array(
            'name' => 'refnum1',
            'value' => '$data->refnumDocsLink()',
            'type' => 'raw',
        ),
        array(
            'name' => 'refnum2',
            'value' => 'CHtml::link(CHtml::encode($data->refnum2),Yii::app()->createAbsoluteUrl("/docs/view/$data->refnum2"))',
            'type' => 'raw',
        ),
        'details',
        array(
            'name' => 'date',
            'filter' => $dateisOn,
            'value' => 'date("' . $phpdatetime . '",CDateTimeParser::parse($data->date,"' . $yiidbdatetime . '"))'
        ),
        'sum',
    ),
));

$this->endWidget(); //miniform
?>