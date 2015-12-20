<?php

/***********************************************************************************
 * The contents of this file are subject to the GNU AFFERO GENERAL PUBLIC LICENSE Version 3.0
 * ("License"); You may not use this file except in compliance with the GNU AFFERO GENERAL PUBLIC LICENSE Version 3.0
 * The Original Code is:  Linet 3.0 Open Source
 * The Initial Developer of the Original Code is Adam Ben Hur.
 * All portions are Copyright (C) Adam Ben Hur.
 * All Rights Reserved.
 ************************************************************************************/

namespace app\models;
use yii\base\Model;
use Yii;
class InstallPre extends Model {
        public $step=1;

        
        
	public function rules() {
		return array(
			array('type', 'required'),
		);
	}

        
        private function phpchk($str){
            if(extension_loaded($str))
                return Yii::t('app', "OK");
            else 
                return Yii::t('app',"Failed");
            
        }

         private function apachechk($str){
            $array=[];
             if (function_exists('apache_get_modules')) 
                $array=apache_get_modules();
            if(in_array($str,$array))
                return Yii::t('app', "OK");
            else 
                return Yii::t('app', "Failed");
            
        }
        
        private function filechk($str){
            if(is_writable($str))
                return Yii::t('app',"Writable");
            else 
                return Yii::t('app',"Denaid");
            
        }
        public function report(){
        
            //print_r(apache_get_modules());
            $data=array(
              array('id'=>'PHP Version','value'=>phpversion()),  
              array('id'=>'PHP PDO','value'=>$this->phpchk("PDO")),
                array('id'=>'PHP Zip','value'=>$this->phpchk("zip")),
                array('id'=>'PHP CURL','value'=>$this->phpchk("curl")),
                array('id'=>'PHP PDO Mysql','value'=>$this->phpchk("pdo_mysql")),
                array('id'=>'PHP PDO Sqlite','value'=>$this->phpchk("pdo_sqlite")),
                array('id'=>'PHP OpenSSL','value'=>$this->phpchk("openssl")),
                array('id'=>'Apache mod Rewrite','value'=>$this->apachechk("mod_rewrite")),
                
                //array('id'=>'Apache mod Rewrite','value'=>$this->filechk("private/")),
                array('id'=>'file permission','value'=>$this->filechk("index.php")),
            );
            //if()
            $this->step=1;
            return new \yii\data\ArrayDataProvider(
                     array(
		'allModels'=>$data,
                                    'pagination'=>array(
                                        'pageSize'=>100,
                                ),
                    )             
              );
    }
        
   
	public function getForm() {
            $php_version=phpversion();
            
            
		return new CForm(array(
			'showErrorSummary'=>true,
			'attributes'=>array('id'=>'install'),
			'elements'=>array(
				'php_version'=>array(
					'layout'=>'{label}<br/>{input}<br/>{error}'
				),
			),
			'buttons'=>array(
				'submit'=>array(
					'type'=>'submit',
					'label'=>'Next'
				)
			)
		), $this);
	}
}
