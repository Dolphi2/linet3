<?php

/* * *********************************************************************************
 * The contents of this file are subject to the Mozilla Public License Version 2.0
 * ("License"); You may not use this file except in compliance with the Mozilla Public License Version 2.0
 * The Original Code is:  Linet 3.0 Open Source
 * The Initial Developer of the Original Code is Adam Ben Hur.
 * All portions are Copyright (C) Adam Ben Hur.
 * All Rights Reserved.
 * ********************************************************************************** */

/**
 * This is the model class for table "docs".
 *
 * The followings are the available columns in table 'docs':
 * @property string $id
 * @property string $doctype
 * @property string $docnum
 * @property string $account
 * @property string $company
 * @property string $address
 * @property string $city
 * @property string $zip
 * @property string $vatnum
 * @property string $refnum
 * @property string $issue_date
 * @property string $due_date
 * @property string $sub_total
 * @property string $novat_total
 * @property string $vat
 * @property string $total
 * @property string $src_tax
 * @property integer $status
 * @property integer $currency_id
 * @property integer $printed
 * @property string $comments
 * @property integer $owner
 */
class Docs extends fileRecord {

    const table = '{{docs}}';

    //public $lang;
    public $preview=0;
    public $docDet = NULL;
    public $docCheq = NULL;
    public $Docs = NULL;
    public $rcptsum = 0;
    public $issue_from;
    public $issue_to;
    public $stockSwitch = 1;
    public $refnum_ids = '';
    private $dateDBformat = true;
    public $maxDocnum;

    const STATUS_OPEN = 0;
    const STATUS_CLOSED = 1;

    //const STATUS_DRAFT=3;
    /*
      public function __construct($arg = NULL) {
      //    public function __construct($type=0) {
      parent::_construct();
      //$doctype=Doctype::model()->findByPk($type);
      //$this->docType=model;
      //$this->doctype=$type;

      }// */

    public function hasAttribute($name) {
        if ($name == "docDet" || $name == "docCheq")
            return true;
        else
            return parent::hasAttribute($name);
    }

    public function init() {
        $this->issue_date = date(Yii::app()->locale->getDateFormat('phpdatetimes'));
        $this->due_date = date(Yii::app()->locale->getDateFormat('phpdatetimes'));
        $this->ref_date = date(Yii::app()->locale->getDateFormat('phpdatetimes'));
        return parent::init();
    }

    public static function findAllByType($doctype) {

        return Docs::model()->findAllByAttributes(array('doctype' => $doctype));
    }

    public function draftSave() {
        $status = Docstatus::model()->findByAttributes(array('looked' => 0, 'doc_type' => $this->doctype));
        if ($status !== null) {
            $this->status = $status->num;
        }
    }

    /*
     * for open format export 
     */

    public function findByNum($docnum, $doctype) {

        return Docs::model()->findByAttributes(array('docnum' => $docnum, 'doctype' => $doctype));
    }

    public function getRef() {
        $this->refnum_ids = '';
        $this->Docs = Docs::model()->findAllByAttributes(array('refnum' => $this->id));
        if ($this->Docs !== null) {
            foreach ($this->Docs as $doc)
                $this->refnum_ids.=$doc->id . ", ";
        }
    }

    public static function getRefStatuses() {
        return self::getConstants('STATUS_', __CLASS__);
    }

    public function getRefStatus() {
        $list = $this->getRefStatuses();
        //print_r($list);
        //return "";
        return Yii::t('app', $list[$this->refstatus]['name']);
    }

    public function getTypeName() {
        if ($this->docType)
            return Yii::t("app", $this->docType->name);
        else
            return $this->doctype;
    }

    public function getStatus() {
        if ($this->docStatus)
            return Yii::t('app', $this->docStatus->name);
        else
            return $this->status;
    }

