<?php
declare(strict_types=1);

ini_set('display_errors', 'On');
error_reporting(E_ALL);

require_once('vendor/autoload.php');

use HtmlAcademy\models\Task;
use HtmlAcademy\models\TaskStatus;
use HtmlAcademy\models\ActionAccept;
use HtmlAcademy\models\ActionCancel;
use HtmlAcademy\models\ActionComplete;
use HtmlAcademy\models\ActionReject;
use HtmlAcademy\models\AvailableActions;
use HtmlAcademy\models\UserRole;
use HtmlAcademy\ex\DataTypeException;

// Проверка методов получения следующего статуса и списка доступных действий

try {
    $myTask = new Task(1);
    $myTask->contractorId = 2;
    assert($myTask->currentStatus === TaskStatus::NEW_TASK);

    $actionsList = AvailableActions::getActions($myTask, UserRole::CUSTOMER, 1);
    assert($actionsList === [0 => 'Отменить']);
    $actionsList = AvailableActions::getActions($myTask, UserRole::CONTRACTOR, 1);
    assert($actionsList === []);
    $actionsList = AvailableActions::getActions($myTask, UserRole::CONTRACTOR, 2);
    assert($actionsList === [0 => 'Принять']);

    $myTask->currentStatus = $myTask->getStatusNext(ActionAccept::class);
    assert($myTask->currentStatus === TaskStatus::IN_PROGRESS);

    $actionsList = AvailableActions::getActions($myTask, UserRole::CUSTOMER, 1);
    assert($actionsList === [0 => 'Завершить']);
    $actionsList = AvailableActions::getActions($myTask, UserRole::CONTRACTOR, 1);
    assert($actionsList === []);
    $actionsList = AvailableActions::getActions($myTask, UserRole::CONTRACTOR, 2);
    assert($actionsList === [0 => 'Отказаться']);

    $myTask->currentStatus = $myTask->getStatusNext(ActionComplete::class);
    assert($myTask->currentStatus === TaskStatus::COMPLETED);

    $actionsList = AvailableActions::getActions($myTask, UserRole::CUSTOMER, 1);
    assert($actionsList === []);

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
}
catch (DataTypeException $e) {
    error_log("Неверный формат данных: " . $e->getMessage());
}
