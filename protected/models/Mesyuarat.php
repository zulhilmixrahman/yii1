<?php

/**
 * This is the model class for table "daf_mesy".
 *
 * The followings are the available columns in table 'daf_mesy':
 * @property integer $id_mesy
 * @property integer $kod_negeri
 * @property string $kod_pbt
 * @property integer $id_zon
 * @property string $tkh_mesy
 * @property string $tajuk_mesy
 * @property string $catatan
 * @property string $minit_mesy
 * @property integer $status_aktif
 * @property string $input_oleh
 * @property string $tkh_input
 * @property string $upd_oleh
 * @property string $tkh_upd
 */
class Mesyuarat extends CActiveRecord {

    public $penggal;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return DaftarMesyuarat the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'daf_mesy';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('kod_negeri, kod_pbt, id_zon, id_penggal, tkh_mesy, tajuk_mesy', 'required'),
            array('kod_negeri, id_zon, id_penggal, status_aktif', 'numerical', 'integerOnly' => true),
            array('kod_pbt', 'length', 'max' => 4),
            array('tajuk_mesy', 'length', 'max' => 100),
            array('input_oleh, upd_oleh', 'length', 'max' => 20),
            array('penggal, minit_mesy, catatan, tkh_upd', 'safe'),
            /** maxSize = 1 byte * 1 megabyte * size_to_limit */
            array('minit_mesy', 'file', 'types' => 'doc, docx, odt, pdf', 'maxSize' => 1024 * 1024 * 2,
                'tooLarge' => 'Melebihi maximum 200Mb', 'allowEmpty' => true),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id_mesy, kod_negeri, kod_pbt, id_zon, tkh_mesy, tajuk_mesy, catatan, '
                . 'status_aktif, input_oleh, tkh_input, upd_oleh, tkh_upd', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'negeri' => array(self::BELONGS_TO, 'RjkKod', 'kod_negeri',
                'on' => 'negeri.jenis_kod = :jenis',
                'params' => array(':jenis' => 'Negeri')
            ),
            'pbt' => array(self::BELONGS_TO, 'RjkPbt', 'kod_pbt'),
            'zon' => array(self::BELONGS_TO, 'RjkZon', 'id_zon'),
            'penggal' => array(self::BELONGS_TO, 'Penggal', 'id_penggal'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id_mesy' => 'Id Mesyuarat',
            'kod_negeri' => 'Negeri',
            'kod_pbt' => 'PBT',
            'id_zon' => 'Zon',
            'id_penggal' => 'Penggal',
            'tkh_mesy' => 'Tarikh Mesyuarat',
            'tajuk_mesy' => 'Tajuk Mesyuarat',
            'catatan' => 'Catatan',
            'minit_mesy' => 'Minit Mesyuarat',
            'status_aktif' => 'Status',
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

        $criteria->compare('id_mesy', $this->id_mesy);
        $criteria->compare('kod_negeri', $this->kod_negeri);
        $criteria->compare('kod_pbt', $this->kod_pbt, true);
        $criteria->compare('id_zon', $this->id_zon);
        $criteria->compare('tkh_mesy', $this->tkh_mesy, true);
        $criteria->compare('tajuk_mesy', $this->tajuk_mesy, true);
        $criteria->compare('catatan', $this->catatan, true);
        $criteria->compare('minit_mesy', $this->minit_mesy, true);
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

    public function getItem($pk, $item = 'tajuk_mesy') {
        $model = $this->findByPk($pk);
        return $model->$item;
    }

}
