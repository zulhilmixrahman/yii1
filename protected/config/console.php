<?php

// database configuration
define("MYSQL_HOST", '');
define("MYSQL_USER", '');
define("MYSQL_PASS", '');
define("MYSQL_DB", '');

//email configuration
define("EMAIL_HOST", '');
define("EMAIL_SMTPAUTH", true);
define("EMAIL_PORT", 25);
define("EMAIL_USERNAME", '');
define("EMAIL_PASSWORD", '');

return array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => 'My Console Application',
    // application components
    'components' => array(
        'user' => array('allowAutoLogin' => true),
        'db' => array(
            'connectionString' => 'mysql:host=' . MYSQL_HOST . ';dbname=' . MYSQL_DB . '',
            'emulatePrepare' => true,
            'username' => MYSQL_USER,
            'password' => MYSQL_PASS,
            'charset' => 'utf8',
            'tablePrefix' => 'tbl_',
            'enableParamLogging' => true,
            'enableProfiling' => true,
        ),
        'mailer' => array(
            'class' => 'ext.mailer.EMailer',
            'Host' => EMAIL_HOST,
            'SMTPAuth' => EMAIL_SMTPAUTH,
            'Port' => EMAIL_PORT,
            'Username' => EMAIL_USERNAME,
            'Password' => EMAIL_PASSWORD,
            'From' => EMAIL_USERNAME,
            'FromName' => 'Sistem KPKT',
        ),)
);