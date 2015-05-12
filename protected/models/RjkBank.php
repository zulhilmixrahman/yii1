<?php

/**
 * This is the model class for table "rjk_bank".
 *
 * The followings are the available columns in table 'rjk_bank':
 * @property integer $id_bank
 * @property string $kod_bank
 * @property string $nama_bank
 * @property integer $bil_digit_akaun
 * @property integer $status_aktif
 * @property string $input_oleh
 * @property string $tkh_input
 * @property string $upd_oleh
 * @property string $tkh_upd
 */
class RjkBank extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'rjk_bank';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            //array('kod_bank, nama_bank, bil_digit_akaun, input_oleh, tkh_input', 'required'),
			array('kod_bank, nama_bank, bil_digit_akaun', 'required'),
            array('bil_digit_akaun, status_aktif', 'numerical', 'integerOnly' => true),
            array('kod_bank, input_oleh, upd_oleh', 'length', 'max' => 20),
            array('nama_bank', 'length', 'max' => 200),
            array('tkh_upd', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id_bank, kod_bank, nama_bank, bil_digit_akaun, status_aktif, input_oleh, tkh_input, upd_oleh, tkh_upd', 'safe', 'on' => 'search'),
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
            'id_bank' => 'Id Bank',
            'kod_bank' => 'Kod Bank',
            'nama_bank' => 'Nama Bank',
            'bil_digit_akaun' => 'Bil No Digit Akaun',
            'status_aktif' => 'Status Aktif',
            'input_oleh' => 'Input Oleh',
            'tkh_input' => 'Tkh Input',
            'upd_oleh' => 'Upd Oleh',
            'tkh_upd' => 'Tkh Upd',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id_bank', $this->id_bank);
        $criteria->compare('kod_bank', $this->kod_bank, true);
        $criteria->compare('nama_bank', $this->nama_bank, true);
        $criteria->compare('bil_digit_akaun', $this->bil_digit_akaun);
        $criteria->compare('status_aktif', $this->status_aktif);
        $criteria->compare('input_oleh', $this->input_oleh, true);
        $criteria->compare('tkh_input', $this->tkh_input, true);
        $criteria->compare('upd_oleh', $this->upd_oleh, true);
        $criteria->compare('tkh_upd', $this->tkh_upd, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return RjkBank the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
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

    public function getName($pk, $item = 'nama_bank') {
        if ($pk != 0) {
            $model = $this->findByPk($pk);
            return $model->$item;
        } else
            return null;
    }

    public function optionsBank() {
        $options = CHtml::listData($this->model()->findAll("status_aktif = 1"), 'id_bank', 'BankFullName');
        $options[null] = '- Sila Pilih Bank -';
        ksort($options);
        return $options;
    }
    
    public function getBankFullName(){
        return $this->kod_bank . ' - ' . $this->nama_bank;
    }

}
