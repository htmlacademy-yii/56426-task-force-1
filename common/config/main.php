<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'formatter' => [
            'class' => 'yii\i18n\Formatter',
            'defaultTimeZone' => 'GMT+5',
            'timeZone' => 'GMT+5'
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ]
    ]
];
