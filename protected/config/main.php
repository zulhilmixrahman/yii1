<?php

date_default_timezone_set('Asia/Kuala_Lumpur');

// database configuration
define("MYSQL_HOST", 'localhost');
define("MYSQL_USER", 'root');
define("MYSQL_PASS", '');
define("MYSQL_DB", 'yii_training');

//email configuration
define("EMAIL_HOST", 'smtp.gmail.com');
define("EMAIL_SMTPAUTH", true);
define("EMAIL_PORT", 587);
define("EMAIL_USERNAME", 'email@gmail.com');
define("EMAIL_PASSWORD", 'password');

//for large pdf file size; 0:unlimited
ini_set('max_execution_time', 0);

return array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => 'Yii Training',
    'preload' => array(),
    'import' => array(
        'application.models.*',
        'application.components.*',
        'application.extensions.*',
        'application.controllers.*'
    ),
    'behaviors' => array(
        'onBeginRequest' => array(
            'class' => 'application.components.RequireLogin'
        )
    ),
    'defaultController' => 'site',
    'modules' => array(
        'gii' => array(
            'generatorPaths' => array('bootstrap.gii'),
            'class' => 'system.gii.GiiModule',
            'password' => 'password',
            'ipFilters' => array(
                '127.0.0.1', '::1'
            )
        ),
        'aduan'
    ),
    'components' => array(
        'user' => array(
            'loginUrl' => array(''),
            'allowAutoLogin' => true
        ),
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
            'FromName' => 'Training Yii',
        ),
        'errorHandler' => array(
            'errorAction' => 'site/error'
        ),
        'urlManager' => array(
            'urlFormat' => 'path'
        ),
        'session' => array(
            'timeout' => 3600
        )
    ),
    'params' => require(dirname(__FILE__) . '/params.php')
);
