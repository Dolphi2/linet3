<?php

/* * *********************************************************************************
 * The contents of this file are subject to the GNU AFFERO GENERAL PUBLIC LICENSE Version 3
 * ("License"); You may not use this file except in compliance with the GNU AFFERO GENERAL PUBLIC LICENSE Version 3
 * The Original Code is:  Linet 3.0 Open Source
 * The Initial Developer of the Original Code is Adam Ben Hur.
 * All portions are Copyright (C) Adam Ben Hur.
 * All Rights Reserved.
 * ********************************************************************************** */

/**
 * This is the model class for table "transactions".
 *
 * The followings are the available columns in table 'transactions':
 * @property integer $id
 * @property integer $num
 * @property integer $account_id
 * @property string $refnum1
 * @property string $refnum2
 * @property string $valuedate
 * @property string $date
 * @property string $details
 * @property integer $currency_id
 * @property string $sum
 * @property string $leadsum
 * @property integer $owner_id
 * @property integer $linenum
 */
namespace app\models;

use Yii;
use app\components\basicRecord;
use yii\helpers\Html;
class Transactions extends basicRecord {

    const table = '{{%transactions}}';
    public $from_date;//no-need
    public $to_date;//no-need
    public $Docs = NULL;
    public $refnum1_ids = '';
    //public $refnum2='';
    public $maxNum;
    


    public function addSingleLine($account_id,$sum,$valuedate=null){

        $round = new Transactions();
        $round->num = $this->num;
        $round->account_id = $account_id;
        $round->type = $this->type;
        $round->refnum1 = $this->refnum1;
        $round->refnum2 = $this->refnum2;
        $round->valuedate = $this->valuedate;
        if($valuedate!=null){
            $round->valuedate = $valuedate;
        }
        $round->details = $this->details;
        $round->currency_id = $this->currency_id;
        $round->currency_rate = $this->currency_rate;
        $round->sum = $sum;
        $round->owner_id = $this->owner_id;
        $round->linenum = $this->linenum;
        $this->linenum++;
        $this->num = $round->save();
        
        
        return $this;
    }
    
    
    public function addDoubleLine($account_id,$oppt_account_id,$sum,$valuedate=null) {
        return $this->addSingleLine($oppt_account_id,$sum*-1,$valuedate)->addSingleLine($account_id,$sum,$valuedate);
    }

    public function getRef() {
        return array(); //
    }



    ///*
    public function openfrmt($line) {
        $trans = '';

        //get all fields (b110) sort by id
        $fields = OpenFormat::find()->where(['type_id'=>'B100'])->All();

        //loop strfgy
        foreach ($fields as $field) {
            $trans.=$this->openfrmtFieldStr($field, $line);
        }
        return $trans . "\r\n";
    }

//*/


    public function numLink() {

        return Html::a($this->num,  yii\helpers\BaseUrl::base().("/transaction/view/$this->num"));
    }

    public function accountLink() {
        $str = '';



        //$account_id = Docs::findOne($this->account_id);
        if ($this->account !== null) {
            $str.= Html::a(Html::encode($this->account->name),  yii\helpers\BaseUrl::base().("/accounts/transaction/$this->account_id"));
        } else {
            $str.=$this->account_id;
        }



        return $str;
    }

    public function refnumDocsLink() {
        $str = '';
        $array = explode(",", $this->refnum1);

        foreach ($array as $docid) {
            $str.=Docs::linkById($docid).",";
        }

        return rtrim($str, ",");
    }

    /**
     * @return string the associated database table name
     */
    public static function tableName() {
        return self::table;
    }

    public function opefrmtMrk() {
        if ($this->sum >= 0.0)
            return 2;
        else
            return 1;
    }

    public function getBalance() {
       
        $models = Transactions::find()->where("num <= :num AND account_id=:account_id",[':num' => $this->num,':account_id'=>$this->account_id])->All();
        $balance = 0;
        foreach ($models as $model) {
            $balance+=$model->sum;
        }

        return $balance;
    }

   

    private function newNum() {
        if ($this->num == 0) {

            $transaction=\app\helpers\Linet3Helper::getSetting('company.transaction');
            \app\helpers\Linet3Helper::setSetting('company.transaction',$transaction+1);
        
            return (int) $transaction; //adam: has to go
        } else {
            return (int) $this->num;
        }
    }

    public static function getMax() {
        $num = Transactions::find()->select('max(num)')->scalar();
        
        return $num;
    }