    public function getType($type = '') {
        if ($type == '') {
            return isset($this->docType) ? $this->docType->openformat : "";
        } else {
            $this->doctype = Doctype::model()->getOType($type);
            return $this->doctype;
        }
    }

    public function openfrmt($line) {
        $docs = '';

        //get all fields (m100) sort by id
        $criteria = new CDbCriteria;
        $criteria->condition = "type_id = :type_id";
        $criteria->params = array(':type_id' => "C100");
        $fields = OpenFormat::model()->findAll($criteria);

        //loop strfgy
        foreach ($fields as $field) {
            $docs.=$this->openfrmtFieldStr($field, $line);
        }
        return $docs . "\r\n";
    }

    public function pcn874() {
        //stringfy a doc by pcn874
        //A1    type
        //N9    oppt-vatid
        //N8    inv date YYYYMMDD
        //A4    0000
        //N9    doc number
        //N9    vat sum(round)
        //A1    +\-
        //N10   inv sum(round)
        //N9    000000000
        //S
        //3,4,9,11
        //T
        //13,14  
        $a = "T";
        if (in_array($this->doctype, array(3, 4, 9, 11)))
            $a = "S";
        else if (in_array($this->doctype, array(13, 14)))
            $a = "T";
        else
            echo $this->docnum;
        $opptacc = $this->vatnum;
        $docdate = date("Ymd", CDateTimeParser::parse($this->issue_date, Yii::app()->locale->getDateFormat('yiidatetimesec')));
        $doctype = $this->doctype;
        $docnum = $this->docnum;
        $vatsum = $this->vat;
        $plusmin = ($this->total >= 0) ? "+" : "-";
        $docsum = $this->total;
        return sprintf("%1s%09d%08d0000%02d%07d%09d%1s%010d000000000", $a, $opptacc, $docdate, $doctype, $docnum, $vatsum, $plusmin, $docsum);
    }

    public function beforeSave() {
        if ($this->isNewRecord) {
            $this->dateDBformat = false;
        }
        if ($this->reg_date == null)
            $this->reg_date = date(Yii::app()->locale->getDateFormat('phpdatetimes'));

        //echo Yii::app()->locale->getDateFormat('yiishort');
        //echo $this->due_date;
        //echo CDateTimeParser::parse($this->due_date,Yii::app()->locale->getDateFormat('yiishort'));
        //echo date("Y-m-d H:m:s",CDateTimeParser::parse($this->due_date,Yii::app()->locale->getDateFormat('yiishort')));
        //echo $this->due_date.";".$this->issue_date.";".$this->modified."<br>";
        if (!$this->dateDBformat) {
            $this->dateDBformat = true;
            $this->due_date = date("Y-m-d H:i:s", CDateTimeParser::parse($this->due_date, Yii::app()->locale->getDateFormat('yiidatetime')));
            $this->issue_date = date("Y-m-d H:i:s", CDateTimeParser::parse($this->issue_date, Yii::app()->locale->getDateFormat('yiidatetime')));
            $this->reg_date = date("Y-m-d H:i:s", CDateTimeParser::parse($this->reg_date, Yii::app()->locale->getDateFormat('yiidatetime')));
            $this->ref_date = date("Y-m-d H:i:s", CDateTimeParser::parse($this->ref_date, Yii::app()->locale->getDateFormat('yiidatetime')));
        }
        //return true;
        //echo $this->due_date.";".$this->issue_date.";".$this->modified;
        //Yii::app()->end();
        return parent::beforeSave();
    }

    public function afterSave() {
        if ($this->dateDBformat) {
            $this->dateDBformat = false;
            $this->due_date = date(Yii::app()->locale->getDateFormat('phpdatetimes'), strtotime($this->due_date));
            $this->issue_date = date(Yii::app()->locale->getDateFormat('phpdatetimes'), strtotime($this->issue_date));
            $this->reg_date = date(Yii::app()->locale->getDateFormat('phpdatetimes'), strtotime($this->reg_date));
            $this->ref_date = date(Yii::app()->locale->getDateFormat('phpdatetimes'), strtotime($this->ref_date));
        }
        return parent::afterSave();
    }

