<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'language' => 'ru-RU',
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'modules' => [
        'api' => [
            'class' => 'frontend\modules\api\Module'
        ]
    ],
    'components' => [
        'formatter' => [
            'class' => 'yii\i18n\Formatter',
            'defaultTimeZone' => 'GMT+5',
            'timeZone' => 'GMT+5'
        ],
        'redis' => [
            'class' => 'yii\redis\Connection',
            'hostname' => 'localhost',
            'port' => 6379,
            'database' => 0
        ],
        'authClientCollection' => [
            'class' => 'yii\authclient\Collection',
            'clients' => [
                'vkontakte' => [
                    'class' => 'yii\authclient\clients\VKontakte',
                    'clientId' => '',
                    'clientSecret' => '',
                    'scope' => ['email']
                ]
            ]
        ],
        'request' => [
            'csrfParam' => '_csrf-frontend',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ],
        'user' => [
            'identityClass' => 'frontend\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
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
        'errorHandler' => [
            'errorAction' => 'tasks/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => false,
            'rules' => [
                '/' => 'landing/index',
                '/auth' => 'landing/auth',
                '/login' => 'landing/login',
                '/logout' => 'logout/index',
                '/signup' => 'signup/index',
                '/account' => 'account/index',
                '/tasks/page/<page:\d+>' => 'tasks/index',
                '/tasks' => 'tasks/index',
                '/tasks/category/<category:\d+>' => 'tasks/index',
                '/users/sort/<sort:\w+>/page/<page:\d+>' => 'users/index',
                '/users/sort/<sort:\w+>' => 'users/index',
                '/users/page/<page:\d+>' => 'users/index',
                '/users' => 'users/index',
                '/users/skill/<skill:\d+>' => 'users/index',
                '/task/<id:\d+>' => 'tasks/view',
                '/user/<id:\d+>' => 'users/view',
                '/task/create' => 'tasks/create',
                '/task/<id:\d+>/reply' => 'tasks/reply',
                '/task/<id:\d+>/reject' => 'tasks/reject',
                '/task/<id:\d+>/cancel' => 'tasks/cancel',
                '/task/<id:\d+>/complete' => 'tasks/complete',
                '/task/<task_id:\d+>/apply/<user_id:\d+>' => 'tasks/apply',
                '/task/<task_id:\d+>/refuse/<reply_id:\d+>' => 'tasks/refuse',
                '/list/<status:\w+>' => 'list/index',
                '/location' => 'location/index',
                '/events' => 'events/index',
                '/events/clear' => 'events/clear',
                ['class' => 'yii\rest\UrlRule', 'controller' => 'api/messages']
            ],
        ],
    ],
    'params' => $params,
];
