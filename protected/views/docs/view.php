<?php
/***********************************************************************************
 * The contents of this file are subject to the Mozilla Public License Version 2.0
 * ("License"); You may not use this file except in compliance with the Mozilla Public License Version 2.0
 * The Original Code is:  Linet 3.0 Open Source
 * The Initial Developer of the Original Code is Adam Ben Hur.
 * All portions are Copyright (C) Adam Ben Hur.
 * All Rights Reserved.
 ************************************************************************************/
$actions = array();
//$actions[]=array('label'=>Yii::t('app','List Documents'), 'url'=>array('index'));
$actions[] = array('label' => Yii::t('app', 'Create Document'), 'url' => array('create'));
$actions[] = array('label' => Yii::t('app', 'View Document'), 'url' => array('view', 'id' => $model->id));
$actions[] = array('label' => Yii::t('app', 'Manage Documents'), 'url' => array('admin'));
$actions[] = array('label' => Yii::t('app', 'Duplicate Document'), 'url' => array('duplicate', 'id' => $model->id));



if (($model->doctype == 1) || ($model->doctype == 2)) {//Proforma || Delivery doc
    $actions[] = array('label' => Yii::t('app', 'Convert to Invoice'), 'url' => array('duplicate', 'id' => $model->id, 'type' => 3)); //Invoice
    $actions[] = array('label' => Yii::t('app', 'Convert to Invoice Receipt'), 'url' => array('duplicate', 'id' => $model->id, 'type' => 9)); //Invoice Receipt 
}
if ($model->doctype == 2) {//Delivery doc
    $actions[] = array('label' => Yii::t('app', 'Convert to Return document'), 'url' => array('duplicate', 'id' => $model->id, 'type' => 5)); //Return document
}
if ($model->doctype == 3) {//Invoice
    $actions[] = array('label' => Yii::t('app', 'Convert to Credit Invoice'), 'url' => array('duplicate', 'id' => $model->id, 'type' => 4)); //Credit Invoice
}
if ($model->doctype == 4) {//Credit Invoice
    $actions[] = array('label' => Yii::t('app', 'Convert to Invoice'), 'url' => array('duplicate', 'id' => $model->id, 'type' => 3)); //Invoice
}
if ($model->doctype == 6) {//Quote
    $actions[] = array('label' => Yii::t('app', 'Convert to Proforma'), 'url' => array('duplicate', 'id' => $model->id, 'type' => 1)); //Proforma
    $actions[] = array('label' => Yii::t('app', 'Convert to Delivery doc'), 'url' => array('duplicate', 'id' => $model->id, 'type' => 2)); //Delivery doc
    $actions[] = array('label' => Yii::t('app', 'Convert to Invoice'), 'url' => array('duplicate', 'id' => $model->id, 'type' => 3)); //Invoice
    $actions[] = array('label' => Yii::t('app', 'Convert to Sales Order'), 'url' => array('duplicate', 'id' => $model->id, 'type' => 7)); //Sales Order
    $actions[] = array('label' => Yii::t('app', 'Convert to Invoice Receipt'), 'url' => array('duplicate', 'id' => $model->id, 'type' => 9)); //Invoice Receipt
}
if ($model->doctype == 7) {//Sales Order
    $actions[] = array('label' => Yii::t('app', 'Convert to Proforma'), 'url' => array('duplicate', 'id' => $model->id, 'type' => 1)); //Proforma
    $actions[] = array('label' => Yii::t('app', 'Convert to Delivery doc'), 'url' => array('duplicate', 'id' => $model->id, 'type' => 2)); //Delivery doc
    $actions[] = array('label' => Yii::t('app', 'Convert to Invoice'), 'url' => array('duplicate', 'id' => $model->id, 'type' => 3)); //Invoice
    $actions[] = array('label' => Yii::t('app', 'Convert to Invoice Receipt'), 'url' => array('duplicate', 'id' => $model->id, 'type' => 9)); //Invoice Receipt 
}
if ($model->doctype == 10) {//Purchase Order
    $actions[] = array('label' => Yii::t('app', 'Convert to') . " " . Yii::t('app', 'Current Expense'), 'url' => array('duplicate', 'id' => $model->id, 'type' => 13)); //Current Expense
    $actions[] = array('label' => Yii::t('app', 'Convert to') . " " . Yii::t('app', 'Asset Expense'), 'url' => array('duplicate', 'id' => $model->id, 'type' => 14)); //Asset Expense
    $actions[] = array('label' => Yii::t('app', 'Convert to') . " " . Yii::t('app', 'Stock entry certificate'), 'url' => array('duplicate', 'id' => $model->id, 'type' => 16)); //Stock entry certificate
}

if ($model->doctype == 16) {//Stock entry certificate
        $actions[] = array('label' => Yii::t('app', 'Convert to') . " " . Yii::t('app', 'Stock exit certificate'), 'url' => array('duplicate', 'id' => $model->id, 'type' => 17)); //Stock entry certificate
}
$this->menu = $actions;



$this->beginWidget('MiniForm', array('header' => Yii::t("app", "View Document") . " " . $model->id,));
?>


<?php echo $this->renderPartial('print', array('model' => $model)); ?>

<label for="Docs_comments"><?php echo $model->getAttributeLabel('comments'); ?></label>

<?php
echo $model->comments;
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'docs-form',
    'action' => Yii::app()->CreateURL('docs/view/' . $model->id),
    'enableAjaxValidation' => false,
    'htmlOptions' => array('enctype' => 'multipart/form-data'),
        ));
?>




