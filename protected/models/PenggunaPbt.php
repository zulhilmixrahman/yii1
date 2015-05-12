<?php

/**
 * This is the model class for table "pengguna_pbt".
 *
 * The followings are the available columns in table 'pengguna_pbt':
 * @property integer $id_pengguna
 * @property string $kod_pbt
 */
class PenggunaPbt extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return PenggunaPbt the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'pengguna_pbt';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('id_pengguna, kod_pbt', 'required'),
            array('id_pengguna', 'numerical', 'integerOnly' => true),
            array('kod_pbt', 'length', 'max' => 4),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id_pengguna, kod_pbt', 'safe', 'on' => 'search'),
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
            'id_pengguna' => 'Id Pengguna',
            'kod_pbt' => 'Kod Pbt',
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

        $criteria->compare('id_pengguna', $this->id_pengguna);
        $criteria->compare('kod_pbt', $this->id_pbt, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}
