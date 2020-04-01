<?php

namespace frontend\modules\api\controllers;

use yii\rest\ActiveController;
use frontend\models\Task;

class MessagesController extends ActiveController
{
    public $modelClass = Task::class;
}
