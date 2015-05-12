<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class Login extends CFormModel {

    public $username;
    public $password;
    public $rememberMe;
    private $_identity;

    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    public function rules() {
        return array(
            // username and password are required
            array('username, password', 'required'),
            // rememberMe needs to be a boolean
            array('rememberMe', 'boolean'),
            // password needs to be authenticated
            array('password', 'authenticate'),
        );
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels() {
        return array(
            'rememberMe' => 'Remember me next time',
            'username' => 'ID pengguna',
            'password' => 'katalaluan',
        );
    }

    /**
     * Authenticates the password.
     * This is the 'authenticate' validator as declared in rules().
     */
    public function authenticate() {
        if (!$this->hasErrors()) {
            $this->_identity = new UIdentity($this->username, $this->password);
            if ($this->_identity->authenticate() === "akaun_tidak_aktif")
                $this->addError('username', Yii::t('main/site', 'Akaun anda tidak aktif. Sila hubungi pentadbir sistem untuk pengaktifan semula akaun anda'));
            else if (!$this->_identity->authenticate())
                $this->addError('password', Yii::t('main/site', 'Kesalahan ID Pengguna atau Katalaluan.'));
        }
    }

    /**
     * Logs in the user using the given username and password in the model.
     * @return boolean whether login is successful
     */
    public function login() {
        if ($this->_identity === null) {
            $this->_identity = new UIdentity($this->username, $this->password);
            $this->_identity->authenticate();
        }
        if ($this->_identity->errorCode === UIdentity::ERROR_NONE) {
            $duration = 3600;
            Yii::app()->user->login($this->_identity, $duration);
            return true;
        } else
            return false;
    }

}
