<?php

$model = new Docs('search');
$model->unsetAttributes();
if (isset($_GET['Docsfilter']))
    $model->attributes = $_GET['Docsfilter'];
//$var=CHtml::link(CHtml::encode($data->docnum),"#", array("onclick"=>'refNum('.CJSON::encode($data).')'));
$this->widget('EExcelView', array(
    'id' => 'docs-grid',
    'dataProvider' => $model->search(),
    'template' => '{items}{pager}',
    'filter' => $model,
    'afterAjaxUpdate' => 'function(){var elements = $(".filter-container > [name^=Docs]");
for (var i=0; i<elements.length; i++) {
    elements[i].name=elements[i].name.replace("Docs","Docsfilter");
    console.log(elements[i].name);

}}',
    'columns' => array(
        array(
            'name' => 'doctype',
            'filter' => CHtml::listData(Doctype::model()->findAll(), 'id', 'name'),
            'value' => 'Yii::t("app",$data->docType->name)'
        ),
        array(
            'name' => 'docnum',
            'value' => 'CHtml::link(CHtml::encode($data->docnum),"#", array("onclick"=>\'refNum(\'.CJSON::encode($data).\')\'));',
            'type' => 'raw',
        ),
        'company',
        //array(  'onclick'=>""refNum(\"".$data->id.",".$data->docnum.",".$data->docType->name.")",
        /* array(
          //'name'=>'account_id',
          'header'=>'Account',
          'class'=>'CLinkColumn',
          //'filter'=>CHtml::listData(Doctype::model()->findAll(), 'id', 'name'),
          'labelExpression'=>'"".$data->company',
          //'url'=>'accouts/view&id=$data->account_id',
          'urlExpression'=>'"users/view&id=".$data->account_id',
          ), */
        array(
            'name' => 'status',
            'value' => 'isset($data->docStatus)?$data->docStatus->name:""'
        ),
        'total',
    ),
));
?>

