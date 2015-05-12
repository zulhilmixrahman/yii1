<?php

class AuthController extends Controller {

    //Captcha Image Configuration
    public function actions() {
        return array(
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'backColor' => 0xFFFFFF,
            ),
            'page' => array(
                'class' => 'CViewAction',
            ),
        );
    }

    public function actionIndex() {
        $this->redirect('login');
    }

    public function actionLogin() {
        $counter = isset(Yii::app()->session['cuba']) ? Yii::app()->session['cuba'] : 0;
        if ($counter > 4)
            $this->redirect('captchalogin');

        $action = '';
        $model = new Login();
        if (isset($_POST['Login'])) {
            $model->attributes = $_POST['Login'];

            if ($model->validate() && $model->login()) {
                //redirect home
                /* Save Last Login Time on user table */
                $params = array(':username' => $_POST['Login']['username']);
                if (Yii::app()->user->akaunJenis == 'KPKT')
                    $akaun = Pengguna::model()->find("id_pengenalan = :username", $params);
                else if (Yii::app()->user->akaunJenis == 'JPP')
                    $akaun = Anggota::model()->find("no_kp = :username", $params);

                Yii::app()->session['userLastLogin'] = $akaun->last_login_time;
                $akaun->authentication = 'auth';
                $akaun->session_id = Yii::app()->getSession()->getSessionId();
                $akaun->last_login_time = date('Y-m-d H:i:s');
                $akaun->save(false);
                
                AuditTrailUser::model()->inputAuditTrail('Log-In Sistem');

                if (isset(Yii::app()->user->returnUrl)) {
                    if (strpos(Yii::app()->user->returnUrl, '/lantikan/anggota/tawaranlantikan'))
                        $this->redirect(Yii::app()->user->returnUrl);
                }

                if (Yii::app()->user->akaunJenis == 'KPKT')
                    $action = 'dashboard/dashboard/index';
                else if (Yii::app()->user->akaunJenis == 'JPP')
                    $action = 'lantikan/anggota/senarai';
                $this->redirect(Yii::app()->homeUrl . $action);
            } else {
                $counter++;
                Yii::app()->session['cuba'] = $counter;
                $this->render('login', array('model' => $model));
            }
        }
    }

    public function actionCaptchalogin() {
        $this->layout = "//layouts/plain";
        $action = '';
        $model = new CaptchaLogin();
        if (isset($_POST['CaptchaLogin'])) {
            $model->attributes = $_POST['CaptchaLogin'];

            if ($model->validate() && $model->login()) {
                //jika login success, unset session trial
                unset(Yii::app()->session['trial']);

                /* Save Last Login Time on user table */
                $params = array(':username' => $_POST['CaptchaLogin']['username']);
                if (Yii::app()->user->akaunJenis == 'KPKT')
                    $akaun = Pengguna::model()->find("id_pengenalan = :username", $params);
                else if (Yii::app()->user->akaunJenis == 'JPP')
                    $akaun = Anggota::model()->find("no_kp = :username", $params);

                $akaun->authentication = 'auth';
                $akaun->session_id = Yii::app()->getSession()->getSessionId();
                $akaun->last_login_time = date('Y-m-d H:i:s');
                $akaun->save(false);

                AuditTrailUser::model()->inputAuditTrail('Log-In Sistem melalui verifikasi Captcha');
                
                if (isset(Yii::app()->user->returnUrl)) {
                    if (strpos(Yii::app()->user->returnUrl, '/lantikan/anggota/tawaranlantikan'))
                        $this->redirect(Yii::app()->user->returnUrl);
                }

                if (Yii::app()->user->akaunJenis == 'KPKT')
                    $this->redirect(Yii::app()->homeUrl . 'dashboard/dashboard/index');
                else if (Yii::app()->user->akaunJenis == 'JPP')
                    $this->redirect(Yii::app()->homeUrl . 'lantikan/anggota/senarai');
            }
        }
        $this->render('captchalogin', array('model' => $model));
    }

    public function actionLogout() {
        if (isset(Yii::app()->user->akaunId)) {
            $params = array(':username' => Yii::app()->user->akaunId);

            if (Yii::app()->user->akaunJenis == 'KPKT')
                $akaun = Pengguna::model()->find("id_pengguna = :username", $params);
            else if (Yii::app()->user->akaunJenis == 'JPP')
                $akaun = Anggota::model()->find("id_anggota = :username", $params);

            $akaun->authentication = 'auth';
            $akaun->session_id = null;

            if ($akaun->save(false)) {
//                AuditTrailUser::model()->inputAuditTrail('Log-Out Sistem');
                Yii::app()->user->logout();
            }
        }
        $this->redirect(Yii::app()->request->baseUrl);
    }

}
