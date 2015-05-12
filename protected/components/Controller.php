<?php

class Controller extends CController {

    public $layout = '//layouts/content';
    public $menu = array();
    public $breadcrumbs = array();
    public $googleChartColorList = array("#3366cc", "#dc3912", "#ff9900", "#109618", "#990099", "#0099c6", "#dd4477",
        "#66aa00", "#b82e2e", "#316395", "#994499", "#22aa99", "#aaaa11", "#6633cc", "#e67300", "#8b0707", "#651067",
        "#329262", "#5574a6", "#3b3eac", "#b77322", "#16d620", "#b91383", "#f4359e", "#9c5935", "#a9c413", "#2a778d",
        "#668d1c", "#bea413", "#0c5922", "#743411");

    function init() {
        parent::init();
        $this->checkLanguage();
    }

    /**
     * Sanitize $_GET value by type
     * @name String. index name of value eg. $_GET['this_name']
     * @type String. default 'string'. For sanitize value such as int
     */
    public function getParam($name, $type = 'string') {
        if ($type == 'int') {
            if (isset($_GET[$name]) && $_GET[$name] <> null && is_numeric($_GET[$name]))
                $value = (isset($_GET[$name]) && $_GET[$name] <> null && is_numeric($_GET[$name])) ? (int) $_GET[$name] : 0;
            else if (isset($_POST[$name]) && $_POST[$name] <> null && is_numeric($_POST[$name]))
                $value = (isset($_POST[$name]) && $_POST[$name] <> null && is_numeric($_POST[$name])) ? (int) $_POST[$name] : 0;
            else
                $value = 0;
        } else {
            if (isset($_GET[$name]))
                $value = $this->strip_html_tags($_GET[$name]);
            else if (isset($_POST[$name]))
                $value = $this->strip_html_tags($_POST[$name]);
            else
                $value = null;
        }
        return $value;
    }

    public function getAbsoluteAppPath() {
        return str_replace('/protected', '', Yii::app()->basePath);
    }

    public function strip_html_tags($text) {
    // Remove invisible content
        $replace_text = preg_replace(
                array(
            '@<head[^>]*?>.*?</head>@siu',
            '@<style[^>]*?>.*?</style>@siu',
            '@<script[^>]*?.*?</script>@siu',
            '@<object[^>]*?.*?</object>@siu',
            '@<embed[^>]*?.*?</embed>@siu',
            '@<applet[^>]*?.*?</applet>@siu',
            '@<noframes[^>]*?.*?</noframes>@siu',
            '@<noscript[^>]*?.*?</noscript>@siu',
            '@<noembed[^>]*?.*?</noembed>@siu'
                ), array(
            '', '', '', '', '', '', '', '', ''), $text);

        return strip_tags($replace_text);
    }

    public function checkLanguage() {
        $app = Yii::app();
        if (isset($_GET['lang'])) {
            $app->language = $this->strip_html_tags($_GET['lang']);
            $app->session['_lang'] = $app->language;
        } else if (isset($app->session['_lang'])) {
            $app->language = $app->session['_lang'];
        } else {
            $app->language = 'ms';
        }
    }

    public function sendMailer($receivers, $subject, $body) {
        if (Yii::app()->params['emailNotify']) {
            $mailer = Yii::app()->mailer;
            $mailer->IsSMTP();
            $mailer->SMTPSecure = "tls"; //Untuk gmail

            if (is_array($receivers)) {
                foreach ($receivers as $email):
                    $mailer->AddAddress($email);
                endforeach;
            } else {
                $mailer->AddAddress($receivers);
            }

            $mailer->Subject = $subject;
            $mailer->IsHTML(true);
            $mailer->Body = $body;
            return $mailer->Send();
        }
    }

    public function createTCPDF($html, $title = '', $layout = 'P', $dest = 'I', $header = false, $footer = false) {
        $pdf = Yii::createComponent('application.extensions.tcpdf.ETcPdf', $layout, 'cm', 'A4', true, 'UTF-8');
        $pdf->setPrintHeader($header);
        $pdf->setPrintFooter($footer);
        $pdf->SetFont('helvetica', '', 9);
        $pdf->AddPage();
        $pdf->writeHTML($html, true, 0, true, 0);
        $pdf->Output(($title != '') ? $title : date('Ymd') . '_' . rand() . '.pdf', $dest);
        exit;
    }

}