    public function afterFind() {
        if ($this->dateDBformat) {
            $this->dateDBformat = false;
            $this->due_date = date(Yii::app()->locale->getDateFormat('phpdatetimes'), strtotime($this->due_date));
            $this->issue_date = date(Yii::app()->locale->getDateFormat('phpdatetimes'), strtotime($this->issue_date));
            $this->reg_date = date(Yii::app()->locale->getDateFormat('phpdatetimes'), strtotime($this->reg_date));
            $this->ref_date = date(Yii::app()->locale->getDateFormat('phpdatetimes'), strtotime($this->ref_date));
        }

        $this->getRef();
        return parent::afterFind();
    }

    public function save($runValidation = true, $attributes = NULL) {
        $this->owner = Yii::app()->user->id;
        if ($this->total == 0)
            $this->total = $this->rcptsum;
        $a = parent::save($runValidation, $attributes);

        if (!$a)
            return $a;
        if (!is_null($attributes))
            return $a;





        //if ($a) { //if switch no save
        $this->saveRef(); //load docs and re-save them
        if (!$this->action) {
            if ($this->status === null)
                throw new CHttpException(500, Yii::t('app', 'No status recived'));
            $this->docStatus = Docstatus::model()->findByPk(array('num' => $this->status, 'doc_type' => $this->doctype));
            if ($this->docStatus === null)
                throw new CHttpException(500, Yii::t('app', 'Status is Invalid'));

            $this->saveDet();
            $this->saveCheq();
            $this->calc();
            $this->validate();
            if (count($this->getErrors()) != 0)
                return false;
            if (isset($this->docStatus)) {
                if ($this->docStatus->action != 0) {
                    $this->docnum = $this->newNum(); //get num 
                    $this->action = 1;
                    $a = parent::save($runValidation, $attributes);


                    $this->transaction((int) $this->docStatus->action);
                    if (is_null($this->docType->transactionType_id)) {//only if !transaction stock
                        foreach ($this->docDetailes as $docdetail) {
                            $this->stock($docdetail->item_id, $docdetail->qty);
                        }
                    }
                }
            }
        }
        //} //else {
        // throw new CHttpException(500, Yii::t('app', 'Uneable to save document'));
        //}
        return $a;
    }

    public function saveRef() {
        $str = $this->refnum_ids; //save new values

        $this->getRef();    //load old
        //no skipping is allowed anymore if cur,total change...
        //if($str==$this->refnum_ids) //if the same skip
        //    return true;
        //echo $str;

        if ($this->Docs !== null) {//clear!
            foreach ($this->Docs as $doc) {
                $doc->refstatus = Docs::STATUS_OPEN;
                $doc->refnum = '';
                $doc->save();
            }
        }
        $sum = 0;
        $tmp = explode(",", $str);
        foreach ($tmp as $id) {//lets do this
            if ($id == $this->id) {
                throw new CHttpException(500, Yii::t('app', 'You cannot save doc as a refnum'));
            }
            $doc = Docs::model()->findByPk((int) $id);
            if ($doc !== null) {
                $sum+=$doc->total; //adam: need to multi currency!
                if ($sum <= $this->total) {
                    $doc->refstatus = Docs::STATUS_CLOSED;
                } else {
                    $doc->refstatus = Docs::STATUS_OPEN;
                }
                $doc->refnum = $this->id;
                $doc->save();
            }
        }
        $this->refnum_ids = $str;
    }

    /*     * *********************doc******************* */

