<?php

/**
 * This is the model class for table "templat_emel".
 *
 * The followings are the available columns in table 'templat_emel':
 * @property integer $id_emel
 * @property string $jenis_emel
 * @property string $tajuk_emel
 * @property string $isi_emel
 */
class TemplateEmel extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return TemplateEmel the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'templat_emel';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('jenis_emel, tajuk_emel, isi_emel', 'required'),
            array('jenis_emel, tajuk_emel', 'length', 'max' => 200),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id_emel, jenis_emel, tajuk_emel, isi_emel', 'safe', 'on' => 'search'),
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
            'id_emel' => 'Id Emel',
            'jenis_emel' => 'Jenis Emel',
            'tajuk_emel' => 'Tajuk Emel',
            'isi_emel' => 'Isi Emel',
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

        $criteria->compare('id_emel', $this->id_emel);
        $criteria->compare('jenis_emel', $this->jenis_emel, true);
        $criteria->compare('tajuk_emel', $this->tajuk_emel, true);
        $criteria->compare('isi_emel', $this->isi_emel, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}
