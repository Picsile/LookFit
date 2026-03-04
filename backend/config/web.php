<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'language' => 'RU-ru',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'request' => [
            'cookieValidationKey' => 'a',
            // 'baseUrl' => '',
            'baseUrl' => '/backend',

            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => \yii\symfonymailer\Mailer::class,
            'viewPath' => '@app/mail',
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,

        'urlManager' => [
            'enablePrettyUrl' => true,
            'enableStrictParsing' => true,
            'showScriptName' => false,
            'rules' => [
                // Guest
                "POST site/get-some-posts" => "site/get-some-posts",
                "OPTIONS site/get-some-posts" => "site/options",

                // Auth
                "POST site/register" => "site/register",
                "OPTIONS site/register" => "site/options",

                "POST site/login" => "site/login",
                "OPTIONS site/login" => "site/options",

                "GET site/find-by-token" => "site/find-by-token",
                "OPTIONS site/find-by-token" => "site/options",

                "GET site/logout" => "site/logout",
                "OPTIONS site/logout" => "site/options",

                // User
                "POST account/post/public-thing" => "account/post/public-thing",
                "OPTIONS account/post/public-thing" => "account/post/options",
            ],
        ],
    ],
    'params' => $params,
    'modules' => ['account' => ['class' => 'app\modules\account\Module',],],
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => ['*'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => ['*'],
    ];
}

return $config;
