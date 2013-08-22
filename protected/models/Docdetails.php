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
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Docdetails the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

        
        public function primaryKey()
	{
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
			array('unit_price, price, invprice', 'length', 'max'=>20),
			array('description', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('doc_id, item_id, name, description, qty, unit_price, currency_id, price, invprice, line', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'doc_id' => 'Doc',
			'item_id' => 'Item',
			'name' => 'Name',
			'description' => 'Description',
			'qty' => 'Qty',
			'unit_price' => 'Unit Price',
			'currency_id' => 'Currency',
			'price' => 'Price',
			'invprice' => 'invoice Price',
			'line' => 'Line',
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