<?php

/**
 * This is the model class for table "rjk_kod".
 *
 * The followings are the available columns in table 'rjk_kod':
 * @property integer $id_kod
 * @property string $jenis_kod
 * @property string $kod
 * @property string $ket_kod
 * @property integer $status_aktif
 * @property string $input_oleh
 * @property string $tkh_input
 * @property string $upd_oleh
 * @property string $tkh_upd
 */
class RjkKod extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return RjkKod the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'rjk_kod';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('jenis_kod, ket_kod, kod, status_aktif', 'required'),
            array('status_aktif', 'numerical', 'integerOnly' => true),
            array('jenis_kod, input_oleh, upd_oleh', 'length', 'max' => 20),
            array('kod', 'length', 'max' => 10),
            array('ket_kod', 'length', 'max' => 50),
            array('tkh_input, tkh_upd', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id_kod, jenis_kod, kod, ket_kod, status_aktif, input_oleh, tkh_input, upd_oleh, tkh_upd', 'safe', 'on' => 'search'),
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
            'id_kod' => 'Id Kod',
            'jenis_kod' => 'Jenis Kod',
            'kod' => 'Kod',
            'ket_kod' => 'Keterangan Kod',
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

        $criteria->compare('id_kod', $this->id_kod);
        $criteria->compare('jenis_kod', $this->jenis_kod, true);
        $criteria->compare('kod', $this->kod, true);
        $criteria->compare('ket_kod', $this->ket_kod, true);
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

    public function getName($pk, $item = 'ket_kod') {
        if ($pk != 0) {
            $model = $this->findByPk($pk);
            return $model->$item;
        } else
            return null;
    }

    public function optionsJenisKod() {
        $data = $this->model()->findAll(array(
            'select' => 'DISTINCT(jenis_kod) AS jenis_kod',
            'condition' => 'status_aktif = 1'
        ));
        $options = CHtml::listData($data, 'jenis_kod', 'jenis_kod');
        $options[null] = '- Sila Pilih Jenis Kod -';
        ksort($options);
        return $options;
    }

    public function optionsKategoriPBT() {
        $options = CHtml::listData($this->model()->findAll("jenis_kod = 'Kategori-pbt' AND status_aktif = 1"), 'id_kod', 'ket_kod');
        $options[null] = '- Sila Pilih Kategori PBT -';
        ksort($options);
        return $options;
    }

    public function optionsJantina() {
        $options[null] = '- Sila Pilih Jantina -';
        $options['Lelaki'] = 'Lelaki';
        $options['Perempuan'] = 'Perempuan';
        ksort($options);
        return $options;
    }

    public function optionsAgama() {
        $options = CHtml::listData($this->model()->findAll("jenis_kod = 'Agama' AND status_aktif = 1"), 'id_kod', 'ket_kod');
        $options[null] = '- Sila Pilih Agama -';
        ksort($options);
        return $options;
    }

    public function optionsKaum() {
        $options = CHtml::listData($this->model()->findAll("jenis_kod = 'Kaum' AND status_aktif = 1"), 'id_kod', 'ket_kod');
        $options[null] = '- Sila Pilih Kaum -';
        ksort($options);
        return $options;
    }

    /**
     * Buang sebab dah ada table rjk_bank
    public function optionsBank() {
        $options = CHtml::listData($this->model()->findAll("jenis_kod = 'Bank' AND status_aktif = 1"), 'id_kod', 'ket_kod');
        $options[null] = '- Sila Pilih Bank -';
        ksort($options);
        return $options;
    }
    */

    public function optionsAkademik() {
        $options = CHtml::listData($this->model()->findAll("jenis_kod = 'Akademik' AND status_aktif = 1"), 'id_kod', 'ket_kod');
        $options[null] = '- Sila Pilih Akademik -';
        ksort($options);
        return $options;
    }

    public function optionsKodJawatanJPP($type = '') {
        $options = CHtml::listData($this->model()->findAll("jenis_kod = 'Jawatan-JPP'"), 'kod', 'ket_kod');
        if ($type == 'elaun') {
            $options['keraian'] = 'Keraian';
            $options['rawatan'] = 'Rawatan';
        }
        $options[null] = '- Sila Pilih Jawatan -';
        ksort($options);
        return $options;
    }

    public function optionsJawatanJPP($idPenggal = 0, $idZon = 0) {
        $filter = "jenis_kod = 'Jawatan-JPP'";
        if ($idPenggal != 0 && $idZon != 0) {
            $senaraiAnggota = Anggota::model()->findAll('id_zon = :idZon AND id_penggal = :idPenggal AND status_aktif = 1', array(':idZon' => $idZon, ':idPenggal' => $idPenggal));
            $filledBiro = array();
            foreach ($senaraiAnggota as $data) {
                //Pengerusi
                if ($data->kod_jawatan_jpp == 51)
                    $filter .= " AND id_kod != 51 ";

                //Setiausaha
                if ($data->kod_jawatan_jpp == 52)
                    $filter .= " AND id_kod != 52 ";

                if ($data->kod_jawatan_jpp == 53 && $data->kod_biro_jpp != 0) {
                    $filledBiro[] = $data->kod_biro_jpp;
                }
                if (count($filledBiro) == 8)
                    $filter .= " AND id_kod != 53 ";
            }
        }
        $filter .= " AND status_aktif = 1";
        $options = CHtml::listData($this->model()->findAll($filter), 'id_kod', 'ket_kod');
        $options[null] = '- Sila Pilih Jawatan -';
        ksort($options);
        return $options;
    }

    public function optionsBiroJPP($idPenggal = 0, $idZon = 0) {
        $filter = "jenis_kod = 'Biro-JPP'";
        if ($idPenggal != 0 && $idZon != 0) {
            $senaraiAnggota = Anggota::model()->findAll('id_zon = :idZon AND id_penggal = :idPenggal AND status_aktif = 1', array(':idZon' => $idZon, ':idPenggal' => $idPenggal));
            $filledBiro = array();
            foreach ($senaraiAnggota as $data) {
                if ($data->kod_jawatan_jpp == 53 && $data->kod_biro_jpp != 0) {
                    $filledBiro[] = $data->kod_biro_jpp;
                }
            }
            if (count($filledBiro) > 0)
                $filter .= " AND id_kod NOT IN (" . implode(",", $filledBiro) . ")";
        }
        $filter .= " AND status_aktif = 1";
        $options = CHtml::listData($this->model()->findAll($filter), 'id_kod', 'ket_kod');
        $options[null] = '- Sila Pilih Biro -';
        ksort($options);
        return $options;
    }

    public function optionsNegeri($item = 'id_kod', $null = '- Sila Pilih Negeri -', $semua = null) {
        $options = CHtml::listData($this->model()->findAll("jenis_kod = 'Negeri' AND status_aktif = 1"), $item, 'ket_kod');
        if ($semua == 'semua')
            $options[$semua] = 'Semua';
        else
            $options[null] = $null;
        ksort($options);
        return $options;
    }

    public function optionsSebabTamat() {
        $options = CHtml::listData($this->model()->findAll("jenis_kod = 'Sebab_Tamat' AND status_aktif = 1"), 'id_kod', 'ket_kod');
        $options[null] = '- Sila Pilih Sebab Tamat -';
        ksort($options);
        return $options;
    }

    public function optionsGelaran() {
        $options = CHtml::listData($this->model()->findAll("jenis_kod = 'Gelaran' AND status_aktif = 1"), 'id_kod', 'ket_kod');
        $options[null] = '- Sila Pilih Gelaran -';
        ksort($options);
        return $options;
    }

    public function optionsKategoriPengguna() {
        $options = CHtml::listData($this->model()->findAll("jenis_kod = 'Kategori-Pengguna' AND status_aktif = 1"), 'kod', 'ket_kod');
        $options[null] = '- Sila Pilih Kategori Pengguna -';
        ksort($options);
        return $options;
    }

    public function optionsKategoriPekerjaan() {
        $options = CHtml::listData($this->model()->findAll("jenis_kod = 'Kategori-Pekerjaan' AND status_aktif = 1"), 'id_kod', 'ket_kod');
        $options[null] = '- Sila Pilih Kategori Pekerjaan -';
        ksort($options);
        return $options;
    }

    public function optionsTawaranAnggotaJPP() {
        $options[1] = 'Tawaran Lantikan';
        $options[2] = 'Terima Tawaran';
        $options[3] = 'Tolak Tawaran';
        return $options;
    }

    /**
     * list option for Parti Komponen
     * @param $label String.
     * Default 'full'. Use 'short' for Short Name for Parti
     */
    public function optionsPartiKomponen($label = 'full') {
        $options = CHtml::listData($this->model()->findAll("jenis_kod = 'Parti-Komponen' AND status_aktif = 1"), 'id_kod', 'fullString');
        $options[null] = '- Sila Pilih Parti Komponen -';
        ksort($options);
        return $options;
    }

    public function getPartiKomponenList() {
        $data = array();
        $options = $this->model()->findAll("jenis_kod = 'Parti-Komponen' AND status_aktif = 1");
        foreach ($options as $o):
            $data[$o->id_kod] = $o->kod; // . ' - ' . $o->ket_kod;
        endforeach;
        return $data;
    }

    function getFullString() {
        return $this->kod . ' - ' . $this->ket_kod;
    }

    public function optionsBulan() {
        $bulan['01'] = 'Januari';
        $bulan['02'] = 'Febuari';
        $bulan['03'] = 'Mac';
        $bulan['04'] = 'April';
        $bulan['05'] = 'Mei';
        $bulan['06'] = 'Jun';
        $bulan['07'] = 'Julai';
        $bulan['08'] = 'Ogos';
        $bulan['09'] = 'September';
        $bulan['10'] = 'Oktober';
        $bulan['11'] = 'November';
        $bulan['12'] = 'Disember';
        return $bulan;
    }

    public function optionsTahun() {
        for ($i = 2014; $i <= date('Y'); $i++) {
            $tahun[$i] = $i;
        }
        return $tahun;
    }

}