    public function calc() {
        $precision = Yii::app()->user->getSetting('company.precision');

        $this->vat = 0;
        $this->sub_total = 0;
        $this->novat_total = 0;
        $this->total = 0;
        $this->rcptsum = 0;

        if (!is_null($this->docDet)) {
            foreach ($this->docDet as $key => $detial) {
                $vat = $detial['iTotalVat'] - $detial['ihTotal'];

                if ($vat != 0) {
                    $this->vat += round($vat,$precision);
                    $this->sub_total += round($detial['ihTotal'],$precision);
                } else {
                    $this->novat_total += round($detial['ihTotal'],$precision);
                }
            }
        }

        if (!is_null($this->docCheq)) {
            foreach ($this->docCheq as $key => $rcpt) {
                $this->rcptsum += $rcpt['sum'];
            }
        }

        /**/
        if ($this->discount !== 0) {
            $docdetail = $this->calcDiscount();
            $iVat = round($docdetail->iTotalVat-$docdetail->iTotal,$precision);
            $this->vat += $iVat;
            $this->sub_total += $docdetail->iTotal;
        }//*/

        //$this->vat = round($this->vat, $precision);
        //$this->sub_total = round($this->sub_total, $precision);
        //$this->novat_total = round($this->novat_total, $precision);

        $this->total = $this->vat + $this->sub_total + $this->novat_total;


        if ($this->doctype == 8) {//recipt
            $this->total = $this->rcptsum;
        }


        return $this;
    }

    private function calcDiscount() {
        $docdetail = new Docdetails;
        $docdetail->currency_id = $this->currency_id;
        $docdetail->item_id = 1;
        $docdetail->qty = 1;
        $docdetail->iTotalVat = $this->discount * -1;
        $docdetail->CalcPriceWithVat();
        return $docdetail;
    }

    private function saveDet() {
        if (!is_null($this->docDet)) {
            $line = 1;
            foreach ($this->docDet as $key => $detial) {
                $fline = isset($detial['line']) ? $detial['line'] : 0;
                $submodel = Docdetails::model()->findByPk(array('doc_id' => $this->id, 'line' => $fline));
                if ($submodel === null) {//new line
                    $submodel = new Docdetails;
                }

                $submodel->attributes = $detial;
                $submodel->line = $line;
                $submodel->doc_id = $this->id;
                if (Item::model()->findByPk((int) $detial["item_id"]) !== null) {
                    $submodel->iItem=null;
                    if ($submodel->save()) {

                        $this->docDet[$key]['iTotalVat'] = $submodel->iTotalVat;
                        $this->docDet[$key]['ihTotal'] = $submodel->ihTotal;
                        $saved = true;
                        $line++;
                    } else {
                        Yii::log("fatel error cant save docdetial,doc_id:" . $submodel->line . "," . $submodel->doc_id, CLogger::LEVEL_ERROR, __METHOD__);
                    }
                }
            }
            if (count($this->docDetailes) != $line - 1) {//if more items in $docdetails delete them
                for ($curLine = $line; $curLine < count($this->docDetailes); $curLine++)
                    $this->docDetailes[$curLine]->delete();
            }
        }
    }

    /*     * ***********************rcpt***************************** */

    private function saveCheq() {
        if (!is_null($this->docCheq)) {
            $line = 0;
            foreach ($this->docCheq as $key => $rcpt) {
                $submodel = Doccheques::model()->findByPk(array('doc_id' => $this->id, 'line' => $rcpt['line']));
                if (!$submodel) {//new line
                    $submodel = new Doccheques;
                }


                //go throw attr if no save new
                foreach ($rcpt as $key => $value) {
                    if ($submodel->hasAttribute($key))
                        $submodel->$key = $value;
                    else {
                        $eav = new DocchequesEav;
                        $eav->line = $rcpt['line'];
                        $eav->doc_id = $this->id;
                        $eav->attribute = $key;
                        $eav->value = $value['value'];
                        $eav->save();
                    }
                }

                $submodel->doc_id = $this->id;
                if ((int) $rcpt["type"] != 0) {
                    if ($submodel->save()) {
                        $saved = true;
                        $line++;
                    } else {
                        Yii::log("fatel error cant save rcptdetial,doc_id:" . $submodel->line . "," . $submodel->doc_id, CLogger::LEVEL_ERROR, __METHOD__);

                        //Yii::app()->end();
                    }
                }

                //Yii::app()->end();
            }
            if (count($this->docCheques) != $line) {//if more items in $docCheques delete them
                for ($curLine = $line; $curLine < count($this->docCheques); $curLine++)
                    $this->docCheques[$curLine]->delete();
            }
        }
    }

