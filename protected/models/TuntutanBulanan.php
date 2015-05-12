<?php

/**
 * This is the model class for table "tuntutan_bulanan".
 *
 * The followings are the available columns in table 'tuntutan_bulanan':
 * @property integer $id_bulanan
 * @property integer $kod_negeri
 * @property string $kod_pbt
 * @property integer $id_zon
 * @property integer $id_penggal
 * @property integer $id_anggota
 * @property string $tkh_mohon
 * @property string $amaun
 * @property string $tkh_bayaran
 * @property string $no_eft
 * @property integer $status_aktif
 * @property string $input_oleh
 * @property string $tkh_input
 * @property string $upd_oleh
 * @property string $tkh_upd
 */
class TuntutanBulanan extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return TuntutanBulanan the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'tuntutan_bulanan';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('kod_negeri, kod_pbt, id_zon, id_penggal, id_anggota, kod_jawatan_jpp, tkh_mohon, amaun, bayaran_bulan, '
                . 'bayaran_tahun, kod_bank, no_akaun_bank', 'required'),
            array('kod_negeri, id_zon, id_penggal, id_anggota, status_aktif, kod_bank', 'numerical', 'integerOnly' => true),
            array('bayaran_bulan, bayaran_tahun', 'length', 'max' => 5),
            array('kod_pbt', 'length', 'max' => 4),
            array('no_eft, input_oleh, upd_oleh', 'length', 'max' => 20),
            array('no_akaun_bank', 'length', 'max' => 50),
            array('tkh_input, tkh_bayaran, tkh_upd', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id_bulanan, kod_negeri, kod_pbt, id_zon, id_penggal, id_anggota, tkh_mohon, amaun, tkh_bayaran, no_eft, status_aktif, input_oleh, tkh_input, upd_oleh, tkh_upd', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'bank' => array(self::BELONGS_TO, 'RjkBank', 'kod_bank'),
//            'bank' => array(self::BELONGS_TO, 'RjkKod', 'kod_bank',
//                'on' => 'bank.jenis_kod = :jenis',
//                'params' => array(':jenis' => 'Bank')
//            ),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id_bulanan' => 'Id Bulanan',
            'kod_negeri' => 'Kod Negeri',
            'kod_pbt' => 'Kod Pbt',
            'id_zon' => 'Id Zon',
            'id_penggal' => 'Id Penggal',
            'id_anggota' => 'Id Anggota',
            'tkh_mohon' => 'Tkh Mohon',
            'amaun' => 'Amaun',
            'tkh_bayaran' => 'Tkh Bayaran',
            'no_eft' => 'No Eft',
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

        $criteria->compare('id_bulanan', $this->id_bulanan);
        $criteria->compare('kod_negeri', $this->kod_negeri);
        $criteria->compare('kod_pbt', $this->kod_pbt, true);
        $criteria->compare('id_zon', $this->id_zon);
        $criteria->compare('id_penggal', $this->id_penggal);
        $criteria->compare('id_anggota', $this->id_anggota);
        $criteria->compare('tkh_mohon', $this->tkh_mohon, true);
        $criteria->compare('amaun', $this->amaun, true);
        $criteria->compare('tkh_bayaran', $this->tkh_bayaran, true);
        $criteria->compare('no_eft', $this->no_eft, true);
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
