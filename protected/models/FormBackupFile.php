<?php
/***********************************************************************************
 * The contents of this file are subject to the GNU AFFERO GENERAL PUBLIC LICENSE Version 3
 * ("License"); You may not use this file except in compliance with the GNU AFFERO GENERAL PUBLIC LICENSE Version 3
 * The Original Code is:  Linet 3.0 Open Source
 * The Initial Developer of the Original Code is Adam Ben Hur.
 * All portions are Copyright (C) Adam Ben Hur.
 * All Rights Reserved.
 ************************************************************************************/
namespace app\models;
use Yii;
use yii\base\Model;
class FormBackupFile extends Model{
    public $file;
    
    public function rules(){
        return array(
            //array('file','file','allowEmpty'=>false,'types'=>'sql, bak'),
            array('file', 'safe')
        );
        
    }
    
    public function attributeLabels() {
        return array(
            'file' => Yii::t('app', 'File'),
            
            
        );
    }
    
    //put your code here
}
