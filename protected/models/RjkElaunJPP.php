<?php

/**
 * This is the model class for table "rjk_elaun_jpp".
 *
 * The followings are the available columns in table 'rjk_elaun_jpp':
 * @property integer $id_elaun
 * @property string $kod_jawatan_jpp
 * @property string $kod_kategori_pbt
 * @property string $kadar_elaun
 * @property integer $max_bil_bayaran
 * @property integer $status_aktif
 * @property string $input_oleh
 * @property string $tkh_input
 * @property string $upd_oleh
 * @property string $tkh_kemaskini
 */
class RjkElaunJPP extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return RjkElaunJPP the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'rjk_elaun_jpp';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('kod_jawatan_jpp, kod_kategori_pbt, kadar_elaun, max_bil_bayaran, jenis_elaun, status_aktif', 'required'),
            array('max_bil_bayaran, status_aktif', 'numerical', 'integerOnly' => true),
            array('kod_jawatan_jpp, kod_kategori_pbt', 'length', 'max' => 10),
            array('kadar_elaun', 'length', 'max' => 9),
            array('input_oleh, upd_oleh', 'length', 'max' => 20),
            array('jenis_elaun', 'length', 'max' => 100),
            array('input_oleh, tkh_input, upd_oleh, tkh_kemaskini', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id_elaun, kod_jawatan_jpp, kod_kategori_pbt, kadar_elaun, max_bil_bayaran, status_aktif, input_oleh, tkh_input, upd_oleh, tkh_kemaskini', 'safe', 'on' => 'search'),
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
            'id_elaun' => 'Id Elaun',
            'kod_jawatan_jpp' => 'Kod Jawatan Jpp',
            'kod_kategori_pbt' => 'Kod Kategori Pbt',
            'kadar_elaun' => 'Kadar Elaun',
            'max_bil_bayaran' => 'Max Bil Bayaran',
            'status_aktif' => 'Status Aktif',
            'input_oleh' => 'Input Oleh',
            'tkh_input' => 'Tkh Input',
            'upd_oleh' => 'Upd Oleh',
            'tkh_kemaskini' => 'Tkh Kemaskini',
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

        $criteria->compare('id_elaun', $this->id_elaun);
        $criteria->compare('kod_jawatan_jpp', $this->kod_jawatan_jpp, true);
        $criteria->compare('kod_kategori_pbt', $this->kod_kategori_pbt, true);
        $criteria->compare('kadar_elaun', $this->kadar_elaun, true);
        $criteria->compare('max_bil_bayaran', $this->max_bil_bayaran);
        $criteria->compare('status_aktif', $this->status_aktif);
        $criteria->compare('input_oleh', $this->input_oleh, true);
        $criteria->compare('tkh_input', $this->tkh_input, true);
        $criteria->compare('upd_oleh', $this->upd_oleh, true);
        $criteria->compare('tkh_kemaskini', $this->tkh_kemaskini, true);

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
            $this->tkh_kemaskini = new CDbExpression('NOW()');
        }
        return true;
    }

    public function getAmountByKategoriPBTandKategoriJawatan($kategoriPBT, $kategoriJawatan) {
        $model = $this->model()->find(
                'kod_kategori_pbt = :kategoriPBT AND kod_jawatan_jpp = :kategoriJawatan', array(
            ':kategoriPBT' => $kategoriPBT,
            ':kategoriJawatan' => $kategoriJawatan
        ));
        return $model->kadar_elaun;
    }

}
