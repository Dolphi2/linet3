<?php
 $logopath = Yii::app()->createAbsoluteUrl("download/" . Yii::app()->user->settings['company.logo']);
$legalize="";
if ($preview == 3) {
    //$configPath = Yii::app()->user->settings["company.path"];
    $logopath = Company::getFilePath() . Yii::app()->user->settings['company.logo'];
}elseif($preview==2){
    $legalize=Yii::t('app','Computerized Document');
    $logopath = Company::getFilePath()."/settings/" . Yii::app()->user->settings['company.logo'];
    //echo $preview.$logopath;
//exit;
}
//$this->beginWidget('MiniForm',array('header' => Yii::t("app","View Document ") ." " .$model->id,));



?>


<table>
    <tr>
        <td colspan="3" width="650">
            <h3><?php echo Yii::app()->user->settings['company.name']; ?></h3><br />
<?php echo Yii::app()->user->settings['company.address']; ?>, <?php echo Yii::app()->user->settings['company.city']; ?> ,<?php echo Yii::app()->user->settings['company.zip']; ?><br />
<?php echo Yii::t('app', 'Phone'); ?>: <?php echo Yii::app()->user->settings['company.phone']; ?><br />
            <?php echo Yii::t('app', 'Fax'); ?>: <?php echo Yii::app()->user->settings['company.fax']; ?><br />
            <?php echo Yii::app()->user->settings['company.website']; ?><br />

            <?php echo Yii::t('app', 'VAT No.'); ?>: <?php echo Yii::app()->user->settings['company.vat.id']; ?><br />
        </td>

        <td>

            <img width="100px" alt="logo" src="<?php echo $logopath; ?>">

        </td>
    </tr>
</table>
<div align="center"><h1><?php echo $legalize?></h1></div>
<hr />
<table>	
    <tr>
        <td width="50" style="text-align:top;"><?php echo Yii::t('app', 'To'); ?>:</td>
        <td width="400" ><?php echo $model->company; ?></td>
        <td width="150" ><?php echo Yii::t('app', 'Doc. Issued date'); ?>:</td>
        <td>
<?php
echo date(Yii::app()->locale->getDateFormat('phpshort'), CDateTimeParser::parse($model->issue_date, Yii::app()->locale->getDateFormat('yiidatetime')));
?>
        </td>
    </tr>

    <tr>
        <td></td>
        <td><?php echo $model->address; ?></td>
        <td><?php echo Yii::t('app', 'Due date'); ?></td>
        <td>
<?php
echo date(Yii::app()->locale->getDateFormat('phpshort'), CDateTimeParser::parse($model->due_date, Yii::app()->locale->getDateFormat('yiidatetime')));
?>
        </td>
    </tr>
    <tr>
        <td></td>
        <td><?php echo $model->city; ?> <?php echo $model->zip; ?></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td></td>
        <td><?php echo Yii::t('app', 'Vat No.'); ?>:<?php echo $model->vatnum; ?></td>
        <td></td>
        <td></td>
    </tr>

    <tr>
        <td colspan="4">
            <div align="center"><h1><?php echo Yii::t('app', $model->docType->name); ?> <span style="font-size:25px;"> <?php echo Yii::t('app', 'No.'); ?> <?php echo $model->docnum; ?> </span>
 <span id='stamp'> 
<?php
if ($model->docType->copy) {
    if ($model->action == 0) {
        echo Yii::t('app', 'Draft');
    } else {
        echo ($model->printed == 1) ? Yii::t('app', 'Source') : Yii::t('app', 'Copy');
    }
}
?>
     </span>           
                </h1></div>
        </td>
    </tr>
</table>

<?php
/* * *************************************************************************************************************************** */

