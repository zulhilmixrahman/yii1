<?php

/**
 * This is the model class for table "audit_trail_user".
 *
 * The followings are the available columns in table 'audit_trail_user':
 * @property integer $audit_user_id
 * @property string $audit_user_username
 * @property string $audit_user_timestamp
 * @property string $audit_user_info
 */
class AuditTrailUser extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'audit_trail_user';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('audit_user_username, audit_user_ip, audit_user_agent, audit_user_timestamp, audit_user_info', 'required'),
            array('audit_user_username', 'length', 'max' => 50),
            array('audit_user_ip, audit_user_agent', 'length', 'max' => 100),
            array('audit_user_info', 'length', 'max' => 255),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('audit_user_id, audit_user_username, audit_user_ip, audit_user_agent, audit_user_timestamp, audit_user_info', 'safe', 'on' => 'search'),
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
            'audit_user_id' => 'Audit User',
            'audit_user_username' => 'Audit User Username',
            'audit_user_timestamp' => 'Audit User Timestamp',
            'audit_user_info' => 'Audit User Info',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('audit_user_id', $this->audit_user_id);
        $criteria->compare('audit_user_username', $this->audit_user_username, true);
        $criteria->compare('audit_user_ip', $this->audit_user_ip, true);
        $criteria->compare('audit_user_agent', $this->audit_user_agent, true);
        $criteria->compare('audit_user_timestamp', $this->audit_user_timestamp, true);
        $criteria->compare('audit_user_info', $this->audit_user_info, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return AuditTrailUser the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function inputAuditTrail($info = 'Tiada Maklumat') {
        $data = new AuditTrailUser();
        $data->audit_user_username = isset(Yii::app()->user->akaunIdPengguna) ? Yii::app()->user->akaunIdPengguna : 'guest';
        $data->audit_user_ip = Yii::app()->request->userHostAddress;
        $data->audit_user_agent = Yii::app()->request->userAgent;
        $data->audit_user_timestamp = new CDbExpression('NOW()');
        $data->audit_user_info = $info;
        $data->save(false);
    }

}
