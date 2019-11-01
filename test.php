<?php
require_once('vendor/autoload.php');

use HtmlAcademy\models\Task;
use HtmlAcademy\models\TaskStatus;
use HtmlAcademy\models\AvailableActions;

$myTask = new Task(1);

assert($myTask->currentStatus === TaskStatus::NEW_TASK);
$myTask->currentStatus = $myTask->getStatusNext(AvailableActions::ACCEPT);
assert($myTask->currentStatus === TaskStatus::IN_PROGRESS);
$myTask->currentStatus = $myTask->getStatusNext(AvailableActions::COMPLETE);
assert($myTask->currentStatus === TaskStatus::COMPLETED);

$myTask = new Task(1);
assert($myTask->currentStatus === TaskStatus::NEW_TASK);
$myTask->currentStatus = $myTask->getStatusNext(AvailableActions::ACCEPT);
assert($myTask->currentStatus === TaskStatus::IN_PROGRESS);
$myTask->currentStatus = $myTask->getStatusNext(AvailableActions::REJECT);
assert($myTask->currentStatus === TaskStatus::FAILED);

$myTask = new Task(1);
assert($myTask->currentStatus === TaskStatus::NEW_TASK);
$myTask->currentStatus = $myTask->getStatusNext(AvailableActions::CANCEL);
assert($myTask->currentStatus === TaskStatus::CANCELED);
