<?php

class LupaKatalaluan extends CActiveRecord {

    public $id_pengguna, $alamat_emel;

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'pengguna';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('id_pengguna, alamat_emel', 'required'),
            array('alamat_emel', 'email'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id_pengguna' => 'ID Pengguna',
            'alamat_emel' => 'Alamat Emel',
        );
    }

}
