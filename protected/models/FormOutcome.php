<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of FormOutcome
 *
 * @author adam
 */
class FormOutcome extends CFormModel{
    public $account_id;
    public $currency_id;
    public $date;
    public $sum;
    public $detailes;
    
    public $refnum;
    public $Docs= NULL;
    public $refnum_ids ='';
    
    //public $user_id;//?
    public $opp_account_id;
    public function rules(){
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
                        array('account_id, currency_id, date, sum, opp_account_id', 'required'),
                        array('account_id, currency_id, date, sum, opp_account_id, refnum_ids, detailes', 'safe'),
                    	);
	}
        
        public function getRef(){
            return array();//stub function for refnum widget...
        }
   public function transaction(){
        $valuedate=date("Y-m-d H:m:s",CDateTimeParser::parse($this->date,Yii::app()->locale->getDateFormat('yiishort')));
        $num=0;
        $line=1;
        $tranType=  Yii::app()->user->settings["transactionType.supplierPayment"];
        $tran=new Transactions();
        $opt_tran=new Transactions();

        $tran->num=$num;
        $tran->account_id=$this->account_id;
        $tran->type=$tranType;
        $tran->refnum1=$this->refnum_ids;
        $tran->valuedate=$valuedate;
        $tran->details=$this->detailes;
        $tran->currency_id=$this->currency_id;
        $tran->owner_id=Yii::app()->user->id;
        $tran->linenum=$line;
        $tran->sum=$this->sum;
        $line++;
        $num=$tran->save();

        $opt_tran->num=$num;
        //$vat->account_id=Yii::app()->user->settings['company.acc.vatacc'];
        $opt_tran->account_id=$this->opp_account_id;
        $opt_tran->type=$tranType;
        $opt_tran->refnum1=$this->refnum_ids;
        $opt_tran->valuedate=$valuedate;
        $opt_tran->details=$this->detailes;
        $opt_tran->currency_id=$this->currency_id;
        $opt_tran->owner_id=Yii::app()->user->id;
        $opt_tran->linenum=$line;
        $opt_tran->sum=$this->sum*-1;
        $line++;
        //print_r($vat->attributes);
        $num=$opt_tran->save();
        $this->saveRef($num,$this->sum);
        
        return true;
   }
        
   public function saveRef($id,$total){
        $str=$this->refnum;//save new values
        

        $sum=0;
        $tmp=explode(",",rtrim($str, ","));
        foreach($tmp as $id){//lets do this
            //if($id==$this->id){
            //    throw new CHttpException(500,Yii::t('app','You cannot save doc as a refnum'));
            //}
            $doc=Docs::model()->findByPk((int)$id);
            if($doc!==null){
                $sum+=$doc->total;//adam: need to multi currency!
                if($sum<=$total){
                    $doc->refstatus=Docs::STATUS_CLOSED;
                }else{
                    $doc->refstatus=Docs::STATUS_OPEN;
                }
                $doc->refnum=$id;
                $doc->save();
            }
        }
        //$this->refnum=$str;
    }
   
   
   
}

?>
