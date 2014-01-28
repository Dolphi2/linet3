<?php

$this->menu=array(
	//array('label'=>'List Config','url'=>array('index')),
	//array('label'=>'View Config','url'=>array('view','id'=>$model->id)),
);
$this->beginWidget('MiniForm',array('haeder' => Yii::t("app","Create Open Balance"))); 
?>
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'user-form',
	'enableAjaxValidation'=>false,
)); ?>


<table class='formy'>
    <tr>
        <td colspan="2">
            <?php echo Yii::t('app',"Select year");?>

            <?php 
            $year = date("Y");
            $max = $year + 1;
            $years=array();
            
            for($min = $year - 2; $min <= $max; $min++) 
                $years[$min]=$min;
            
            
            echo CHtml::dropDownList('year', $year,$years);                    
            ?>
        </td>
    </tr>
    <tr>

        <th><?php echo Yii::t('app',"Account");?></th>

        <th><?php echo Yii::t('app',"Acct. balance");?></th>
    </tr>
    
    <?php
$temp=CHtml::listData(Accounts::model()->findAll(), 'id', 'name');
$temp[0]=Yii::t('app','Chose Account');

for($i = 0; $i < 10; $i++) {
	echo "<tr>\n<td>\n";
        echo CHtml::dropDownList('account[]',0,$temp);
	echo "</td><td>\n";
	echo "<input type=\"text\" class=\"bal\" name=\"bal[]\" dir=\"ltr\" />\n";
	echo "</td>\n</tr>\n";
}

?>

</table>






<?php echo CHtml::submitButton('Save'); ?>    
<?php $this->endWidget(); ?>



    <?php 
$this->endWidget(); 
?>


<script type="text/javascript">
    jQuery(document).ready(function(){
        var docacc=true;
        $("#account_0").focus(function(){
            if($("#Docs_account_id").val()=='' && docacc){
                $("#account_0").autocomplete("search","");
                docacc=false;
            }
        });



    });
        
</script>