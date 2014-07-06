<tr class="rcptContent">
    <td><b><?php echo $form->labelEx($model, 'type'); ?></b>
        <?php //echo $form->hiddenField($model, "[$i]id"); ?>
        <?php echo $form->hiddenField($model, "[$i]doc_id"); ?>
        <?php echo $form->hiddenField($model, "[$i]line"); ?>
        
        <b><?php echo $form->labelEx($model, 'type'); ?></b>
            
            
            <?php 
            
            $temp=CHtml::listData(PaymentType::model()->findAll(), 'id', 'name');
            $temp[0]=Yii::t('app','None');
                
            
            echo $form->dropDownList($model, "[$i]type", $temp); 
            
            ?>
    </td>
    



    <td><b><?php echo $form->labelEx($model, 'refnum'); ?></b><?php echo $form->textField($model, "[$i]refnum", array('maxlength' => 255)); ?></td>
    <td><b><?php echo $form->labelEx($model, 'creditcompany'); ?></b><?php echo $form->textField($model, "[$i]creditcompany", array('maxlength' => 255)); 
                                                                    //echo $form->dropDownList($model, "[$i]creditcompany", CHtml::listData(Item::model()->findAll(), 'id', 'name')); ?></td>
    <td><b><?php echo $form->labelEx($model, 'cheque_num'); ?></b><?php echo $form->textField($model, "[$i]cheque_num", array()); ?></td>
    <td><b><?php echo $form->labelEx($model, 'bank'); ?></b><?php 
    
    //echo $form->textField($model, "[$i]bank", array('maxlength' => 5)); 
    
    ?>
    <?php echo $form->dropDownList($model,"[$i]bank",CHtml::listData(BankName::model()->findAll(), 'id', 'name'));?>
    
    
    </td>
    <td><b><?php echo $form->labelEx($model, 'branch'); ?></b><?php echo $form->textField($model, "[$i]branch", array( 'maxlength' => 8)); ?></td>
    <td><b><?php echo $form->labelEx($model, 'cheque_acct'); ?></b><?php echo $form->textField($model, "[$i]cheque_acct", array('maxlength' => 8)); ?></td>
    <td>
        <b><?php echo $form->labelEx($model, 'cheque_date'); ?></b>
        <?php //echo $form->textField($model, "[$i]cheque_date", array('maxlength' => 8)); 
        
        $this->widget('application.extensions.CJuiDateTimePicker.CJuiDateTimePicker',array(
                    'model'=>$model, //Model object
                    'attribute'=>"[$i]cheque_date", //attribute name
                    'mode'=>'date', 
                    'language' => substr(Yii::app()->language,0,2),
                    'options'=>array(
                        'showAnim'=>'fold',
                        'dateFormat'=>Yii::app()->locale->getDateFormat('short'),
                    ) // jquery plugin options
                ));
        
        
        ?>
        
    </td>
    <td><b><?php echo $form->labelEx($model, 'currency_id'); ?></b><?php echo $form->dropDownList($model, "[$i]currency_id", CHtml::listData(Currates::model()->GetRateList(), 'currency_id', 'name'), array('class'=>'currSelect')); ?></td>
    <td><b><?php echo $form->labelEx($model, 'sum'); ?></b><?php echo $form->textField($model, "[$i]sum", array('maxlength' => 8)); ?></td>
    <td><b><?php echo $form->labelEx($model, 'dep_date'); ?></b><?php echo $form->hiddenField($model, "[$i]dep_date", array('maxlength' => 8));  ?></td>
    
    <td class="remove">
        <?php
                        $this->widget('bootstrap.widgets.TbButton', array(
                            'label' => Yii::t('app', 'Remove'),
                            'icon' => 'glyphicon glyphicon-remove',
                        ));
                        ?>


    </td>
<script type="text/javascript">
    //$("#Doccheques_<?php echo $i; ?>_type").prepend("<option value='0'><?php echo Yii::t('app','Chose Payment type');?></option>");
    $("#Doccheques_<?php echo $i; ?>_type").chosen();
    //$("#Doccheques<?php echo $i; ?>_currency_id").chosen();
    $("#Doccheques_<?php echo $i; ?>_bank").chosen();
    //jQuery('#Doccheques_<?php echo $i; ?>_cheque_date').datepicker(jQuery.extend({showMonthAfterYear:false}, jQuery.datepicker.regional['<?php echo substr(Yii::app()->language,0,2) ?>'], {'showAnim':'fold','dateFormat':'<?php echo Yii::app()->locale->getDateFormat('short')?>'}));
   
    
    $( document ).ready(function() {
        //jQuery("#Doccheques_<?php echo $i; ?>_bank").autocomplete({"minLength":0, "showAnim": "fold", "source": "/yii/demos/new/index.php?r=bankName/autocomplete"});
        rcptSum();
        <?php if($i=='ABC'){?>
        jQuery('#Doccheques_<?php echo $i; ?>_cheque_date').datepicker(jQuery.extend({showMonthAfterYear:false}, jQuery.datepicker.regional['<?php echo substr(Yii::app()->language,0,2) ?>'], {'showAnim':'fold','dateFormat':'<?php echo Yii::app()->locale->getDateFormat('short')?>'}));
        <?php }?>
            
            
            
        $("#Doccheques_<?php echo $i; ?>_type").change(function(){
        TypeSelChange(<?php echo $i; ?>);  
    });
    });
    /*
    var rcpt=true;
    $("#Doccheques_<?php echo $i; ?>_bank").focus(function(){
        if($("#Doccheques_<?php echo $i; ?>_bank").val()=='' && rcpt){
            $("#Doccheques_<?php echo $i; ?>_bank").autocomplete("search","");
            rcpt=false;
        }
    });
    */

    $("#Doccheques_<?php echo $i; ?>_sum").change(function(){
        rcptSum(); 
    });
    
    
    $("#Doccheques_<?php echo $i; ?>_inclodeVat").change(function(){
        //vatChange(<?php echo $i; ?>);  
    });
    
    $("#Doccheques_<?php echo $i; ?>_name").change(function(){
        //nameChange(<?php echo $i; ?>);  
    });
    
    $("#Doccheques_<?php echo $i; ?>_item_id").blur(function(){
        //itemChange(<?php echo $i; ?>);  
    });
    
    
    $("#Doccheques_<?php echo $i; ?>_qty").change(function(){
        //detChange(<?php echo $i; ?>);  
    });
    $("#Doccheques_<?php echo $i; ?>_unit_price").change(function(){
        //detChange(<?php echo $i; ?>);  
    });
    $("#Doccheques_<?php echo $i; ?>_price").change(function(){
        //priceChange(<?php echo $i; ?>);  
    });
    $("#Doccheques_<?php echo $i; ?>_invprice").change(function(){
        //sumChange(<?php echo $i; ?>);  
    });
    $(".remove").click(function() {
            
            $(this).parents(".rcptContent:first").remove();
            //CalcPriceSum();
            rcptcalcLines();
    });
    
</script>

</tr>