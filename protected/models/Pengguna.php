<?php

/**
 * This is the model class for table "pengguna".
 *
 * The followings are the available columns in table 'pengguna':
 * @property string $id_pengguna
 * @property string $katalaluan
 * @property string $kat_pengguna
 * @property string $nama
 * @property string $id_pengenalan
 * @property string $emel
 * @property string $telefon
 * @property string $status_aktif
 * @property string $input_oleh
 * @property string $tkh_input
 * @property string $upd_oleh
 * @property string $tkh_upd
 */
class Pengguna extends CActiveRecord {

    public $authentication, $kemaskini_katalaluan, $katalaluan_lama, $ulang_katalaluan;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Pengguna the static model class
     */
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
            array('id_pengenalan, kat_pengguna, nama, emel, telefon', 'required'),
            array('kat_pengguna, status_aktif', 'numerical', 'integerOnly' => true),
            array('id_pengguna, input_oleh, upd_oleh', 'length', 'max' => 20),
            array('katalaluan, katarahsia', 'length', 'max' => 255),
            array('kat_pengguna', 'length', 'max' => 6),
            array('nama, emel, session_id', 'length', 'max' => 100),
            array('id_pengenalan', 'length', 'max' => 20),
            array('telefon', 'length', 'max' => 30),
            array('jawatan', 'length', 'max' => 50),
            array('katarahsia, jawatan, tkh_input, tkh_upd, last_login_time, session_id, v_code_email', 'safe'),
            array('katalaluan', 'required', 'on' => 'insert'),
            array('ulang_katalaluan', 'validateRepeatPassword'),
            array('katalaluan_lama', 'validateCurrentPassword'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id_pengguna, katalaluan, kat_pengguna, nama, id_pengenalan, emel, telefon, status_aktif, input_oleh, tkh_input, upd_oleh, tkh_upd', 'safe', 'on' => 'search'),
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
            'id_pengguna' => 'Id Pengguna',
            'katalaluan' => 'Katalaluan',
            'ulang_katalaluan' => 'Ulang Katalaluan',
            'kat_pengguna' => 'Kategori Pengguna',
            'nama' => 'Nama',
            'id_pengenalan' => 'No Kad Pengenalan',
            'emel' => 'Emel',
            'telefon' => 'Telefon',
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

        $criteria->compare('id_pengguna', $this->id_pengguna, true);
        $criteria->compare('katalaluan', $this->katalaluan, true);
        $criteria->compare('kat_pengguna', $this->kat_pengguna, true);
        $criteria->compare('nama', $this->nama, true);
        $criteria->compare('id_pengenalan', $this->id_pengenalan, true);
        $criteria->compare('emel', $this->emel, true);
        $criteria->compare('telefon', $this->telefon, true);
        $criteria->compare('status_aktif', $this->status_aktif, true);
        $criteria->compare('input_oleh', $this->input_oleh, true);
        $criteria->compare('tkh_input', $this->tkh_input, true);
        $criteria->compare('upd_oleh', $this->upd_oleh, true);
        $criteria->compare('tkh_upd', $this->tkh_upd, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
      private function generateHash($password) {
      if (defined("CRYPT_BLOWFISH") && CRYPT_BLOWFISH) {
      $salt = '$K9K7$' . substr(md5(uniqid(rand(), true)), 0, 22);
      return array('katalaluan' => crypt($password, $salt), 'katarahsia' => $salt);
      }
      }
     */
    private function generateHash($password) {
        $salt = '$K9K7$' . substr(md5(uniqid(rand(), true)), 0, 22);
        return array('katalaluan' => hash("sha256", $password . $salt), 'katarahsia' => $salt);
    }

    protected function beforeSave() {
        if ($this->isNewRecord) {
            $this->input_oleh = isset(Yii::app()->user->akaunIdPengguna) ? Yii::app()->user->akaunIdPengguna : 'anonymous';
            $this->tkh_input = new CDbExpression('NOW()');
            $hash = $this->generateHash($this->katalaluan);
            $this->katarahsia = $hash['katarahsia'];
            $this->katalaluan = $hash['katalaluan'];
        } else if ($this->authentication != 'auth') {
            $this->upd_oleh = isset(Yii::app()->user->akaunIdPengguna) ? Yii::app()->user->akaunIdPengguna : 'anonymous';
            $this->tkh_upd = new CDbExpression('NOW()');
            if (!empty($this->katalaluan) || $this->katalaluan != '' || $this->katalaluan != null) {
                //Jika ada input untuk kemaskini katalaluan
                if (
                        (isset(Yii::app()->user->akaunIdPengguna) && Yii::app()->user->akaunIdPengguna == $this->id_pengenalan) ||
                        ($this->kemaskini_katalaluan == 'lupa_katalaluan')
                ) {
                    //Jika pengguna mengemaskini sendiri katalaluan, check katalaluan dan ulangkatalaluan
                    if ($this->katalaluan == $this->ulang_katalaluan) {
                        $hash = $this->generateHash($this->katalaluan);
                        $this->katalaluan = $hash['katalaluan'];
                        $this->katarahsia = $hash['katarahsia'];
                    }
                } else {
                    //Jika administrator kemaskini katalaluan pengguna
                    $hash = $this->generateHash($this->katalaluan);
                    $this->katalaluan = $hash['katalaluan'];
                    $this->katarahsia = $hash['katarahsia'];
                }
            } else {
                unset($this->katalaluan);
            }
        }
        return true;
    }

    public function validatePasswordString() {
        $error = "";
        $error2 = array();
        if (strlen($this->katalaluan) < 12)
            $error = "melebihi 12 aksara";
        if (!preg_match('`[A-Z]`', $this->katalaluan))
            $error2[] = "huruf besar";
        if (!preg_match('`[a-z]`', $this->katalaluan))
            $error2[] = "huruf kecil";
        if (!preg_match('`[0-9]`', $this->katalaluan))
            $error2[] = "nombor";

        if ($error != '' || count($error2) > 0) {
            $errorText = 'Katalaluan perlu '
                    . $error
                    . (($error != "" && count($error2) > 0) ? ' dan ' : '')
                    . (count($error2) > 0 ? ' mempunyai ' . implode(', ', ($error2)) . '.' : '');
            $this->addError('katalaluan', $errorText);
            return false;
        } else {
            return true;
        }
    }

    public function validateRepeatPassword() {
        $return[] = true;
        if ($this->kemaskini_katalaluan == 'kemaskini') {
            if (empty($this->ulang_katalaluan) || $this->katalaluan != $this->ulang_katalaluan) {
                $this->addError('ulang_katalaluan', 'Sila pastikan Katalaluan dan Ulang Katalaluan adalah sama.');
                $return[] = false;
            }
        }

        foreach ($return as $r) {
            if ($r == false)
                return false;
            else {
                return true;
            }
        }
    }

    public function validateCurrentPassword() {
        if (isset(Yii::app()->user->akaunId)) {
            $data = $this->model()->findByPk(Yii::app()->user->akaunId);
            $return[] = true;
            if ($this->kemaskini_katalaluan == 'kemaskini') {
                if (empty($this->katalaluan_lama)) {
                    $this->addError('katalaluan_lama', 'Sila isi maklumat Katalaluan Lama.');
                    $return[] = false;
                } else {
                    if ($data->katalaluan != hash("sha256", $this->katalaluan_lama . $data->katarahsia)) {
                        $this->addError('katalaluan_lama', 'Maklumat Katalaluan Lama salah.');
                        $return[] = false;
                    }
                }
            }

            foreach ($return as $r) {
                if ($r == false)
                    return false;
                else {
                    return true;
                }
            }
        }
    }

    public function getEmailAddressByPBT($kodPBT) {
        $validator = new CEmailValidator;
        $emailAddress = array();
        $data = $this->model()->findAll(array(
            'condition' => 'pengguna_pbt.kod_pbt = :kodPBT',
            'join' => 'JOIN pengguna_pbt ON t.id_pengguna = pengguna_pbt.id_pengguna',
            'params' => array(':kodPBT' => $kodPBT)
        ));
        foreach ($data as $data):
            if ($data->email != null && $validator->validateValue($data->email))
                $emailAddress[] = $data->email;
        endforeach;
        return $emailAddress;
    }

}
