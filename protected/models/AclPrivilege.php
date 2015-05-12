<?php

/**
 * This is the model class for table "acl_privilege".
 *
 * The followings are the available columns in table 'acl_privilege':
 * @property integer $acl_privilege_id
 * @property integer $acl_module_id
 * @property integer $acl_resource_id
 * @property string $acl_privilege_name
 * @property string $acl_privilege_desc
 * @property integer $acl_privilege_status
 */
class AclPrivilege extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AclPrivilege the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'acl_privilege';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('acl_module_id, acl_resource_id, acl_privilege_name, acl_privilege_desc', 'required'),
			array('acl_module_id, acl_resource_id, acl_privilege_status', 'numerical', 'integerOnly'=>true),
			array('acl_privilege_name, acl_privilege_desc', 'length', 'max'=>100),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('acl_privilege_id, acl_module_id, acl_resource_id, acl_privilege_name, acl_privilege_desc, acl_privilege_status', 'safe', 'on'=>'search'),
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
			'acl_privilege_id' => 'Acl Privilege',
			'acl_module_id' => 'Acl Module',
			'acl_resource_id' => 'Acl Resource',
			'acl_privilege_name' => 'Acl Privilege Name',
			'acl_privilege_desc' => 'Acl Privilege Desc',
			'acl_privilege_status' => 'Acl Privilege Status',
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

		$criteria->compare('acl_privilege_id',$this->acl_privilege_id);
		$criteria->compare('acl_module_id',$this->acl_module_id);
		$criteria->compare('acl_resource_id',$this->acl_resource_id);
		$criteria->compare('acl_privilege_name',$this->acl_privilege_name,true);
		$criteria->compare('acl_privilege_desc',$this->acl_privilege_desc,true);
		$criteria->compare('acl_privilege_status',$this->acl_privilege_status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}