<div class="row">
    <div class="col-md-1">
        <?php
        ///*
        $this->widget('widgetRefnum', array(
            'model' => $model, //Model object
            'attribute' => 'refnum', //attribute name
        )); //*/
        ?>

    </div>
    <div class="col-md-5">


        <?php
        $this->widget('CMultiFileUpload', array(
            'name' => 'Files',
            'model' => $model,
            'id' => 'Files',
            'accept' => '*', // useful for verifying files
            'duplicate' => 'Duplicate file!', // useful, i think
            'denied' => 'Invalid file type', // useful, i think
        ));
        ?>
        <?php
        $files = new Files('search');
        $files->unsetAttributes();
        $files->parent_type = get_class($model);
        $files->parent_id = $model->id;
        $files->hidden = 0;
        $this->widget('EExcelView', array(
            'id' => 'acc-template-grid',
            'dataProvider' => $files->search(),
            //'filter'=>$model,
            'template' => '{items}{pager}',
            'ajaxUpdate' => true,
            'columns' => array(
                array(
                    'name' => 'name',
                    'type' => 'raw',
                    'value' => 'CHtml::link(CHtml::encode($data->name), Yii::app()->createUrl("download/".$data->id))',
                ),
                array(
                    'name' => 'date',
                    'value' => 'date("' . Yii::app()->locale->getDateFormat('phpdatetime') . '",CDateTimeParser::parse($data->date,"' . Yii::app()->locale->getDateFormat('yiidbdatetime') . '"))'
                ),
                array(
                    'class' => 'CButtonColumn',
                    'template' => '{delete}',
                    'buttons' => array(
                        'delete' => array(
                            'label' => '<i class="glyphicon glyphicon-trash"></i>',
                            'deleteConfirmation' => true,
                            'imageUrl' => false,
                            'url' => 'Yii::app()->createUrl("files/delete", array("id"=>$data->id))',
                        ),
                    ),
                ),
            ),
        ));
        ?>

    </div>
</div>

<div class="btn-group">
    <?php echo CHtml::dropDownList('language', Yii::app()->user->language, CHtml::listData(Language::model()->findAll(), 'id', 'name'));?>
    <?php
    echo CHTML::hiddenField("subType", "print");
    echo CHTML::hiddenField("Docs[id]", $model->id);
    echo CHTML::hiddenField("Docs[doctype]", $model->doctype);
    if (($model->doctype != 13) && ($model->doctype != 14)) {
        $this->widget('bootstrap.widgets.TbButtonGroup', array(
            'type' => 'primary', // '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
            'htmlOptions' => array('class' => 'dropup'),
            'buttons' => array(
                array('icon' => 'glyphicon glyphicon-print', 'label' => Yii::t('app', 'Print'), 'htmlOptions' => array('onclick' => 'return sendForm("print");'),),
                array('items' => array(
                        array('icon' => 'glyphicon glyphicon-envelope', 'label' => Yii::t('app', 'Email'), 'url' => 'javascript:sendForm("email");',),
                        array('icon' => 'glyphicon glyphicon-save', 'label' => Yii::t('app', 'PDF'), 'url' => 'javascript:sendForm("pdf");',),
                        array('icon' => 'glyphicon glyphicon-cloud-upload', 'label' => Yii::t('app', 'Save Draft'), 'url' => 'javascript:sendForm("saveDraft");',),
                    //array('icon' => 'glyphicon glyphicon-cloud-upload', 'label' => Yii::t('app', 'Save'), 'url' => 'javascript:sendForm("save");',),
                    )),
            ),
        ));

        $this->widget('bootstrap.widgets.TbButton', array(
            'label' => Yii::t('app', 'Change language'),
            'icon' => 'glyphicon glyphicon-globe',
            'type' => 'primary',
            'htmlOptions' => array('id' => 'printLink', 'onclick' => 'return hideMe();'),
        ));
        
    }
    ?>
</div>

<?php
$this->endWidget();
$this->endWidget();


/*
  $this->beginWidget('zii.widgets.jui.CJuiDialog', array(//
  'id' => "mailDialog",
  'options' => array(
  'title' => Yii::t('app', 'Send Mail'),
  'autoOpen' => false,
  'width' => '600px',
  ),
  ));
  ?>
  <div id="mailForm"></div>
  <?php
  $this->endWidget('zii.widgets.jui.CJuiDialog'); */

$this->widget('widgetMail', array(
    'urlFile' => Yii::app()->createAbsoluteUrl("docs/view/" . $model->id . "?mail=1"),
    'urlAddress' => Yii::app()->createAbsoluteUrl("accounts/JSON/" . $model->account_id),
    'urlMailForm' => Yii::app()->createAbsoluteUrl('mail/create'),
    'urlTemplate' => Yii::app()->createAbsoluteUrl('mailTemplate/json'),
    'obj' => 'Docs',
    'type' => $model->doctype,
    'id' => $model->id
));
?>



<script type="text/javascript">
    function refNum(doc) {//


        $("#choseDocs_refnum").dialog("close");

        $('#Docs_refnum_div').html($('#Docs_refnum_div').html() + ", " + doc.doctype + " #" + doc.docnum);
        $('#Docs_refnum_ids').val($('#Docs_refnum_ids').val() + doc.id + ",");


        return false;


    }
    jQuery(document).ready(function() {

        $('#s2id_language').hide();
        if ("1" == "<?php echo $mail; ?>") {
            $('#subType').val('email');
            showMail();
        }
    });
    /*
     $( document ).on( "pageinit", document, function( event ) {
     // toastr.info( "Initializing " + this.id );
     showMail();
     });*/
    function hideMe() {
        $('#printLink').hide(150);
        $('#s2id_language').show(150);
        return false;
    }


    function sendForm(value) {//preview,print,mail,pdf,save
        $('#subType').val(value);
        if (value == 'preview')
            $("#docs-form").attr('target', '_BLANK');
        if (value == 'email') {
            return showMail();

        }
        $('#docs-form').submit();

        //return false;
    }




</script>