<?php

/**
 * This is the model class for table "anggota".
 *
 * The followings are the available columns in table 'anggota':
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
 * @property string $umur
 * @property string $kod_kaum
 * @property string $kod_agama
 * @property string $kod_akademik
 * @property string $pekerjaan
 * @property string $kod_bank
 * @property string $no_akaun_bank
 * @property string $kod_parlimen
 * @property string $kod_dun
 * @property string $no_rujukan_surat
 * @property integer $status_aktif
 * @property integer $kod_sebab_tamat
 * @property string $input_oleh
 * @property string $tkh_input
 * @property string $upd_oleh
 * @property string $tkh_upd
 */
class Anggota extends CActiveRecord {

    public $authentication, $forgotPassword = false, $kemaskini_katalaluan, $katalaluan_lama, $ulang_katalaluan, $alamat_2, $alamat_3, $kemaskini_bank = false;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Anggota the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'anggota';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
// NOTE: you should only define rules for those attributes that
// will receive user inputs.
        return array(
            array('no_kp, nama, id_zon, id_penggal, kod_jawatan_jpp, kod_biro_jpp, '
                . 'tkh_lantik_mula, tkh_lantik_akhir, kod_gelaran, poskod, kod_negeri_alamat, tkh_surat_lantik,'
                . 'jantina, umur, kod_kaum, kod_agama, kod_akademik, pekerjaan,  '
                . 'tkh_lahir, kod_kategori_pekerjaan', 'required'),
            array('id_zon, id_penggal, poskod, status_aktif, kod_sebab_tamat, '
                . 'kod_bank, no_rujukan_surat, kod_kategori_pekerjaan, kod_parti, '
                . 'kod_sebab_tamat', 'numerical', 'integerOnly' => true),
            array('umur', 'numerical', 'integerOnly' => true, 'min' => 21, 'max' => 65),
            array('no_kp', 'length', 'max' => 12),
            array('kod_parlimen', 'length', 'max' => 4),
            array('kod_dun', 'length', 'max' => 5),
            array('nama, pekerjaan, kaum_lain, agama_lain', 'length', 'max' => 50),
            array('catatan_sebab_tamat', 'length', 'max' => 255),
            array('kod_jawatan_jpp, kod_biro_jpp, kod_negeri_alamat, jantina, kod_akademik', 'length', 'max' => 10),
            array('kod_gelaran, kod_kaum, kod_agama, input_oleh, upd_oleh', 'length', 'max' => 20),
            array('no_akaun_bank', 'length', 'max' => 50),
            array('alamat, session_id', 'length', 'max' => 100),
            array('katalaluan, katarahsia', 'length', 'max' => 255),
            /** maxSize = 1 byte * 1 megabyte * size_to_limit */
            array('gambar', 'file', 'types' => 'jpg, jpeg, png', 'mimeTypes' => 'image/pjpeg, image/jpeg, image/png',
                'maxSize' => 1024 * 1024 * 2, 'tooLarge' => 'Melebihi maximum 200Mb', 'allowEmpty' => true),
            array('penyata', 'file', 'types' => 'jpg, jpeg, png, doc, docx, odt, pdf', 'mimeTypes' => 'image/pjpeg, image/jpeg, image/png, application/vnd.oasis.opendocument.text, application/pdf',
                'maxSize' => 1024 * 1024 * 2, 'tooLarge' => 'Melebihi maximum 200Mb', 'allowEmpty' => true),
            array('alamat', 'validationAlamat1'),
            array('alamat_2', 'validationAlamat2'),
            array('emel', 'email'),
            array('ulang_katalaluan', 'validateRepeatPassword'),
            array('katalaluan_lama', 'validateCurrentPassword'),
            array('no_akaun_bank', 'validateBilDigitNoAkaun'),
            array('alamat_3, no_telefon, kod_bank, no_akaun_bank, katalaluan, emel, kod_parti, kaum_lain, agama_lain, gambar, tkh_lahir, '
                . 'kod_sebab_tamat, kod_terima_tawaran, kod_verifikasi_tawaran, tkh_surat_lantik, last_login_time, session_id, '
                . 'v_code_email', 'safe'),
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
            'gelaran' => array(self::BELONGS_TO, 'RjkKod', 'kod_gelaran',
                'on' => 'gelaran.jenis_kod = :jenis',
                'params' => array(':jenis' => 'Gelaran')
            ),
            'jawatan' => array(self::BELONGS_TO, 'RjkKod', 'kod_jawatan_jpp',
                'on' => 'jawatan.jenis_kod = :jenis',
                'params' => array(':jenis' => 'Jawatan-JPP')
            ),
            'biro' => array(self::BELONGS_TO, 'RjkKod', 'kod_biro_jpp',
                'on' => 'biro.jenis_kod = :jenis',
                'params' => array(':jenis' => 'Biro-JPP')
            ),
            'kaum' => array(self::BELONGS_TO, 'RjkKod', 'kod_kaum',
                'on' => 'kaum.jenis_kod = :jenis',
                'params' => array(':jenis' => 'Kaum')
            ),
            'bank' => array(self::BELONGS_TO, 'RjkBank', 'kod_bank'),
//            'bank' => array(self::BELONGS_TO, 'RjkKod', 'kod_bank',
//                'on' => 'bank.jenis_kod = :jenis',
//                'params' => array(':jenis' => 'Bank')
//            ),
            'agama' => array(self::BELONGS_TO, 'RjkKod', 'kod_agama',
                'on' => 'agama.jenis_kod = :jenis',
                'params' => array(':jenis' => 'Agama')
            ),
            'akademik' => array(self::BELONGS_TO, 'RjkKod', 'kod_akademik',
                'on' => 'akademik.jenis_kod = :jenis',
                'params' => array(':jenis' => 'Akademik')
            ),
            'penggal' => array(self::BELONGS_TO, 'Penggal', 'id_penggal'),
            'zon' => array(self::BELONGS_TO, 'RjkZon', 'id_zon'),
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
            'tkh_lantik_mula' => 'Tarikh Lantikan',
            'tkh_lantik_akhir' => 'Tarikh Tamat Lantikan',
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
            'kod_sebab_tamat' => 'Sebab Tamat',
            'tkh_lahir' => 'Tarikh Lahir',
            'kod_bank' => 'Bank',
            'no_akaun_bank' => 'No Akaun Bank'
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

    private function generateHash($password) {
        $salt = '$J9P$' . substr(md5(uniqid(rand(), true)), 0, 22);
        return array('katalaluan' => hash("sha256", $password . $salt), 'katarahsia' => $salt);
    }

    protected function beforeSave() {
        if ($this->isNewRecord) {
            $this->input_oleh = isset(Yii::app()->user->akaunIdPengguna) ? Yii::app()->user->akaunIdPengguna : 'anonymous';
            $this->tkh_input = new CDbExpression('NOW()');
            if ($this->kod_jawatan_jpp != 53) {
                $hash = $this->generateHash($this->no_kp);
                $this->katalaluan = $hash['katalaluan'];
                $this->katarahsia = $hash['katarahsia'];
            } else {
                $this->katalaluan = null;
                $this->katarahsia = null;
            }
        } else if ($this->authentication != 'auth') {
            $this->upd_oleh = isset(Yii::app()->user->akaunIdPengguna) ? Yii::app()->user->akaunIdPengguna : 'anonymous';
            $this->tkh_upd = new CDbExpression('NOW()');
            if ($this->forgotPassword == true && $this->kemaskini_katalaluan == 'lupa_katalaluan') {
                //Jika anggota mengemaskini sendiri katalaluan, check katalaluan dan ulangkatalaluan
                if ($this->katalaluan == $this->ulang_katalaluan) {
                    $hash = $this->generateHash($this->katalaluan);
                    $this->katarahsia = $hash['katarahsia'];
                    $this->katalaluan = $hash['katalaluan'];
                }
            } else if ($this->forgotPassword == false && ($this->kod_jawatan_jpp != 53 && Yii::app()->user->akaunJenis == 'JPP')) {
                if (!empty($this->katalaluan) || $this->katalaluan != '' || $this->katalaluan != null) {
                    //Jika ada input untuk kemaskini katalaluan
                    if (Yii::app()->user->akaunIdPengguna == $this->no_kp) {
                        //Jika anggota mengemaskini sendiri katalaluan, check katalaluan dan ulangkatalaluan
                        if ($this->katalaluan == $this->ulang_katalaluan) {
                            $hash = $this->generateHash($this->katalaluan);
                            $this->katarahsia = $hash['katarahsia'];
                            $this->katalaluan = $hash['katalaluan'];
                        }
                    } else {
                        //Jika UKB kemaskini katalaluan anggota
                        $hash = $this->generateHash($this->katalaluan);
                        $this->katalaluan = $hash['katalaluan'];
                        $this->katarahsia = $hash['katarahsia'];
                    }
                }
            } else if ($this->kod_jawatan_jpp == 53) {
                $this->katalaluan = null;
                $this->katarahsia = null;
            }
        }
        return true;
    }

    public function validatePasswordString() {
        $error = "";
        $error2 = array();
        if (strlen($this->katalaluan) < 12)
            $error = "perlu melebihi 12 aksara";
        if (!preg_match('`[A-Z]`', $this->katalaluan))
            $error2[] = "huruf besar";
        if (!preg_match('`[a-z]`', $this->katalaluan))
            $error2[] = "huruf kecil";
        if (!preg_match('`[0-9]`', $this->katalaluan))
            $error2[] = "nombor";

        if ($error != '' || count($error2) > 0) {
            $errorText = 'Katalaluan '
                    . $error
                    . (($error != "" && count($error2) > 0) ? ' dan ' : '')
                    . (count($error2) > 0 ? ' mempunyai ' . implode(', ', ($error2)) . '.' : '');
            $this->addError('katalaluan', $errorText);
            return false;
        } else {
            return true;
        }
    }

    public function getName($pk, $item) {
        $model = $this->findByPk($pk);
        return $model->$item;
    }

    /**
     * Semak jika No KP telah didaftarkan mengikut penggal
     * if exist, return true.
     */
    public function isAnggotaExistByPenggal($nokp, $idPenggal) {
        $model = $this->find('no_kp = :nokp AND id_penggal = :idPenggal', array(':nokp' => $nokp, ':idPenggal' => $idPenggal));
        return (count($model) > 0) ? true : false;
    }

    /**
     * Semak untuk user isi maklumat 2 baris alamat
     */
    public function validationAlamat1() {
        if ($this->forgotPassword == false && $this->kemaskini_katalaluan != 'kemaskini') {
            $this->alamat = trim($this->alamat);
            if (empty($this->alamat)) {
                $this->addError('alamat', 'Sila masukkan maklumat No Rumah/Jalan.');
            }
        }
    }

    public function validationAlamat2() {
        // if ($this->forgotPassword == false && $this->kemaskini_bank == false && $this->kemaskini_katalaluan != 'kemaskini') {
            // $this->alamat_2 = trim($this->alamat_2);
            // if (empty($this->alamat_2)) {
                // $this->addError('alamat_2', 'Sila masukkan maklumat Kawasan Perumahan.');
            // }
        // }
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
        if ($this->forgotPassword == true) {
            $return[] = true;
        } else {
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
        }

        foreach ($return as $r) {
            if ($r == false)
                return false;
            else {
                return true;
            }
        }
    }
    
    public function validateBilDigitNoAkaun(){
        if($this->kod_bank != 0){
            $bank = RjkBank::model()->findByPk($this->kod_bank);
            if(strlen($this->no_akaun_bank) != $bank->bil_digit_akaun){
                $this->addError('no_akaun_bank', 'No Akaun Bank bagi ' . ucwords(strtolower($bank->nama_bank)) . ' perlu mempunyai ' . $bank->bil_digit_akaun . ' Digit.');
                return false;
            }
        } else {
            return true;
        }
    }

    public function jumlahAnggotaMengikutNegeri($kodNegeri) {
        $condition = '';
        $params = array();
        if ($kodNegeri != 0) {
            $condition .= 'rjk_zon.kod_negeri = :kodNegeri';
            $params[':kodNegeri'] = $kodNegeri;
        }
        $data = $this->model()->find(array(
            'select' => 'COUNT(id_anggota) AS id_anggota',
            'join' => 'JOIN rjk_zon ON t.id_zon = rjk_zon.id_zon',
            'condition' => $condition,
            'params' => $params
        ));

        return $data->id_anggota;
    }

    public function jumlahAnggotaMengikutPBT($kodPBT) {
        $data = $this->model()->find(array(
            'select' => 'COUNT(id_anggota) AS id_anggota',
            'join' => 'JOIN rjk_zon ON t.id_zon = rjk_zon.id_zon',
            'condition' => 'kod_pbt = :kodPbt',
            'params' => array(
                ':kodPbt' => $kodPBT
            ),
            'order' => 't.id_zon, t.kod_jawatan_jpp, t.kod_biro_jpp'
        ));

        return $data->id_anggota;
    }

    public function jumlahAnggotaMengikutNegeridanJantina($kodNegeri, $jantina) {
        $condition = 'jantina = :jantina';
        $params[':jantina'] = $jantina;
        if ($kodNegeri != 0) {
            $condition .= ' AND rjk_zon.kod_negeri = :kodNegeri';
            $params[':kodNegeri'] = $kodNegeri;
        }
        $data = $this->model()->find(array(
            'select' => 'COUNT(id_anggota) AS id_anggota',
            'join' => 'JOIN rjk_zon ON t.id_zon = rjk_zon.id_zon',
            'condition' => $condition,
            'params' => $params,
            'order' => 't.id_zon, t.kod_jawatan_jpp, t.kod_biro_jpp'
        ));
        return $data->id_anggota;
    }

    public function jumlahAnggotaMengikutPBTdanJantina($kodPBT, $jantina) {
        $data = $this->model()->find(array(
            'select' => 'COUNT(id_anggota) AS id_anggota',
            'join' => 'JOIN rjk_zon ON t.id_zon = rjk_zon.id_zon',
            'condition' => 'kod_pbt = :kodPbt AND jantina = :jantina',
            'params' => array(
                ':kodPbt' => $kodPBT,
                ':jantina' => $jantina
            ),
            'order' => 't.id_zon, t.kod_jawatan_jpp, t.kod_biro_jpp'
        ));
        return $data->id_anggota;
    }

    public function jumlahAnggotaMengikutPBTdanHadTahun($kodPBT, $tahunMula, $TahunTamat) {
        $data = $this->model()->find(array(
            'select' => 'COUNT(id_anggota) AS id_anggota',
            'join' => 'JOIN rjk_zon ON t.id_zon = rjk_zon.id_zon',
            'condition' => 'kod_pbt = :kodPbt AND YEAR(tkh_lahir) <= :tahunMula AND YEAR(tkh_lahir) >= :tahunAkhir',
            'params' => array(
                ':kodPbt' => $kodPBT,
                ':tahunMula' => $tahunMula,
                ':tahunAkhir' => $TahunTamat
            ),
            'order' => 't.id_zon, t.kod_jawatan_jpp, t.kod_biro_jpp'
        ));
        return $data->id_anggota;
    }

    public function jumlahAnggotaMengikutNegeridanHadUmur($negeri, $umurMula, $umurTamat) {
        $data = $this->model()->find(array(
            'select' => 'COUNT(id_anggota) AS id_anggota',
            'join' => 'JOIN rjk_zon ON t.id_zon = rjk_zon.id_zon',
            'condition' => 'kod_negeri = :kodNegeri AND umur >= :umurMula AND umur <= :umurAkhir',
            'params' => array(
                ':kodNegeri' => $negeri,
                ':umurMula' => $umurMula,
                ':umurAkhir' => $umurTamat
            ),
            'order' => 't.id_zon, t.kod_jawatan_jpp, t.kod_biro_jpp'
        ));
        return $data->id_anggota;
    }

    public function jumlahAnggotaMengikutPBTdanHadUmur($kodPBT, $umurMula, $umurTamat) {
        $data = $this->model()->find(array(
            'select' => 'COUNT(id_anggota) AS id_anggota',
            'join' => 'JOIN rjk_zon ON t.id_zon = rjk_zon.id_zon',
            'condition' => 'kod_pbt = :kodPbt AND umur >= :umurMula AND umur <= :umurAkhir',
            'params' => array(
                ':kodPbt' => $kodPBT,
                ':umurMula' => $umurMula,
                ':umurAkhir' => $umurTamat
            ),
            'order' => 't.id_zon, t.kod_jawatan_jpp, t.kod_biro_jpp'
        ));
        return $data->id_anggota;
    }

    public function jumlahAnggotaMengikutNegeridanKaum($kodNegeri, $kodKaum = 0, $inArray = 'NOT IN') {
        $condition = '';
        $params = array();
        if ($kodNegeri != 0) {
            $condition .= ' AND rjk_zon.kod_negeri = :kodNegeri';
            $params[':kodNegeri'] = $kodNegeri;
        }
        
        if (is_array($kodKaum)) {
            $condition .= ' AND t.kod_kaum ' . $inArray . ' (' . implode(',', $kodKaum) . ')';
        } else if ($kodKaum <> 0) {
            $condition .= ' AND t.kod_kaum = :kodKaum';
            $params[':kodKaum'] = $kodKaum;
        }

        $data = $this->model()->findAll(array(
            'select' => 'COUNT(t.id_anggota) AS id_anggota, rjk_kod.ket_kod AS nama',
            'join' => 'JOIN rjk_zon ON t.id_zon = rjk_zon.id_zon '
            . 'JOIN rjk_kod ON t.kod_kaum = rjk_kod.id_kod ',
            'condition' => 'rjk_kod.jenis_kod = \'Kaum\'' . $condition,
            'params' => $params,
            'group' => 't.kod_kaum',
            'order' => 't.kod_kaum'
        ));
        return $data;
    }

    public function jumlahAnggotaMengikutPBTdanKaum($kodPBT, $kodKaum, $inArray = 'NOT IN') {
        if (is_array($kodKaum)) {
            $cond = 'kod_kaum ' . $inArray . ' (' . implode(',', $kodKaum) . ')';
            $params = array(
                ':kodPbt' => $kodPBT
            );
        } else {
            $cond = 'kod_kaum = :kodKaum';
            $params = array(
                ':kodPbt' => $kodPBT,
                ':kodKaum' => $kodKaum
            );
        }

        $data = $this->model()->find(array(
            'select' => 'COUNT(id_anggota) AS id_anggota',
            'join' => 'JOIN rjk_zon ON t.id_zon = rjk_zon.id_zon',
            'condition' => 'kod_pbt = :kodPbt AND ' . $cond,
            'params' => $params,
            'order' => 't.id_zon, t.kod_jawatan_jpp, t.kod_biro_jpp'
        ));
        return $data->id_anggota;
    }

    public function jumlahAnggotaMengikutAkademik($kodAkedemik) {
        $data = $this->model()->find(array(
            'select' => 'COUNT(id_anggota) AS id_anggota',
            'join' => 'JOIN rjk_zon ON t.id_zon = rjk_zon.id_zon',
            'condition' => 'kod_akademik IN (' . implode(',', $kodAkedemik) . ')',
            'order' => 't.id_zon, t.kod_jawatan_jpp, t.kod_biro_jpp'
        ));
        return $data->id_anggota;
    }
    
    public function jumlahAnggotaMengikutNegeridanAkademik($kodNegeri, $kodAkedemik) {
        $data = $this->model()->find(array(
            'select' => 'COUNT(id_anggota) AS id_anggota',
            'join' => 'JOIN rjk_zon ON t.id_zon = rjk_zon.id_zon',
            'condition' => 'kod_negeri = :kodNegeri AND kod_akademik IN (' . implode(',', $kodAkedemik) . ')',
            'params' => array(
                ':kodNegeri' => $kodNegeri
            ),
            'order' => 't.id_zon, t.kod_jawatan_jpp, t.kod_biro_jpp'
        ));
        return $data->id_anggota;
    }
    
    public function jumlahAnggotaMengikutPBTdanAkademik($kodPBT, $kodAkedemik) {
        $data = $this->model()->find(array(
            'select' => 'COUNT(id_anggota) AS id_anggota',
            'join' => 'JOIN rjk_zon ON t.id_zon = rjk_zon.id_zon',
            'condition' => 'kod_pbt = :kodPbt AND kod_akademik IN (' . implode(',', $kodAkedemik) . ')',
            'params' => array(
                ':kodPbt' => $kodPBT
            ),
            'order' => 't.id_zon, t.kod_jawatan_jpp, t.kod_biro_jpp'
        ));
        return $data->id_anggota;
    }

    public function getLatestNoRujukanMengikutPBT($pbt) {
        $data = $this->model()->find(array(
            'select' => 'MAX(no_rujukan_surat) AS no_rujukan_surat',
            'join' => 'JOIN rjk_zon AS zon ON t.id_zon = zon.id_zon',
            'condition' => 'zon.kod_pbt = :kodPbt',
            'params' => array(':kodPbt' => $pbt)
        ));
        return (int) $data->no_rujukan_surat;
    }

    public $kod_negeri, $jumlah_anggota;

    public function getAnggotaMengikutNegeri($negeri = 0) {
        if ($negeri != 0) {
            $data = $this->model()->find(array(
                'select' => 'zon.kod_negeri, COUNT(id_anggota) AS jumlah_anggota',
                'join' => 'JOIN rjk_zon AS zon ON t.id_zon = zon.id_zon',
                'condition' => 'zon.kod_negeri = :kodNegeri',
                'params' => array(':kodNegeri' => $negeri),
            ));
        } else {
            $data = $this->model()->findAll(array(
                'select' => 'zon.kod_negeri, COUNT(id_anggota) AS jumlah_anggota',
                'join' => 'JOIN rjk_zon AS zon ON t.id_zon = zon.id_zon',
                'group' => 'zon.kod_negeri'
            ));
        }
        return $data;
    }

    public $kod_pbt;

    public function getAnggotaMengikutNegeridanPBT($negeri) {
        $data = $this->model()->findAll(array(
            'select' => 'zon.kod_pbt, COUNT(id_anggota) AS jumlah_anggota',
            'join' => 'JOIN rjk_zon AS zon ON t.id_zon = zon.id_zon',
            'condition' => 'zon.kod_negeri = :kodNegeri',
            'params' => array(':kodNegeri' => $negeri),
            'group' => 'zon.kod_pbt'
        ));
        return $data;
    }

    public function getAnggotaMengikutPBT($pbt) {
        $data = $this->model()->find(array(
            'select' => 'zon.kod_pbt, COUNT(id_anggota) AS jumlah_anggota',
            'join' => 'JOIN rjk_zon AS zon ON t.id_zon = zon.id_zon',
            'condition' => 'zon.kod_pbt = :kodPBT',
            'params' => array(':kodPBT' => $pbt)
        ));
        return $data;
    }

    public function semakMaklumatBankAnggota($idAnggota) {
        $data = $this->model()->findByPk($idAnggota);
        return ($data->kod_bank != 0 && $data->no_akaun_bank != '') ? true : false;
    }

    public function getAnggotaMengikutParti($kod_parti){
        $data = $this->model()->find(array(
            'select' => 'COUNT(id_anggota) AS jumlah_anggota',
            'condition' => 'kod_parti = :kodParti',
            'params' => array(':kodParti' => $kod_parti)
        ));
        return $data->jumlah_anggota;
    }
    
    public function getAnggotaMengikutNegeridanParti($kod_parti, $kod_negeri){
        $data = $this->model()->find(array(
            'select' => 'COUNT(id_anggota) AS jumlah_anggota',
            'join' => 'JOIN rjk_zon AS zon ON t.id_zon = zon.id_zon',
            'condition' => 'kod_parti = :kodParti AND zon.kod_negeri = :kodNegeri',
            'params' => array(':kodParti' => $kod_parti, ':kodNegeri' => $kod_negeri)
        ));
        return $data->jumlah_anggota;
    }
    
}
