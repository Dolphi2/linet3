<?php

/**
 * This is the model class for table "docDetails".
 *
 * The followings are the available columns in table 'docDetails':
 * @property string $doc_id
 * @property string $item_id
 * @property string $name
 * @property string $description
 * @property string $qty
 * @property string $unit_price
 * @property string $currency_id
 * @property string $price
 * @property string $invprice
 * @property integer $line
 */
class Docdetails extends CActiveRecord
{
    
        public function transaction($num,$refnum,$valuedate,$details,$action,$line,$optacc){
            if(is_null($optacc)){
                $vatcat=  Item::model()->findByPk($docdetail->item_id)->itemVatCat_id;
                $incomeacc= UserIncomeMap::model()->findByPk(array('user_id'=>Yii::app()->user->id,'itemVatCat_id'=>$vatcat))->account_id;
            }else {
                $incomeacc=$optacc;
            }
            $income=new Transactions();
            $income->num=$num;
            $income->account_id=$incomeacc;
            $income->refnum1=$refnum;
            $income->valuedate=$valuedate;

            $income->details=$details;
            $income->currency_id=$this->currency_id;
            $income->sum=$this->price*$action;
            $income->owner_id=Yii::app()->user->id;
            $income->linenum=$line;
            return $income->save();
        
        }
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Docdetails the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

        
        public function primaryKey(){
	    return array('doc_id','line');
	}
        
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'docDetails';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, line', 'required'),
			array('line', 'numerical', 'integerOnly'=>true),
			array('doc_id, item_id, currency_id', 'length', 'max'=>10),
			array('name', 'length', 'max'=>255),
			array('qty', 'length', 'max'=>5),
			array('vat, unit_price, price, invprice', 'length', 'max'=>20),
			array('description', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('doc_id, item_id, name, description, qty, unit_price, currency_id, vat, price, invprice, line', 'safe', 'on'=>'search'),
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
                    'Doc'=>array(self::BELONGS_TO, 'Docs', 'doc_id'),
                    'ItemUnit'=>array(self::BELONGS_TO, 'Itemunit', 'unit_id'),
                    'Item'=>array(self::BELONGS_TO, 'Item', 'item_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'doc_id' => Yii::t('labels','Doc'),
			'item_id' => Yii::t('labels','Item'),
			'name' => Yii::t('labels','Name'),
			'description' => Yii::t('labels','Description'),
			'qty' => Yii::t('labels','Qty'),
			'unit_price' => Yii::t('labels','Unit Price'),
			'currency_id' => Yii::t('labels','Currency'),
			'price' => Yii::t('labels','Price'),
			'invprice' => Yii::t('labels','invoice Price'),
			'line' => Yii::t('labels','Line'),
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

		$criteria->compare('doc_id',$this->doc_id,true);
		$criteria->compare('item_id',$this->item_id,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('qty',$this->qty,true);
		$criteria->compare('unit_price',$this->unit_price,true);
		$criteria->compare('currency_id',$this->currency_id,true);
		$criteria->compare('price',$this->price,true);
		$criteria->compare('invprice',$this->invprice,true);
		$criteria->compare('line',$this->line);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}