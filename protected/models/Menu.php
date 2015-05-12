<?php

/**
 * This is the model class for table "menu".
 *
 * The followings are the available columns in table 'menu':
 * @property integer $id_menu
 * @property string $glyphicon
 * @property string $label
 * @property string $module
 * @property string $controller
 * @property string $action
 * @property string $type
 * @property string $level
 * @property integer $parent
 */
class Menu extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Menu the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'menu';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('label', 'required'),
            array('parent, sort', 'numerical', 'integerOnly' => true),
            array('glyphicon, module, controller, action', 'length', 'max' => 100),
            array('label', 'length', 'max' => 200),
            array('type, level', 'length', 'max' => 10),
            array('sort', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id_menu, glyphicon, label, module, controller, action, type, level, parent', 'safe', 'on' => 'search'),
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
            'id_menu' => 'Id Menu',
            'glyphicon' => 'Glyphicon',
            'label' => 'Label',
            'module' => 'Module',
            'controller' => 'Controller',
            'action' => 'Action',
            'type' => 'Type',
            'level' => 'Level',
            'parent' => 'Parent',
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

        $criteria->compare('id_menu', $this->id_menu);
        $criteria->compare('glyphicon', $this->glyphicon, true);
        $criteria->compare('label', $this->label, true);
        $criteria->compare('module', $this->module, true);
        $criteria->compare('controller', $this->controller, true);
        $criteria->compare('action', $this->action, true);
        $criteria->compare('type', $this->type, true);
        $criteria->compare('level', $this->level, true);
        $criteria->compare('parent', $this->parent);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}
