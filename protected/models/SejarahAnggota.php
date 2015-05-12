<?php

/**
 * This is the model class for table "sej_anggota".
 *
 * The followings are the available columns in table 'sej_anggota':
 * @property integer $id_anggota
 * @property string $no_kp
 * @property string $nama
 * @property integer $id_zon
 * @property string $kod_jawatan_jpp
 * @property string $kod_biro_jpp
 * @property string $tkh_lantik_mula
 * @property string $tkh_lantik_akhir
 * @property string $kod_gelaran
 * @property string $alamat
 * @property integer $poskod
 * @property string $kod_negeri_alamat
 * @property string $jantina
 * @property string $kod_kaum
 * @property string $kod_agama
 * @property string $kod_akademik
 * @property string $pekerjaan
 * @property string $kod_sebab_tamat
 * @property integer $status_aktif
 * @property string $input_oleh
 * @property string $tkh_input
 * @property string $upd_oleh
 * @property string $tkh_upd
 */
class SejarahAnggota extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return SejarahAnggota the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'sej_anggota';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('no_kp, nama, id_zon, id_penggal, kod_jawatan_jpp, kod_biro_jpp, '
                . 'tkh_lantik_mula, tkh_lantik_akhir, kod_gelaran, alamat, poskod, kod_negeri_alamat, '
                . 'jantina, umur, kod_kaum, kod_agama, kod_akademik, pekerjaan, kod_bank, no_akaun_bank', 'required'),
            array('id_zon, id_penggal, poskod, status_aktif, kod_sebab_tamat, '
                . 'kod_bank, no_rujukan_surat', 'numerical', 'integerOnly' => true),
            array('no_kp', 'length', 'max' => 12),
            array('kod_parlimen', 'length', 'max' => 4),
            array('kod_dun', 'length', 'max' => 5),
            array('nama, pekerjaan', 'length', 'max' => 50),
            array('catatan_sebab_tamat', 'length', 'max' => 255),
            array('kod_jawatan_jpp, kod_biro_jpp, kod_negeri_alamat, jantina, kod_akademik', 'length', 'max' => 10),
            array('kod_gelaran, kod_kaum, kod_agama, input_oleh, upd_oleh', 'length', 'max' => 20),
            array('no_akaun_bank', 'length', 'max' => 50),
            array('alamat', 'length', 'max' => 100),
            array('tkh_surat_lantik', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id_anggota, no_kp, nama, id_zon, kod_jawatan_jpp, kod_biro_jpp, tkh_lantik_mula, '
                . 'tkh_lantik_akhir, kod_gelaran, alamat, poskod, kod_negeri_alamat, jantina, umur, '
                . 'kod_kaum, kod_agama, kod_akademik, pekerjaan, status_aktif, input_oleh, tkh_input, '
                . 'upd_oleh, tkh_upd, kod_sebab_tamat, catatan_sebab_tamat', 'safe', 'on' => 'search'),
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
            'id_anggota' => 'ID Anggota',
            'no_kp' => 'No Kad Pengenalan',
            'nama' => 'Nama Penuh',
            'id_zon' => 'Zon',
            'kod_jawatan_jpp' => 'Jawatan JPP',
            'kod_biro_jpp' => 'Biro JPP',
            'tkh_lantik_mula' => 'Tarikh Lantik',
            'tkh_lantik_akhir' => 'Tarikh Tamat Lantik',
            'kod_gelaran' => 'Gelaran',
            'alamat' => 'Alamat',
            'poskod' => 'Poskod',
            'kod_negeri_alamat' => 'Negeri',
            'jantina' => 'Jantina',
            'umur' => 'Umur',
            'kod_kaum' => 'Kaum',
            'kod_agama' => 'Agama',
            'kod_akademik' => 'Akademik',
            'pekerjaan' => 'Pekerjaan',
            'status_aktif' => 'Status',
            'input_oleh' => 'Input Oleh',
            'tkh_input' => 'Tkh Input',
            'upd_oleh' => 'Upd Oleh',
            'tkh_upd' => 'Tkh Upd',
            'kod_sebab_tamat' => 'Sebab Tamat'
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

        $criteria->compare('id_anggota', $this->id_anggota);
        $criteria->compare('no_kp', $this->no_kp, true);
        $criteria->compare('nama', $this->nama, true);
        $criteria->compare('id_zon', $this->id_zon);
        $criteria->compare('kod_jawatan_jpp', $this->kod_jawatan_jpp, true);
        $criteria->compare('kod_biro_jpp', $this->kod_biro_jpp, true);
        $criteria->compare('tkh_lantik_mula', $this->tkh_lantik_mula, true);
        $criteria->compare('tkh_lantik_akhir', $this->tkh_lantik_akhir, true);
        $criteria->compare('kod_gelaran', $this->kod_gelaran, true);
        $criteria->compare('alamat', $this->alamat, true);
        $criteria->compare('poskod', $this->poskod);
        $criteria->compare('kod_negeri_alamat', $this->kod_negeri_alamat, true);
        $criteria->compare('jantina', $this->jantina, true);
        $criteria->compare('umur', $this->umur, true);
        $criteria->compare('kod_kaum', $this->kod_kaum, true);
        $criteria->compare('kod_agama', $this->kod_agama, true);
        $criteria->compare('kod_akademik', $this->kod_akademik, true);
        $criteria->compare('pekerjaan', $this->pekerjaan, true);
        $criteria->compare('status_aktif', $this->status_aktif);
        $criteria->compare('kod_sebab_tamat', $this->kod_sebab_tamat, true);
        $criteria->compare('input_oleh', $this->input_oleh, true);
        $criteria->compare('tkh_input', $this->tkh_input, true);
        $criteria->compare('upd_oleh', $this->upd_oleh, true);
        $criteria->compare('tkh_upd', $this->tkh_upd, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}
