<?php
require_once('vendor/autoload.php');

use HtmlAcademy\models\Task;
use HtmlAcademy\models\TaskStatus;
use HtmlAcademy\models\ActionAccept;
use HtmlAcademy\models\ActionCancel;
use HtmlAcademy\models\ActionComplete;
use HtmlAcademy\models\ActionReject;

$myTask = new Task(1);

assert($myTask->currentStatus === TaskStatus::NEW_TASK);
$myTask->currentStatus = $myTask->getStatusNext(ActionAccept::class);
assert($myTask->currentStatus === TaskStatus::IN_PROGRESS);
$myTask->currentStatus = $myTask->getStatusNext(ActionComplete::class);
assert($myTask->currentStatus === TaskStatus::COMPLETED);

$myTask = new Task(1);
assert($myTask->currentStatus === TaskStatus::NEW_TASK);
$myTask->currentStatus = $myTask->getStatusNext(ActionAccept::class);
assert($myTask->currentStatus === TaskStatus::IN_PROGRESS);
$myTask->currentStatus = $myTask->getStatusNext(ActionReject::class);
assert($myTask->currentStatus === TaskStatus::FAILED);

$myTask = new Task(1);
assert($myTask->currentStatus === TaskStatus::NEW_TASK);
$myTask->currentStatus = $myTask->getStatusNext(ActionCancel::class);
assert($myTask->currentStatus === TaskStatus::CANCELED);