    private function stock($item_id, $qty) {
        if (Yii::app()->user->settings['company.stock']) {// remove from stock.
            $stockAction = $this->docType->stockAction;
            if ($stockAction) {

                if ($this->docType->stockSwitch) {//if has check box
                    if (!$this->stockSwitch)//if not checked
                        return;
                }

                $account_id = Yii::app()->user->warehouse;
                $oppt_account_id = $this->account_id;
                if ((int) $this->oppt_account_id != 0) {
                    if ($this->doctype == 15) {//only if transfer //mybe shuld be only if oppt_account_type==8 wherehouse
                        $account_id = $this->account_id;
                        $oppt_account_id = $this->oppt_account_id;
                    }
                }
                return stockAction::newTransaction($this->id, $account_id, $oppt_account_id, $item_id, $qty * $stockAction);
            }
        }
        return false;
    }

    private function transaction($action) {
        //income account -
        //vat account +
        //costmer accout +
        $precision = Yii::app()->user->getSetting('company.precision');
        $valuedate = date("Y-m-d H:m:s", CDateTimeParser::parse($this->issue_date, Yii::app()->locale->getDateFormat('yiidatetime')));
        //$num = 0;
        $tranType = $this->docType->transactionType_id;
        $round = 0;


        if (!is_null($tranType)) {//has trans action!
            $docAction = new Transactions();
            $docAction->num = 0;
            $docAction->account_id = $this->account_id;
            $docAction->type = $tranType;
            $docAction->linenum = 1;
            $docAction->refnum1 = $this->id;
            $docAction->refnum2 = $this->refnum_ext;
            $docAction->valuedate = $valuedate;
            $docAction->details = $this->company;
            $docAction->currency_id = $this->currency_id;
            $docAction->owner_id = $this->owner;



            if ($this->docType->isdoc) {
                $vatSum = 0;
                $sum = 0;



                foreach ($this->docDetailes as $docdetail) {
                    $refnum2 = $this->stock($docdetail->item_id, $docdetail->qty);
                    $docAction = $docdetail->transaction($docAction, $action, $this->oppt_account_id);
                    //$line++;
                    $multi = 1;
                    if (!is_null($this->oppt_account_id))
                        if ($oppt = Accounts::model()->findByPk($this->oppt_account_id))
                            $multi = ($oppt->src_tax / 100);

                    $iVat = $docdetail->iTotalVat- $docdetail->iTotal;
                    $sum+=($docdetail->iTotal + $iVat) * $action;

                    $iVat*=$multi;
                    $vatSum+= $iVat * $action;
                }

                //******************Discount*******************//

                if ((double) $this->discount != 0) {
                    $docdetail = $this->calcDiscount();

                    $docAction = $docdetail->transaction($docAction, $action, $this->oppt_account_id);
                    $multi = 1;
                    if (!is_null($this->oppt_account_id))
                        if ($oppt = Accounts::model()->findByPk($this->oppt_account_id))
                            $multi = ($oppt->src_tax / 100);

                    $iVat = $docdetail->iTotalVat-$docdetail->iTotal;
                    $sum+=($docdetail->iTotal + $iVat) * $action;

                    $iVat*=$multi;
                    $vatSum+= $iVat * $action;
                }



                //*******************Account*******************//
                $docAction = $docAction->addSingleLine($this->account_id, round($sum * -1, $precision));


                //*******************ROUND***********************//
                $diff = $sum - round($sum, $precision);
                if ($diff) {//diif
                    $docAction = $docAction->addDoubleLine(6, $this->account_id, $diff);
                }


                //*******************VAT***********************//
                if ((double) $vatSum != 0) {
                    $docAction = $docAction->addSingleLine($this->docType->vat_acc_id, round($vatSum, $precision));
                }
            }

            if ($this->docType->isrecipet) {

                foreach ($this->docCheques as $docrcpt) {

                    $docAction = $docrcpt->transaction($docAction, $action, $this->account_id);
                }
            }
        }


        //Yii::app()->end();
    }

