<?php

/**
 * This is the model class for table "acl_module".
 *
 * The followings are the available columns in table 'acl_module':
 * @property integer $acl_module_id
 * @property string $acl_module_name
 * @property string $acl_module_desc
 * @property integer $acl_module_status
 */
class AclModule extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return AclModule the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'acl_module';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('acl_module_name, acl_module_desc', 'required'),
            array('acl_module_status', 'numerical', 'integerOnly' => true),
            array('acl_module_name, acl_module_desc', 'length', 'max' => 100),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('acl_module_id, acl_module_name, acl_module_desc, acl_module_status', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'acl_module_id' => 'Acl Module',
            'acl_module_name' => 'Acl Module Name',
            'acl_module_desc' => 'Acl Module Desc',
            'acl_module_status' => 'Acl Module Status',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('acl_module_id', $this->acl_module_id);
        $criteria->compare('acl_module_name', $this->acl_module_name, true);
        $criteria->compare('acl_module_desc', $this->acl_module_desc, true);
        $criteria->compare('acl_module_status', $this->acl_module_status);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
    
    public function options(){
        $options = CHtml::listData(AclModule::model()->findAll(), 'acl_module_id', 'acl_module_name');
        $options[null] = '- Choose Module -';
        ksort($options);
        return $options;
    }

}
