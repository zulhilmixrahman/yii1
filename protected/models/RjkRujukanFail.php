<?php

/**
 * This is the model class for table "rjk_rujukan_fail".
 *
 * The followings are the available columns in table 'rjk_rujukan_fail':
 * @property integer $id_rujukan_fail
 * @property integer $kod_negeri
 * @property string $kod_pbt
 * @property string $kod_rujukan
 * @property string $catatan
 * @property integer $bil_rujukan_terkini
 * @property integer $status_aktif
 * @property string $input_oleh
 * @property string $tkh_input
 * @property string $upd_oleh
 * @property string $tkh_upd
 */
class RjkRujukanFail extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return RjkRujukanFail the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'rjk_rujukan_fail';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('kod_negeri, kod_pbt, kod_rujukan', 'required'),
            array('kod_negeri, bil_rujukan_terkini, status_aktif', 'numerical', 'integerOnly' => true),
            array('kod_pbt', 'length', 'max' => 4),
            array('kod_rujukan', 'length', 'max' => 50),
            array('input_oleh, upd_oleh', 'length', 'max' => 20),
            array('catatan, tkh_input, tkh_upd', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id_rujukan_fail, kod_negeri, kod_pbt, kod_rujukan, catatan, bil_rujukan_terkini, status_aktif, input_oleh, tkh_input, upd_oleh, tkh_upd', 'safe', 'on' => 'search'),
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
            'id_rujukan_fail' => 'Id Rujukan Fail',
            'kod_negeri' => 'Kod Negeri',
            'kod_pbt' => 'Kod Pbt',
            'kod_rujukan' => 'Kod Rujukan',
            'catatan' => 'Catatan',
            'bil_rujukan_terkini' => 'Bil Rujukan Terkini',
            'status_aktif' => 'Status Aktif',
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

        $criteria->compare('id_rujukan_fail', $this->id_rujukan_fail);
        $criteria->compare('kod_negeri', $this->kod_negeri);
        $criteria->compare('kod_pbt', $this->kod_pbt, true);
        $criteria->compare('kod_rujukan', $this->kod_rujukan, true);
        $criteria->compare('catatan', $this->catatan, true);
        $criteria->compare('bil_rujukan_terkini', $this->bil_rujukan_terkini);
        $criteria->compare('status_aktif', $this->status_aktif);
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

}