    public function delete() {
        if ($this->action == 0) {
            foreach ($this->docDetailes as $detail) {
                $detail->delete();
            }
            foreach ($this->docCheques as $detail) {
                $detail->delete();
            }
            return parent::delete();
        } else {
            return false;
        }
    }

    public function primaryKey() {
        return 'id';
    }

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Docs the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    private function newNum() {
        if ($this->doctype == 0) {
            return 0;
        }

        if (!$this->docnum) {
            $this->docType->last_docnum = $this->docType->last_docnum + 1;
            $this->docType->save();
            return $this->docType->last_docnum;
        } else {
            return $this->docnum;
        }
    }

    public static function getMax($type_id) {
        $model = new Docs;
        $criteria = new CDbCriteria;
        $criteria->select = 'max(docnum) AS maxDocnum';
        $criteria->condition = "doctype = :type_id";
        $criteria->params = array(':type_id' => $type_id);
        $row = $model->model()->find($criteria);
        return $row['maxDocnum'];
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return self::table;
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('account_id, currency_id', 'required'),
            array('stockSwitch, disType, status, printed, owner', 'numerical', 'integerOnly' => true),
            array('city', 'length', 'max' => 40),
            array('doctype, docnum, oppt_account_id, account_id, zip, vatnum', 'length', 'max' => 11),
            array('company, address', 'length', 'max' => 80),
            array('currency_id', 'length', 'max' => 3),
            array('refnum', 'length', 'max' => 20),
            array('vatnum', 'vatnumVal'),
            array('docDet', 'docDetVal'),
            array('docCheq', 'docCheqVal'),
            array('rcptsum, discount, sub_total, novat_total, vat, total, src_tax', 'length', 'max' => 20),
            array('ref_date, issue_date, due_date, comments, description, refnum_ext, refnum_ids, refstatus', 'safe'),
            //array('oppt_account_id, discount, issue_from, issue_to, id, doctype, docnum, account_id, company, address, city, zip, vatnum, refnum, issue_date, due_date, sub_total, novat_total, vat, total, src_tax, status, currency_id, printed, comments, description, owner', 'safe'),
            array('total', 'compare', 'compareAttribute' => 'rcptsum', 'on' => 'invrcpt'),
            array('oppt_account_id', 'required', 'on' => 'opppt_req'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('oppt_account_id, discount, issue_from, refnum_ext, issue_to, id, doctype, docnum, account_id, company, address, city, zip, vatnum, refnum, issue_date, due_date, sub_total, novat_total, vat, total, src_tax, status, currency_id, printed, comments, description, owner, refstatus', 'safe', 'on' => 'search'),
        );
    }

    public function vatnumVal($attribute, $params) {
        if (Linet3Helper::vatnumVal($this->$attribute)) {
            $this->addError($attribute, Yii::t('app', 'Not a valid VAT id'));
        }
    }

