<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<div class="updatetext">
    <?php echo Yii::t('update', "Backup system and database, it is heighly advised to save a local copy of the backup files");?><br />
    <?php echo Yii::t('update', "Backuping system files");?><br />
    


    <?php echo  Yii::t('update', "Done");?><br />
    
    <a href='<?php echo $this->createUrl('/newUpdate/backupfile');?>'> <?php echo Yii::t('update', "Downlod System Files") ?></a><br />
    <?php echo  Yii::t('update', "Backuping database");?><br />
    
    <?php echo Yii::t('update', "Done");?> <br />

    <a href='<?php echo $this->createUrl('/data/download')."/".$model->DBback;?>'><?php echo Yii::t('update', "Download Database file");?></a><br />
    
</div>

<div class="control"><a class="btn btn-primary" onclick="document.location.href = '../'" ><?php echo Yii::t('update', "Cancel");?></a>
    <a class="btn btn-primary" onclick="loadDoc('<?php echo $this->createUrl('/newUpdate/update'); ?>')" ><?php echo Yii::t('update', "Next");?></a></div>