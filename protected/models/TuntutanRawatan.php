<?php

/**
 * This is the model class for table "tuntutan_rawatan".
 *
 * The followings are the available columns in table 'tuntutan_rawatan':
 * @property integer $id_rawatan
 * @property integer $kod_negeri
 * @property string $kod_pbt
 * @property integer $id_zon
 * @property integer $id_penggal
 * @property integer $id_anggota
 * @property integer $id_mesy
 * @property string $tkh_mohon
 * @property string $nama_hosp
 * @property string $jenis_rawatan
 * @property string $tujuan_tuntutan
 * @property string $amaun
 * @property string $tkh_bayaran
 * @property string $no_eft
 * @property integer $status_aktif
 * @property string $input_oleh
 * @property string $tkh_input
 * @property string $upd_oleh
 * @property string $tkh_upd
 * @property string $jenis_tuntutan
 */
class TuntutanRawatan extends CActiveRecord {

    public $penggal;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return TuntutanRawatan the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'tuntutan_rawatan';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('kod_negeri, kod_pbt, id_zon, id_penggal, id_anggota, tkh_mohon, nama_hosp, jenis_rawatan, tujuan_tuntutan, '
                . 'amaun, status_aktif, kod_bank, no_akaun_bank', 'required'),
            array('kod_negeri, id_zon, id_penggal, id_anggota, status_aktif, kod_bank', 'numerical', 'integerOnly' => true),
            array('kod_pbt', 'length', 'max' => 4),
            array('amaun', 'length', 'max' => 10),
            array('no_eft, input_oleh', 'length', 'max' => 20),
            array('jenis_tuntutan', 'length', 'max' => 10),
            array('no_akaun_bank', 'length', 'max' => 50),
            array('tkh_bayaran, no_eft, input_oleh, tkh_input, upd_oleh, tkh_upd, jenis_tuntutan', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id_rawatan, kod_negeri, kod_pbt, id_zon, id_penggal, id_anggota, id_mesy, tkh_mohon, nama_hosp, jenis_rawatan, tujuan_tuntutan, amaun, tkh_bayaran, no_eft, status_aktif, input_oleh, tkh_input, upd_oleh, tkh_upd, jenis_tuntutan', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'anggota' => array(self::BELONGS_TO, 'Anggota', 'id_anggota'),
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
            'id_rawatan' => 'Id Rawatan',
            'kod_negeri' => 'Negeri',
            'kod_pbt' => 'PBT',
            'id_zon' => 'Zon',
            'id_penggal' => 'Penggal',
            'id_anggota' => 'Anggota JPP',
            'id_mesy' => 'Mesyuarat',
            'tkh_mohon' => 'Tarikh Permohonan',
            'nama_hosp' => 'Nama Hospital',
            'jenis_rawatan' => 'Jenis Rawatan',
            'tujuan_tuntutan' => 'Tujuan Tuntutan',
            'amaun' => 'Amaun',
            'tkh_bayaran' => 'Tarikh Bayaran',
            'no_eft' => 'No EFT',
            'status_aktif' => 'Status Aktif',
            'input_oleh' => 'Input Oleh',
            'tkh_input' => 'Tkh Input',
            'upd_oleh' => 'Upd Oleh',
            'tkh_upd' => 'Tkh Upd',
            'jenis_tuntutan' => 'Jenis Tuntutan',
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

        $criteria->compare('id_rawatan', $this->id_rawatan);
        $criteria->compare('kod_negeri', $this->kod_negeri);
        $criteria->compare('kod_pbt', $this->kod_pbt, true);
        $criteria->compare('id_zon', $this->id_zon);
        $criteria->compare('id_penggal', $this->id_penggal);
        $criteria->compare('id_anggota', $this->id_anggota);
        $criteria->compare('id_mesy', $this->id_mesy);
        $criteria->compare('tkh_mohon', $this->tkh_mohon, true);
        $criteria->compare('nama_hosp', $this->nama_hosp, true);
        $criteria->compare('jenis_rawatan', $this->jenis_rawatan, true);
        $criteria->compare('tujuan_tuntutan', $this->tujuan_tuntutan, true);
        $criteria->compare('amaun', $this->amaun, true);
        $criteria->compare('tkh_bayaran', $this->tkh_bayaran, true);
        $criteria->compare('no_eft', $this->no_eft, true);
        $criteria->compare('status_aktif', $this->status_aktif);
        $criteria->compare('input_oleh', $this->input_oleh, true);
        $criteria->compare('tkh_input', $this->tkh_input, true);
        $criteria->compare('upd_oleh', $this->upd_oleh, true);
        $criteria->compare('tkh_upd', $this->tkh_upd, true);
        $criteria->compare('jenis_tuntutan', $this->jenis_tuntutan, true);

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
        if($this->jenis_tuntutan == '' || empty($this->jenis_tuntutan))
            $this->jenis_tuntutan = 'rawatan';
        return true;
    }

}