    public function docCheqVal($attribute, $params) {
        $line = 0;
        $sum = 0;
        if (!is_null($this->docCheq)) {
            foreach ($this->docCheq as $key => $rcpt) {
                $line++;
                if (!is_array($rcpt)) {
                    return $this->addError($attribute, Yii::t('app', 'Not a valid doc Cheq array'));
                }
                $submodel = new Doccheques;

                //go throw attr if no save new
                foreach ($rcpt as $key1 => $value) {
                    if ($submodel->hasAttribute($key1))
                        $submodel->$key1 = $value;
                }

                $submodel->doc_id = 0;
                if (PaymentType::model()->findByPk((int) $rcpt["type"]) !== null) {
                    if ($submodel->validate()) {
                        $sum+=$submodel->sum;
                    } else {
                        $this->addError($attribute, Yii::t('app', 'Not a valid doc Cheq'));
                    }
                } else {
                    $this->addError($attribute, Yii::t('app', 'Not a valid paymenet type'));
                }
            }
        }
        if ($line) {
            //if (!Linet3Helper::numDiff($sum, (double) $this->rcptsum))
            if ( abs($sum -  $this->total)>0.0001){
                echo  Yii::t('app', 'Total and recipt does not mach') . " " . $sum . " " . $this->total." ".abs($sum -  $this->total);
                exit;
                $this->addError($attribute, Yii::t('app', 'Total and recipt does not mach') . " " . $sum . " " . $this->total);
                
            }
        }
    }

