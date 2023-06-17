<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

use kartik\mpdf\Pdf;

$config = [
    'id' => 'basic',
    'name' => 'SAB - The Kingstown School',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'sourceLanguage' => 'es-ES',
    'language' => 'es',
    'modules' => [
        'gridview' => [
            'class' => '\kartik\grid\Module',
        ],
    ],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        // setup Krajee Pdf component
        'pdf' => [
            'class' => Pdf::class,
            'format' => Pdf::FORMAT_A4,
            'orientation' => Pdf::ORIENT_PORTRAIT,
            'destination' => Pdf::DEST_BROWSER,
            // refer settings section for all configuration options
        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'ejA6yGWw3CeiJKeUCArjnnS2NSqYH2Zj',
            /* 'parsers' => [
                'application/json' => 'yii\web\JsonParser'
            ] */
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableSession' => true,
            //'enableAutoLogin' => true,
        ],
        'formatter' => [
            'class' => 'yii\i18n\Formatter',
            'thousandSeparator' => '.',
            'decimalSeparator' => ',',
            'currencyCode' => '$',
            'nullDisplay' => '',
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
            'maxSourceLines' => 20,
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => false,
            'transport' => [
                'class' => 'Swift_SendmailTransport',
                'host'  => 'smtp.gmail.com',
                'username' => 'educacionks@gmail.com', //no olvidar cambiar estos parametros
                'password' => 'schoolKS2020', //por la cta kingstown
                'port' => '587',  //antes 587 para ssl 465
                'encryption' => 'tls', //antes tls y ssl
                'streamOptions' => [
                    'ssl' => [
                        'allow_self_signed' => true,
                        'verify_peer' => false,
                        'verify_peer_name' => false,
                    ],
                ],
            ],
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'flushInterval' => 1, // <- here
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning', 'trace', 'info'],
                    'logVars' => [],
                    'logFile' => '@runtime/webapp/logs/myfile.log',
                    'exportInterval' => 1, // <-- and here
                ],
            ],
        ],
        'db' => $db,

        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                //  ['class' => 'yii\rest\UrlRule', 'controller' => ['apiv1/cursos'], 'except' => ['delete', 'create', 'update']],
                //  ['class' => 'yii\rest\UrlRule', 'controller' => ['apiv1/user'], 'extraPatterns' => ['POST login' => 'login']],
            ],
        ],

    ],
    /** 'modules' => [
        'apiv1' => [
            'class' => 'app\modules\apiv1\Apiv1Module',
        ],
    ],**/
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
