<?php
use HtmlAcademy\models\Task;
use HtmlAcademy\models\TaskAction;
use HtmlAcademy\models\TaskStatus;

require_once('vendor/autoload.php');

$statusList = TaskStatus::getAll();

$myTask = new Task(1);
var_dump(date("d.m.Y H:i:s", $myTask->createdAt));
var_dump($statusList[$myTask->currentStatus]);
$myTask->currentStatus = $myTask->getStatusNext(TaskAction::ACCEPT);
var_dump($statusList[$myTask->currentStatus]);
$myTask->currentStatus = $myTask->getStatusNext(TaskAction::COMPLETE);
var_dump($statusList[$myTask->currentStatus]);

$myTask = new Task(1);
var_dump(date("d.m.Y H:i:s", $myTask->createdAt));
var_dump($statusList[$myTask->currentStatus]);
$myTask->currentStatus = $myTask->getStatusNext(TaskAction::ACCEPT);
var_dump($statusList[$myTask->currentStatus]);
$myTask->currentStatus = $myTask->getStatusNext(TaskAction::REJECT);
var_dump($statusList[$myTask->currentStatus]);

$myTask = new Task(1);
var_dump(date("d.m.Y H:i:s", $myTask->createdAt));
var_dump($statusList[$myTask->currentStatus]);
$myTask->currentStatus = $myTask->getStatusNext(TaskAction::CANCEL);
var_dump($statusList[$myTask->currentStatus]);
