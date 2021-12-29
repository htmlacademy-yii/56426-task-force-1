<?php

namespace frontend\controllers;

use yii\web\Controller;
use yii\filters\AccessControl;

abstract class SecuredController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@']
                    ],
                    [
                        'allow' => false,
                        'roles' => ['?'],
                        'denyCallback' => function() {
                            return $this->goHome();
                        }
                    ]
                ]
            ]
        ];
    }
}
