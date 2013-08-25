<?php

/**
 * This is the model class for table "cheques".
 *
 * The followings are the available columns in table 'cheques':
 * @property string $prefix
 * @property string $refnum
 * @property integer $type
 * @property integer $creditcompany
 * @property string $cheque_num
 * @property string $bank
 * @property string $branch
 * @property string $cheque_acct
 * @property string $cheque_date
 * @property string $sum
 * @property string $bank_refnum
 * @property string $dep_date
 * @property integer $id
 */
class Doccheques extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Cheques the static model class
	 */
    
         public function primaryKey(){
	    return array('doc_id','line');
	}
    
    
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'docCheques';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('type, creditcompany, line', 'numerical', 'integerOnly'=>true),
			array('doc_id, cheque_num, bank_refnum', 'length', 'max'=>10),
			array('bank, branch', 'length', 'max'=>3),
			array('cheque_acct', 'length', 'max'=>20),
			array('sum', 'length', 'max'=>8),
			array('cheque_date, dep_date', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('doc_id, type, creditcompany, cheque_num, bank, branch, cheque_acct, cheque_date, sum, bank_refnum, dep_date, line', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
                    'Docs'=>array(self::BELONGS_TO, 'Docs', 'doc_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'doc_id' => Yii::t('label','Refnum'),
			'type' => Yii::t('label','Type'),
			'creditcompany' => Yii::t('label','Creditcompany'),
			'cheque_num' => Yii::t('label','Cheque No.'),
			'bank' => Yii::t('label','Bank'),
			'branch' => Yii::t('label','Branch'),
			'cheque_acct' => Yii::t('label','Cheque Account'),
			'cheque_date' => Yii::t('label','Cheque Date'),
			'sum' => Yii::t('label','Sum'),
			'bank_refnum' => Yii::t('label','Bank Refnum'),
			'dep_date' => Yii::t('label','Dep Date'),
			'line' => Yii::t('label','Line'),
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('doc_id',$this->refnum,true);
		$criteria->compare('type',$this->type);
		$criteria->compare('creditcompany',$this->creditcompany);
		$criteria->compare('cheque_num',$this->cheque_num,true);
		$criteria->compare('bank',$this->bank,true);
		$criteria->compare('branch',$this->branch,true);
		$criteria->compare('cheque_acct',$this->cheque_acct,true);
		$criteria->compare('cheque_date',$this->cheque_date,true);
		$criteria->compare('sum',$this->sum,true);
		$criteria->compare('bank_refnum',$this->bank_refnum,true);
		$criteria->compare('dep_date',$this->dep_date,true);
		$criteria->compare('line',$this->line);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}