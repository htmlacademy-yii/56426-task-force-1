<?php

namespace frontend\modules\api\controllers;

use yii\rest\ActiveController;
use frontend\models\Chat;

class MessagesController extends ActiveController
{
    public $modelClass = Chat::class;
}
