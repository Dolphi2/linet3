<?php
/***********************************************************************************
 * The contents of this file are subject to the Mozilla Public License Version 2.0
 * ("License"); You may not use this file except in compliance with the Mozilla Public License Version 2.0
 * The Original Code is:  Linet 3.0 Open Source
 * The Initial Developer of the Original Code is Adam Ben Hur.
 * All portions are Copyright (C) Adam Ben Hur.
 * All Rights Reserved.
 ************************************************************************************/
$yiidbdatetime = Yii::app()->locale->getDateFormat('yiidbdatetime');
$phpdatetime = Yii::app()->locale->getDateFormat('phpdatetime');

//print_r($model->accounts());


foreach ($model->accounts() as $account) {
    echo "<h3>" . $account . " " . Accounts::model()->findByPk($account)->name . "</h3>";
    $this->widget('EExcelView', array(
        'id' => 'transactions-grid' . $account,
        'dataProvider' => $model->search($account),
        'columns' => array(
            array(
                'name' => 'num',
                'value' => '$data->numLink()',
                'type' => 'raw',
            ),
            
             
            /*
              array(
              'value' => 'CHtml::link(CHtml::encode($data->getOptAccName()),Yii::app()->createAbsoluteUrl("/accounts/transaction/".$data->getOptAccId()))',
              'type' => 'raw',
              ), */
            array(
                'name' => 'type',
                'value' => 'Yii::t("app",$data->Type->name)'
            ),
            array(
                'name' => 'refnum1',
                'value' => '$data->refnumDocsLink()',
                'type' => 'raw',
            ),
            array(
                'name' => 'refnum2',
                'value' => 'CHtml::encode($data->refnum2)',
                'type' => 'raw',
            ),
            'details',
            array(
                'name' => 'date',
                'filter' => '',
                'value' => 'date("' . $phpdatetime . '",CDateTimeParser::parse($data->valuedate,"' . $yiidbdatetime . '"))'
            ),
            array(
                'header' => Yii::t('app', 'Debit'),
                'name' => 'sum',
                'filter' => '',
                'cssClassExpression' => "'number'",
                'value' => '($data->sum<0)?$data->sum:""'
            ),
            array(
                'header' => Yii::t('app', 'Credit'),
                'name' => 'sum',
                'filter' => '',
                'cssClassExpression' => "'number'",
                'value' => '($data->sum>0)?$data->sum:""'
            ),
            array(
                'header' => Yii::t('app', 'Balance'),
                'name' => 'sum',
                'filter' => '',
                'cssClassExpression' => "'number'",
                'value' => '$data->getBalance()'
            ),
        ),
    ));
}
?>