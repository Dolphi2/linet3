<?php
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

$this->menu = $actions;



$this->beginWidget('MiniForm', array('haeder' => Yii::t("app", "View Document") . " " . $model->id,));
?>
<script type="text/javascript">
    jQuery(document).ready(function() {

        $('#language_chosen').hide();

    });


    function hideMe() {
        $('#printLink').hide();
        $('#language_chosen').show();
        return false;
    }


    function sendForm(value) {//preview,print,mail,pdf,save
        $('#subType').val(value);
        if (value == 'preview')
            $("#docs-form").attr('target', '_BLANK');
        if (value == 'email'){
            return showMail();
            
        }
        $('#docs-form').submit();

        //return false;
    }
    
    function getFile(){//only for docs
        //get file
        //post....
        var url = $('#docs-form').attr("action");
        var parms = $('#docs-form').serializeArray();
        $.post(url, parms, 
                function(data) {
                     console.log(data);
                     $('#Mail_files').val(data);
                     //callback
                        //get template
                        //doc,type
                     
                }, "json");
            
                    //callback
                        //show template
        
        //send mail
        
    }
    
    function getMailForm(){
        $.post("<?php echo $this->createUrl('/mail/create'); ?>", {"minimal":"true"}, 
                function(data) {
                    
                    //console.log(data);
                    $('#mailForm').html(data);
                    
                    getTemplate('Docs',$("#Docs_doctype").val(),$("#Docs_id").val());
                    getFile();
                    
                    
                    $('#Mail_body').tinymce({'language':'en','plugins':['advlist autolink lists link image charmap print preview hr anchor pagebreak','searchreplace visualblocks visualchars code fullscreen','insertdatetime media nonbreaking save table contextmenu directionality','template paste textcolor'],'toolbar':'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media | forecolor backcolor','toolbar_items_size':'small','image_advtab':true,'relative_urls':false,'spellchecker_languages':'+Русский=ru'});

                }, "json");//
        
    }
    
    
    
    function getTemplate(obj,type,id){
        $.post("<?php echo $this->createUrl('/mailTemplate/json'); ?>", {"MailTemplate": {"obj": obj, "type": type, "id": id}}, 
                function(data) {
                    
                    //console.log(data[0].subject);
                    
                    $('#Mail_from').val();
                    $('#Mail_to').val();
                    $('#Mail_cc').val(data[0].cc);
                    $('#Mail_bcc').val(data[0].bcc);
                    $('#Mail_subject').val(data[0].subject);
                    $('#Mail_body').val(data[0].body);

                    
                    
                    
                }, "json");//
    }
    
    function showMail(){
        $('#mailDialog').dialog('open');
        getMailForm();
        
        
        
        return ;
    }
    
    
</script>

<?php
echo $this->renderPartial('print', array('model' => $model, 'preview' => 1));?>

<label for="Docs_comments"><?php echo $model->getAttributeLabel('comments'); ?></label>

<?php echo $model->comments;
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'docs-form',
    'action' => Yii::app()->CreateURL('docs/view/id/' . $model->id),
    'enableAjaxValidation' => false,
    'htmlOptions' => array('enctype' => 'multipart/form-data'),
        ));
?>




<div class="row">
    <div class="col-md-1">
            <?php ///*
                $this->widget('widgetRefnum', array(
                    'model' => $model, //Model object
                    'attribute' => 'refnum', //attribute name
                ));//*/
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
        $this->widget('bootstrap.widgets.TbGridView', array(
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
<div class="btn">

<?php
echo CHTML::hiddenField("subType", "print");
echo CHTML::hiddenField("Docs[id]", $model->id);
echo CHTML::hiddenField("Docs[doctype]", $model->doctype);
$this->widget('bootstrap.widgets.TbButtonGroup', array(
    'type' => 'primary', // '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
    'buttons' => array(
        array('icon' => 'glyphicon glyphicon-print', 'label' => Yii::t('app', 'Print'), 'htmlOptions' => array('onclick' => 'return sendForm("print");'),),
        array('items' => array(
                array('icon' => 'glyphicon glyphicon-envelope','label'=>Yii::t('app','Email'), 'url'=>'javascript:sendForm("email");',),
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
echo CHtml::dropDownList('language', Yii::app()->user->language, CHtml::listData(Language::model()->findAll(), 'id', 'name'));
//echo CHtml::dropDownList('language',Yii::app()->user->getLanguage(),CHtml::listData(Language::model()->findAll(), 'id', 'name'));
?>
</div>
<br /><br /><br /><br />
    <?php
    $this->endWidget();
    $this->endWidget();
    
    
    
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
    $this->endWidget('zii.widgets.jui.CJuiDialog');
    ?>
    


<script type="text/javascript">
    function refNum(doc) {//


            $("#choseDocs_refnum").dialog("close");

            $('#Docs_refnum_div').html($('#Docs_refnum_div').html() + ", " + doc.doctype + " #" + doc.docnum);
            $('#Docs_refnum_ids').val($('#Docs_refnum_ids').val() + doc.id + ",");


            return false;


        }
        </script>