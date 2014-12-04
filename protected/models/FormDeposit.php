<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of FormDeposit
 *
 * @author adam
 */
class FormDeposit  extends CFormModel{
    public $account_id=0;
    public $refnum=0;
    public $currency_id='';
    public $date;
    public $cheq_sum=0;
    public $cash_sum=0;
    public $Deposit=array();
    public $Total=array();
    
    
    public function attributeLabels() {
        return array(
            'account_id' => Yii::t('labels', 'Account'),
            'currency_id' => Yii::t('labels', 'Currency'),
            'date' => Yii::t('labels', 'Date'),
            'sum' => Yii::t('labels', 'Sum'),
            'refnum' => Yii::t('labels', 'Refnum'),
            'cheq_sum' => Yii::t('labels','Check Sum'),
            'cash_sum' => Yii::t('labels', 'Cash Sum'),
            
        );
    }
    
    
    
    public function beforeSave(){
            $this->date=date("Y-m-d H:i:s",CDateTimeParser::parse($this->date,Yii::app()->locale->getDateFormat('yiishort')));
            
            //return true;
            return parent::beforeSave();
        }
        
        public function afterSave(){
           $this->date=date(Yii::app()->locale->getDateFormat('phpshort'),strtotime($this->date));
            
            return parent::afterSave();
        }
    
    
    public function rules(){
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
                        array('account_id, refnum, date, Deposit, Total', 'required'),
                        array('account_id, refnum, date, Deposit, Total', 'safe'),
                    	);
	}
    
    public function save(){
            //print_r($this->Deposit);
            $num=0;
            $linenum=1;
            $tranType=Settings::model()->findByPk('transactionType.chequedeposit')->value;
            if(($this->refnum=='')||($this->date=='')||!is_array($this->Deposit)){
                return false;
            }
            $valuedate = date("Y-m-d H:m:s", CDateTimeParser::parse($this->date, Yii::app()->locale->getDateFormat('yiishort')));
            
            foreach($this->Deposit as $line=>$val){
                list($a, $b ) =  explode(',', $line);
                $cheq=  Doccheques::model()->findByPk(array("doc_id"=>$a,"line"=>$b));
                $oppt_acc=  PaymentType::model()->findByPk($cheq->type)->oppt_account_id;
                //print_r($cheq);
                
                $accout=new Transactions();
                $accout->num=$num;
                $accout->account_id=$this->account_id;
                $accout->type=$tranType;
                $accout->refnum1=$this->refnum;
                $accout->valuedate=$valuedate;
                //$accout->details=$this->company;
                $accout->currency_id=$cheq->currency_id;
                $accout->owner_id=Yii::app()->user->id;
                $accout->linenum=$linenum;
                $accout->sum=$cheq->sum*1;
                $linenum++;
                $num=$accout->save();
                
                $oppt=new Transactions();
                $oppt->num=$num;
                $oppt->account_id=$oppt_acc;
                $oppt->type=$tranType;
                $oppt->refnum1=$this->refnum;
                $oppt->valuedate=$valuedate;
                //$oppt->details=$this->company;
                $oppt->currency_id=$cheq->currency_id;
                $oppt->owner_id=Yii::app()->user->id;
                $oppt->linenum=$linenum;
                $oppt->sum=$cheq->sum*-1;
                $linenum++;
                $num=$oppt->save();
                
                
                $cheq->bank_refnum=$num;
                $cheq->save();
            }
            
            
            
            
            //Yii::app()->end();
            
            
            
        return $num;
    }
    //put your code here
}