if (count($model->docDetailes) != 0) {
    ?>

    <table class="table">
        <tr>
            <th class='line'><?php echo Yii::t('app', 'Line'); ?></th>
            <th class='Itemid'><?php echo Yii::t('app', 'Item id'); ?></th>
            <th class='Name'><?php echo Yii::t('app', 'Name'); ?></th>
            <th class='Description'><?php echo Yii::t('app', 'Description'); ?></th>
            <th class='UntPrice'><?php echo Yii::t('app', 'Unt. Price'); ?></th>
            <th class='Unit'><?php echo Yii::t('app', 'Unit'); ?></th>
            <th class='Qty'><?php echo Yii::t('app', 'Qty.'); ?></th>
            <th class='Price'><?php echo Yii::t('app', 'Price'); ?></th>
            <th class='Currency'><?php echo Yii::t('app', 'Currency'); ?></th>

            <th class='Total'><?php echo Yii::t('app', 'Total'); ?></th>
            <th class='VAT'><?php echo Yii::t('app', 'VAT'); ?></th>




        </tr>
    <?php
    $i = 0;


    foreach ($model->docDetailes as $docdetail) {
        //print_r($docdetail);
        //echo $this->renderPartial('docdetialview', array('model'=>$docdetail,)); 
        echo "
                <tr>
                    <td class='line'>$docdetail->line</td>
                    <td class='Itemid'>$docdetail->item_id</td>
                    <td class='Name'>$docdetail->name</td>
                    <td class='Description'>$docdetail->description</td>
                        
                    
                    <td class='UntPrice'>$docdetail->iItem</td>
                    <td class='Unit'>" . $docdetail->ItemUnit->name . "</td>
                    <td class='Qty'>$docdetail->qty</td>    
                    <td class='Price'>" . $docdetail->qty * $docdetail->iItem . "</td>
                    <td class='Currency'>$docdetail->currency_id</td>
                    <td class='Total'>$docdetail->iTotal</td>
                    <td class='VAT'>" . ($docdetail->iVatRate / 100) * $docdetail->qty * $docdetail->iItem . "</td>
                 </tr>

                ";
        $i++;
    }
    ?>

        <tr>
            <td class='line'></td>
            <td class='Itemid'></td>
            <td class='Name'></td>
            <td class='Description'></td>
            <td class='UntPrice'></td>
            <td class='Unit'></td>
            <td class='Qty'></td>
            <td class='Price'></td>
            <td class='Currency'><?php echo Yii::t('app', 'Subtotal tax excluded'); ?></td>
            <td class='Total'><?php echo $model->sub_total; ?></td>
            <td class='VAT'><?php //echo $model->vat;  ?></td>
        <tr>
        <tr>
            <td class='line'></td>
            <td class='Itemid'></td>
            <td class='Name'></td>
            <td class='Description'></td>
            <td class='UntPrice'></td>
            <td class='Unit'></td>
            <td class='Qty'></td>
            <td class='Price'></td>
            <td class='Currency'><?php echo Yii::t('app', 'Subtotal VAT'); ?></td>
            <td class='Total'><?php echo $model->vat; ?></td>
            <td class='VAT'></td>
        <tr>
        <tr>
            <td class='line'></td>
            <td class='Itemid'></td>
            <td class='Name'></td>
            <td class='Description'></td>
            <td class='UntPrice'></td>
            <td class='Unit'></td>
            <td class='Qty'></td>
            <td class='Price'></td>
            <td class='Currency'><?php echo Yii::t('app', 'Subtotal tax exempt'); ?></td>
            <td class='Total'><?php echo $model->novat_total; ?></td>
            <td class='VAT'></td>
        </tr>
        <tr>
            <td class='line'></td>
            <td class='Itemid'></td>
            <td class='Name'></td>
            <td class='Description'></td>
            <td class='UntPrice'></td>
            <td class='Unit'></td>
            <td class='Qty'></td>
            <td class='Price'></td>
            <td class='Currency'><?php echo Yii::t('labels', 'Discount'); ?></td>
            <td class='Total'><?php echo (($model->disType) ? "%" : "") . $model->discount; ?></td>
            <td class='VAT'><?php //echo $model->vat;  ?></td>
        <tr>
        <tr>
            <td class='line'></td>
            <td class='Itemid'></td>
            <td class='Name'></td>
            <td class='Description'></td>
            <td class='UntPrice'></td>
            <td class='Unit'></td>
            <td class='Qty'></td>
            <td class='Price'></td>
            <td class='Currency'><?php echo Yii::t('labels', 'Subtotal to pay'); ?></td>
            <td class='Total'><?php echo $model->total; ?></td>
            <td class='VAT'></td>
        </tr>		
    </table>

    <?php
}

//echo count($model->docCheques);
/* * *************************************************************************************************************************** */
if (count($model->docCheques) != 0) {
    ?>


    <table class="table">
        <tr>
            <th class='Type'><?php echo Yii::t('labels', 'Type'); ?></th>   
            <th class='Line'><?php echo Yii::t('labels', 'Line'); ?></th> 
            <th class='Details'><?php echo Yii::t('labels', 'Details'); ?></th>

            <th class='Currency'><?php echo Yii::t('labels', 'Currency'); ?></th>
            <th class='Sum'><?php echo Yii::t('labels', 'Sum'); ?></th>
        </tr>
    <?php
    $i = 0;


    foreach ($model->docCheques as $rcptdetail) {

        echo "
                <tr>
                    <td class='Type'>".Yii::t("app",$rcptdetail->Type->name)."</td>
                    <td class='Line'>$rcptdetail->line</td>
                    <td class='Detailes'>".$rcptdetail->printDetails()."</td>
                    
                    <td class='Currency'>$rcptdetail->currency_id</td>
                    <td class='Sum'>$rcptdetail->sum</td>

                 </tr>

                ";
        $i++;
    }
    ?>



    </table>

    <?php
    /*     * *************************************************************************************************************************** */
}
?>


<br />
<?php echo Yii::t('app', 'Comments'); ?>: <?php echo $model->description; ?>
<br />
<br />






<?php
//$this->endWidget(); 
?>
<script type="text/javascript">
//$(function () {
    preview =<?php echo $preview; ?>;

    if (preview == 0) {
        window.print();
        window.location = "<?php echo Yii::app()->CreateURL('docs/admin') ?>"
        //return url
    }
//});

</script>