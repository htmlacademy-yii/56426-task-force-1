<?php
require_once('vendor/autoload.php');

use HtmlAcademy\models\Task;
use HtmlAcademy\models\TaskAction;
use HtmlAcademy\models\TaskStatus;

$myTask = new Task(1);

assert($myTask->currentStatus === TaskStatus::NEW_TASK);
$myTask->currentStatus = $myTask->getStatusNext(TaskAction::ACCEPT);
assert($myTask->currentStatus === TaskStatus::IN_PROGRESS);
$myTask->currentStatus = $myTask->getStatusNext(TaskAction::COMPLETE);
assert($myTask->currentStatus === TaskStatus::COMPLETED);

$myTask = new Task(1);
assert($myTask->currentStatus === TaskStatus::NEW_TASK);
$myTask->currentStatus = $myTask->getStatusNext(TaskAction::ACCEPT);
assert($myTask->currentStatus === TaskStatus::IN_PROGRESS);
$myTask->currentStatus = $myTask->getStatusNext(TaskAction::REJECT);
assert($myTask->currentStatus === TaskStatus::FAILED);

$myTask = new Task(1);
assert($myTask->currentStatus === TaskStatus::NEW_TASK);
$myTask->currentStatus = $myTask->getStatusNext(TaskAction::CANCEL);
assert($myTask->currentStatus === TaskStatus::CANCELED);
