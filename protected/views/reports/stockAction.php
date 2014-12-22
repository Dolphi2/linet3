<?php
/***********************************************************************************
 * The contents of this file are subject to the Mozilla Public License Version 2.0
 * ("License"); You may not use this file except in compliance with the Mozilla Public License Version 2.0
 * The Original Code is:  Linet 3.0 Open Source
 * The Initial Developer of the Original Code is Adam Ben Hur.
 * All portions are Copyright (C) Adam Ben Hur.
 * All Rights Reserved.
 ************************************************************************************/
$dateisOn = $this->widget('zii.widgets.jui.CJuiDatePicker', array(
            'name' => 'stockAction[from_date]',
            'language' => substr(Yii::app()->language, 0, 2),
            'value' => $model->from_date,
            'options' => array(
                'showAnim' => 'fold',
                'dateFormat' => Yii::app()->locale->getDateFormat('short'),
                'changeMonth' => 'true',
                'changeYear' => 'true',
                'constrainInput' => 'false',
            ),
            'htmlOptions' => array(
                'placeholder' => Yii::t('app', 'From Date'),
            ),
                ), true) . $this->widget('zii.widgets.jui.CJuiDatePicker', array(
            'name' => 'stockAction[to_date]',
            'language' => substr(Yii::app()->language, 0, 2),
            'value' => $model->to_date,
            'options' => array(
                'showAnim' => 'fold',
                'dateFormat' => Yii::app()->locale->getDateFormat('short'),
                'changeMonth' => 'true',
                'changeYear' => 'true',
                'constrainInput' => 'false',
            ),
            'htmlOptions' => array(
                'placeholder' => Yii::t('app', 'To Date'),
            ),
                ), true);
?>

<?php

$this->beginWidget('MiniForm', array(    'header' => Yii::t('app', "Stock Transactions"),));



$yiidbdatetime = Yii::app()->locale->getDateFormat('yiidbdatetime');
$phpdatetime = Yii::app()->locale->getDateFormat('phpdatetime');

$this->widget('EExcelView', array(
    'id' => 'stockAction-grid',
    'dataProvider' => $model->search(),
    //'enablePagination'=> false,
    'ajaxUpdate' => true,
    'ajaxType' => 'POST',
    'filter' => $model,
    'columns' => array(
        'id',
        array(
            'name' => 'account_id',
            //'filter'=>CHtml::dropDownList('Transactions[type]', $model->type,CHtml::listData(TransactionType::model()->findAll(), 'id', 'name')),
            'filter' => CHtml::listData(Accounts::model()->findAll(), 'id', 'name'),
            'value' => '$data->getAccountName()'
        ),
        array(
            'name' => 'oppt_account_id',
            //'type' => 'raw',
            'filter' => CHtml::listData(Accounts::model()->findAll(), 'id', 'name'),
            'value' => '$data->OpptAccount->name'
        //'value'=>'CHtml::link(CHtml::encode($data->account_id),Yii::app()->createAbsoluteUrl("/accounts/transaction/id/".$data->account_id))',
        ),
        array(
            'name' => 'doc_id',
            'filter' => '',
            //'value'=>'0',
            'value' => '$data->getRefDocLink()',
            'type' => 'raw',
        ),
        array(
            'name' => 'item_id',
            'header'=>Yii::t('labels',"Item Name"),
            'filter' => CHtml::listData(Item::model()->findAll(), 'id', 'name'),
            'value' => '$data->getItemName()'
        ),
        'qty',
        'serial',

        array(
            'name' => 'createDate',
            'filter' => $dateisOn,
            'value' => 'date("' . $phpdatetime . '",CDateTimeParser::parse($data->createDate,"' . $yiidbdatetime . '"))'
        ),
        array(
            'name' => 'user_id',
            'filter' => CHtml::listData(User::model()->findAll(), 'id', 'username'),
            'value' => '$data->User->username'
        ),
    //'sum',
    ),
));


$this->endWidget(); //miniform
?>