    public function beforeSave($insert) {
        if($this->getIsNewRecord()){

            $this->num = $this->newNum();
            if ($this->reg_date == null)
                $this->reg_date = date("Y-m-d H:i:s");
            if ($this->refnum2 == null)
                $this->refnum2 = '';


            $cur = \app\helpers\Linet3Helper::getSetting('company.cur');
            $acc = Accounts::findOne($this->account_id);
            if ($acc === null) {
                $acccur = $this->currency_id;
            } else {
                $acccur = $acc->currency_id;
            }


            if ($this->currency_id == '') {
                $this->currency_id = $cur;
                $this->sum = $this->leadsum;
            }

            //leadsum
            if ($this->currency_rate == null) {
                $this->currency_rate = Currates::GetRate($this->currency_id, $this->valuedate);
            }



            if ($cur == $this->currency_id) {
                $this->leadsum = $this->sum;
            } else {

                $this->leadsum = $this->sum * $this->currency_rate;
            }



            //open format import uses this
            //set sum accourding to acc
            if (!isset($this->sum)) {//adam need to dubl chk
                if ($this->currency_id != $acccur) {
                    $this->currency_id = $acccur;
                    $rate = Currates::GetRate($acccur, $this->valuedate);
                    if ($rate == 0) {
                        throw new \Exception(Yii::t('app', 'The rate for') . $this->currency_id . Yii::t('app', 'is invalid'));
                    }
                    $this->sum = $this->leadsum / $rate;
                }
            }

            //secsum
            $seccur = \app\helpers\Linet3Helper::getSetting('company.seccur');
            //$seccur = Yii::$app->user->settings['company.seccur'];
            if ($seccur != '') {
                if ($seccur == $this->currency_id)
                    $this->secsum = $this->sum;
                else {
                    $rate = Currates::GetRate($seccur, $this->valuedate);
                    if ($rate == 0) {
                        throw new \Exception(Yii::t('app', 'The sec rate for') . $seccur . $this->currency_id . Yii::t('app', 'is invalid'));
                    }
                    $this->secsum = $this->leadsum / $rate;
                }
            }
        }

        return parent::beforeSave($insert);
    }

    public function save($runValidation = false, $attributes = NULL) {

        parent::save($runValidation, $attributes);
        
        if($this->refnum2===null)
            $this->refnum2='';
        return $this->num;
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array(['num', 'account_id', 'valuedate', 'currency_id', 'currency_rate', 'sum', 'owner_id', 'linenum'], 'required','on'=>'default'),
            array(['num', 'account_id', 'owner_id', 'linenum'], 'number', 'integerOnly' => true),
            array(['refnum1', 'refnum2', 'details'], 'string', 'max' => 255),
            array(['valuedate', 'reg_date', 'refnum1_ids'], 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array(['type', 'from_date', 'to_date', 'id', 'num', 'account_id', 'type', 'refnum1', 'refnum2', 'valuedate', 'reg_date', 'details', 'currency_id', 'sum', 'leadsum', 'owner_id', 'linenum'], 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'Type' => array(self::BELONGS_TO, 'TransactionType', 'type'),
            //'docStatus'=>array(self::BELONGS_TO, 'Docstatus', array('status','doctype')),
            'Account' => array(self::BELONGS_TO, 'Accounts', 'account_id'),
            'Owner' => array(self::BELONGS_TO, 'Users', 'owner_id'),
        );
    }
    
    
    public function getTtype(){
        return $this->hasOne(TransactionType::className(), array('id' => 'type'));
    }
    
     public function getAccount(){
        return $this->hasOne(Accounts::className(), array('id' => 'account_id'));
    }
    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => Yii::t('app', 'ID'),
            'num' => Yii::t('app', 'Num'),
            'account_id' => Yii::t('app', 'Account'),
            'type' => Yii::t('app', 'Type'),
            'refnum1' => Yii::t('app', 'Refnum 1'),
            'refnum2' => Yii::t('app', 'Refnum 2'),
            'valuedate' => Yii::t('app', 'Value Date'),
            //'due_date' => Yii::t('app', 'Due Date'),
            'reg_date' => Yii::t('app', 'Create Date'),
            'details' => Yii::t('app', 'Details'),
            'currency_id' => Yii::t('app', 'Currency'),
            'sum' => Yii::t('app', 'Sum'),
            'leadsum' => Yii::t('app', 'Lead Sum'),
            'owner_id' => Yii::t('app', 'Owner'),
            'linenum' => Yii::t('app', 'Line No.'),
            'type' => Yii::t('app', 'Type'),
        );
    }

    public function searchIn() {
        //account_id,intCorrelation!=0,sum<0
        $cDataProvider = $this->search([]);

        $cDataProvider->query->andFilterWhere(['>',"sum",0]);
        $cDataProvider->query->andFilterWhere(["intCorrelation"=>0]);

        return $cDataProvider;
    }

    public function searchOut() {
        //account_id,intCorrelation!=0,sum<0
        $cDataProvider = $this->search([]);

        $cDataProvider->query->andFilterWhere(['<',"sum",0]);
        $cDataProvider->query->andFilterWhere(["intCorrelation"=>0]);

        return $cDataProvider;
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */

    
    public function search($params)
    {
        $query = Transactions::find();

        $dataProvider = new \yii\data\ActiveDataProvider([
            'query' => $query,
            "sort"=> ['defaultOrder' => [
                'num'=>SORT_DESC,
                ]]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            var_dump($this->errors);
        //    return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'num' => $this->num,
            'account_id' => $this->account_id,
            'type' => $this->type,
            'refnum1' => $this->refnum1,
            'extCorrelation' => $this->extCorrelation,
   
        ]);
        
        $query->andFilterWhere(['like', 'details', $this->details]);

        
        if(!is_null($this->valuedate)){
            $tmp=  explode(" to ", $this->valuedate);
            if(isset($tmp[0])&&isset($tmp[1]))        
                $query->andFilterWhere(['between', 'valuedate', $tmp[0], $tmp[1]]);
        }
        
        if(!is_null($this->reg_date)){
            $tmp=  explode(" to ", $this->reg_date);
            if(isset($tmp[0])&&isset($tmp[1]))        
                $query->andFilterWhere(['between', 'reg_date', $tmp[0], $tmp[1]]);
        }
        
        
        return $dataProvider;
    }
}