    public function docDetVal($attribute, $params) {
        $line = 0;
        $sum = 0;

        if (!is_null($this->docDet)) {
            $line++;
            foreach ($this->docDet as $key => $detial) {
                if (!is_array($detial)) {
                    return $this->addError($attribute, Yii::t('app', 'Not a valid doc Detail array'));
                }

                $submodel = new Docdetails;

                $submodel->attributes = $detial;
                $submodel->line = $line;
                $submodel->doc_id = 0;
                if (Item::model()->findByPk((int) $detial["item_id"]) !== null) {
                    if ($submodel->validate()) {
                        
                    } else {
                        $this->addError($attribute, Yii::t('app', 'Not a valid doc item'));
                    }
                } else {
                    if ($detial["item_id"] != 0)
                        $this->addError($attribute, Yii::t('app', 'Not a valid item id'));
                }
            }
        }
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'Account' => array(self::BELONGS_TO, 'Accounts', 'account_id'),
            'docCheques' => array(self::HAS_MANY, 'Doccheques', 'doc_id'),
            'docDetailes' => array(self::HAS_MANY, 'Docdetails', 'doc_id'),
            'docType' => array(self::BELONGS_TO, 'Doctype', 'doctype'),
            'docStatus' => array(self::BELONGS_TO, 'Docstatus', array('status', 'doctype')),
            'docOwner' => array(self::BELONGS_TO, 'User', 'owner'),
                //'Files'=>array(self::HAS_MANY, 'Files',array('parent_id'=>'id','parent_type'=>'Docs')),
                //'Currency' => array(self::BELONGS_TO, 'Currecies', 'currency_id'),
        //
            );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => Yii::t('labels', 'ID'),
            'doctype' => Yii::t('labels', 'Document Type'),
            'docnum' => Yii::t('labels', 'Document No.'),
            'account_id' => Yii::t('labels', 'Account'),
            'oppt_account_id' => Yii::t('labels', 'Opposite account'),
            'company' => Yii::t('labels', 'Company'),
            'address' => Yii::t('labels', 'Address'),
            'city' => Yii::t('labels', 'City'),
            'zip' => Yii::t('labels', 'Zip'),
            'vatnum' => Yii::t('labels', 'VAT No.'),
            'refnum' => Yii::t('labels', 'Reference No.'),
            'refnum_ext' => Yii::t('labels', 'External Reference'),
            'issue_date' => Yii::t('labels', 'Issue Date'),
            'due_date' => Yii::t('labels', 'Due Date'),
            'ref_date' => Yii::t('labels', 'Reference Date'),
            'reg_date' => Yii::t('labels', 'Create Date'),
            'sub_total' => Yii::t('labels', 'Sub Total'),
            'novat_total' => Yii::t('labels', 'No VAT Total'),
            'vat' => Yii::t('labels', 'VAT'),
            'total' => Yii::t('labels', 'Subtotal to pay'),
            'currency_id' => Yii::t('labels', 'Currency'),
            'src_tax' => Yii::t('labels', 'Src Tax'),
            'status' => Yii::t('labels', 'Status'),
            'printed' => Yii::t('labels', 'Printed'),
            'description' => Yii::t('labels', 'Comments for document'),
            'comments' => Yii::t('labels', 'Hidden internal comments'),
            'owner' => Yii::t('labels', 'Owner'),
            'discount' => Yii::t('labels', 'Discount'),
            'refstatus' => Yii::t('labels', 'Reference Status'),
            'stockSwitch' => Yii::t('labels', 'Stock Switch'),
        );
    }

    public function printedDoc() {

        if ($this->action == 1)
            $this->printed = (int) $this->printed + 1;
        $this->save(false, false);
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id, true);
        //$criteria->compare('prefix',$this->prefix,true);
        $criteria->compare('doctype', $this->doctype);
        $criteria->compare('docnum', $this->docnum, true);
        $criteria->compare('account_id', $this->account_id, true);
        $criteria->compare('company', $this->company, true);
        $criteria->compare('address', $this->address, true);
        $criteria->compare('city', $this->city, true);
        $criteria->compare('zip', $this->zip, true);
        $criteria->compare('vatnum', $this->vatnum, true);
        $criteria->compare('refnum', $this->refnum, true);
        $criteria->compare('issue_date', $this->issue_date, true);
        $criteria->compare('due_date', $this->due_date, true);
        $criteria->compare('sub_total', $this->sub_total, true);
        $criteria->compare('novat_total', $this->novat_total, true);
        $criteria->compare('vat', $this->vat, true);
        $criteria->compare('total', $this->total, true);
        $criteria->compare('src_tax', $this->src_tax, true);
        $criteria->compare('status', $this->status);
        $criteria->compare('printed', $this->printed);
        $criteria->compare('currency_id', $this->currency_id);
        $criteria->compare('comments', $this->comments, true);
        $criteria->compare('owner', $this->owner);
        $criteria->compare('refstatus', $this->refstatus, true);

        if (!empty($this->issue_from) && empty($this->issue_to)) {
            $this->issue_from = date("Y-m-d", CDateTimeParser::parse($this->issue_from, Yii::app()->locale->getDateFormat('yiishort')));

            $criteria->addCondition("issue_date>=:date_from");
            $criteria->params[':date_from'] = $this->issue_from;
        } elseif (!empty($this->issue_to) && empty($this->issue_from)) {
            $this->issue_to = date("Y-m-d", CDateTimeParser::parse($this->issue_to, Yii::app()->locale->getDateFormat('yiishort')));

            $criteria->addCondition("issue_date>=:date_to");
            $criteria->params[':date_to'] = $this->issue_to;
        } elseif (!empty($this->issue_to) && !empty($this->issue_from)) {
            $this->issue_from = date("Y-m-d", CDateTimeParser::parse($this->issue_from, Yii::app()->locale->getDateFormat('yiishort')));
            $this->issue_to = date("Y-m-d", CDateTimeParser::parse($this->issue_to, Yii::app()->locale->getDateFormat('yiishort')));

            $criteria->addCondition("issue_date>=:date_from");
            $criteria->addCondition("issue_date<=:date_to");
            $criteria->params[':date_from'] = $this->issue_from;
            $criteria->params[':date_to'] = $this->issue_to;
        }

        $sort = new CSort();
        $sort->defaultOrder = 'issue_date DESC';

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => $sort,
        ));
    }

    public function printDoc() {
        return PrintDoc::printMe($this);
    }

    public function getPdf() {


        return PrintDoc::getPdf($this);
    }

    public function pdf() {


        return PrintDoc::pdfDoc($this);
    }

}
