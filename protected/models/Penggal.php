<?php

/**
 * This is the model class for table "jad_penggal".
 *
 * The followings are the available columns in table 'jad_penggal':
 * @property integer $id_penggal
 * @property integer $id_zon
 * @property integer $tkh_penggal_mula
 * @property integer $tkh_penggal_akhir
 * @property integer $status_aktif
 * @property string $input_oleh
 * @property string $tkh_input
 * @property string $upd_oleh
 * @property string $tkh_upd
 */
class Penggal extends CActiveRecord {

    public $negeri, $pbt;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Penggal the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'jad_penggal';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('id_zon, tkh_penggal_mula, tkh_penggal_akhir', 'required'),
            array('id_zon, status_aktif', 'numerical', 'integerOnly' => true),
            array('input_oleh, upd_oleh', 'length', 'max' => 20),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id_penggal, id_zon, tkh_penggal_mula, tkh_penggal_akhir, status_aktif, input_oleh, tkh_input, upd_oleh, tkh_upd', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'zon' => array(self::BELONGS_TO, 'RjkZon', 'id_zon')
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id_penggal' => 'PK Penggal',
            'id_zon' => 'Zon',
            'tkh_penggal_mula' => 'Tarikh Mula Penggal',
            'tkh_penggal_akhir' => 'Tarikh Tamat Penggal',
            'status_aktif' => 'Status',
            'input_oleh' => 'Input Maklumat Baru Oleh',
            'tkh_input' => 'Tarikh Maklumat Baru',
            'upd_oleh' => 'Kemaskini Oleh',
            'tkh_upd' => 'Tarikh Kemaskini',
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

        $criteria->compare('id_penggal', $this->id_penggal);
        $criteria->compare('id_zon', $this->id_zon);
        $criteria->compare('tkh_penggal_mula', $this->tkh_penggal_mula);
        $criteria->compare('tkh_penggal_akhir', $this->tkh_penggal_akhir);
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
