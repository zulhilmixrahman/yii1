<?php

/**
 * This is the model class for table "rjk_parlimen".
 *
 * The followings are the available columns in table 'rjk_parlimen':
 * @property string $kod_parlimen
 * @property string $parlimen
 * @property string $kod_negeri
 * @property string $input_oleh
 * @property string $tkh_input
 * @property string $upd_oleh
 * @property string $tkh_upd
 */
class RjkParlimen extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return RjkParlimen the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'rjk_parlimen';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('kod_parlimen, parlimen, kod_negeri', 'required'),
            array('kod_parlimen', 'length', 'max' => 4),
            array('parlimen', 'length', 'max' => 50),
            array('kod_negeri', 'length', 'max' => 2),
            array('input_oleh, upd_oleh', 'length', 'max' => 20),
            array('tkh_input, tkh_upd', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('kod_parlimen, parlimen, kod_negeri, input_oleh, tkh_input, upd_oleh, tkh_upd', 'safe', 'on' => 'search'),
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
            'kod_parlimen' => 'Kod Parlimen',
            'parlimen' => 'Parlimen',
            'kod_negeri' => 'Negeri',
            'input_oleh' => 'Input Oleh',
            'tkh_input' => 'Tkh Input',
            'upd_oleh' => 'Upd Oleh',
            'tkh_upd' => 'Tkh Upd',
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

        $criteria->compare('kod_parlimen', $this->kod_parlimen, true);
        $criteria->compare('parlimen', $this->parlimen, true);
        $criteria->compare('kod_negeri', $this->kod_negeri, true);
        $criteria->compare('input_oleh', $this->input_oleh, true);
        $criteria->compare('tkh_input', $this->tkh_input, true);
        $criteria->compare('upd_oleh', $this->upd_oleh, true);
        $criteria->compare('tkh_upd', $this->tkh_upd, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    protected function beforeSave() {
        if ($this->isNewRecord) {
            $this->input_oleh = isset(Yii::app()->user->akaunIdPengguna) ? Yii::app()->user->akaunIdPengguna : 'anonymous';
            $this->tkh_input = new CDbExpression('NOW()');
        } else {
            $this->upd_oleh = isset(Yii::app()->user->akaunIdPengguna) ? Yii::app()->user->akaunIdPengguna : 'anonymous';
            $this->tkh_upd = new CDbExpression('NOW()');
        }
        return true;
    }
    
    public function optionsByNegeri($negeri = 0, $item = 'parlimen') {
        $kod = RjkKod::model()->find('jenis_kod = :jenis AND id_kod = :id', array(':jenis' => 'Negeri', ':id' => $negeri));
        $options = CHtml::listData($this->model()->findAll('kod_negeri = :kod', array(':kod' => $kod->kod)), 'kod_parlimen', $item);
        $options[null] = '- Sila Pilih Parlimen -';
        asort($options);
        return $options;
    }

}
