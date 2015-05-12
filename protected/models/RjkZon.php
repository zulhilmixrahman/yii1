<?php

/**
 * This is the model class for table "rjk_zon".
 *
 * The followings are the available columns in table 'rjk_zon':
 * @property integer $id_zon
 * @property string $kod_negeri
 * @property string $kod_pbt
 * @property string $nama_zon
 * @property string $status_aktif
 * @property string $input_oleh
 * @property string $tkh_input
 * @property string $upd_oleh
 * @property string $tkh_upd
 */
class RjkZon extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return RjkZon the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'rjk_zon';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('kod_negeri, kod_pbt, nama_zon, status_aktif', 'required'),
            array('susunan_zon', 'numerical', 'integerOnly' => true),
            array('kod_negeri', 'length', 'max' => 2),
            array('kod_pbt', 'length', 'max' => 4),
            array('nama_zon, tkh_upd', 'length', 'max' => 50),
            array('status_aktif', 'length', 'max' => 1),
            array('input_oleh, upd_oleh', 'length', 'max' => 20),
            array('susunan_zon', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id_zon, kod_negeri, kod_pbt, nama_zon, status_aktif, input_oleh, tkh_input, upd_oleh, tkh_upd', 'safe', 'on' => 'search'),
            array('kod_bank, no_akaun_bank', 'safe')
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
            'bank' => array(self::BELONGS_TO, 'RjkBank', 'kod_bank'),
//            'bank' => array(self::BELONGS_TO, 'RjkKod', 'kod_bank',
//                'on' => 'bank.jenis_kod = :jenis',
//                'params' => array(':jenis' => 'Bank')
//            ),
            'pbt' => array(self::BELONGS_TO, 'RjkPbt', 'kod_pbt')
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id_zon' => 'Id Zon',
            'kod_negeri' => 'Negeri',
            'kod_pbt' => 'PBT',
            'nama_zon' => 'Nama Zon',
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

        $criteria->compare('id_zon', $this->id_zon);
        $criteria->compare('kod_negeri', $this->kod_negeri, true);
        $criteria->compare('kod_pbt', $this->kod_pbt, true);
        $criteria->compare('nama_zon', $this->nama_zon, true);
        $criteria->compare('status_aktif', $this->status_aktif, true);
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

    public function getName($pk, $item = 'nama_zon') {
        $model = $this->findByPk($pk);
        return $model->$item;
    }

    public function gridOptions($id = 0) {
        $options = CHtml::listData($this->model()->findAll(), 'id_zon', 'nama_zon');
        return $options;
    }

    public function options($id = 0) {
        $options = CHtml::listData($this->model()->findAll(), 'id_zon', 'nama_zon');
        $options[null] = '- Sila Pilih Zon -';
        asort($options);
        return $options;
    }

    public function getLatestSususanZon($pbt) {
        $data = $this->model()->find(array(
            'select' => 'MAX(susunan_zon) AS susunan_zon',
            'condition' => 'kod_pbt = :kodPbt',
            'params' => array(
                ':kodPbt' => $pbt
            )
        ));
        return $data->susunan_zon;
    }
    
    public function getTotalZonByNegeri($kodNegeri){
        $data = $this->model()->find(array(
            'select' => 'COUNT(id_zon) AS id_zon',
            'condition' => 'kod_negeri = :kodNegeri AND status_aktif = 1',
            'params' => array(':kodNegeri' => $kodNegeri)
        ));
        return $data->id_zon;
    }

    public function getTotalZonByPBT($kodPBT){
        $data = $this->model()->find(array(
            'select' => 'COUNT(id_zon) AS id_zon',
            'condition' => 'kod_pbt = :kodPbt AND status_aktif = 1',
            'params' => array(':kodPbt' => $kodPBT)
        ));
        return $data->id_zon;
    }
    
    public function semakMaklumatBankZon($idZon) {
        $data = $this->model()->findByPk($idZon);
        return ($data->kod_bank != 0 && $data->no_akaun_bank != '') ? true : false;
    }
    
}
