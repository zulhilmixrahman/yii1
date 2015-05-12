<?php

class UIdentity extends CUserIdentity {

    public function authenticate() {
        $params = array(':username' => $this->username);
        $akaun = Pengguna::model()->find("BINARY id_pengenalan = :username", $params);
        $jenisPengguna = 'KPKT';
        if (!$akaun) {
            $akaun = Anggota::model()->find("no_kp = :username", $params);
            if ($akaun)
                $jenisPengguna = 'JPP';
        }
        if ($akaun === null) {
            $this->errorCode = self::ERROR_USERNAME_INVALID;
        } else if ($akaun->status_aktif == 0) {
            return "akaun_tidak_aktif";
        } else {
//            if ($akaun->katalaluan !== crypt($this->password, $akaun->katarahsia)) {
            if ($akaun->katalaluan !== hash("sha256", $this->password . $akaun->katarahsia)) {
                $this->errorCode = self::ERROR_PASSWORD_INVALID;
            } else {
                $this->setState('akaunJenis', $jenisPengguna);
                if ($jenisPengguna == 'KPKT') {
                    $penyeliaanPbt = array();
                    $pbt = PenggunaPbt::model()->findAll('id_pengguna = :idPengguna', array(':idPengguna' => $akaun->id_pengguna));
                    if ($pbt) {
                        foreach ($pbt as $pbt) {
                            $penyeliaanPbt[] = $pbt->kod_pbt;
                        }
                    }
                    $this->setState('akaunId', $akaun->id_pengguna);
                    $this->setState('akaunIdPengguna', $akaun->id_pengenalan);
                    $this->setState('akaunNama', $akaun->nama);
                    $this->setState('akaunJawatan', $akaun->jawatan);
                    $this->setState('akaunEmel', $akaun->emel);
                    $this->setState('akaunKategori', $akaun->kat_pengguna);
                    $this->setState('akaunPBT', $penyeliaanPbt);
                } else if ($jenisPengguna == 'JPP') {
                    if ($akaun->kod_jawatan_jpp == 51 || $akaun->kod_jawatan_jpp == 52) {
                        $this->setState('akaunId', $akaun->id_anggota);
                        $this->setState('akaunIdPengguna', $akaun->no_kp);
                        $this->setState('akaunNama', $akaun->nama);
                        $this->setState('akaunEmel', $akaun->emel);
                        $this->setState('akaunPenggal', $akaun->id_penggal);
                        $this->setState('akaunZon', $akaun->id_zon);
                        $this->setState('akaunJawatan', $akaun->kod_jawatan_jpp);
                    } else {
                        return self::ERROR_UNKNOWN_IDENTITY;
                    }
                }
                $this->errorCode = self::ERROR_NONE;
            }
        }
        return !$this->errorCode;
    }

}
