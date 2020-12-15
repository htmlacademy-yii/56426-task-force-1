<?php
declare(strict_types=1);

ini_set('display_errors', 'On');
error_reporting(E_ALL);

require_once('vendor/autoload.php');

use HtmlAcademy\Models\Task;
use HtmlAcademy\Models\TaskStatus;
use HtmlAcademy\Models\ActionAccept;
use HtmlAcademy\Models\ActionCancel;
use HtmlAcademy\Models\ActionComplete;
use HtmlAcademy\Models\ActionReject;
use HtmlAcademy\Models\AvailableActions;
use HtmlAcademy\Models\UserRole;
use HtmlAcademy\Exceptions\DataTypeException;

// Проверка методов получения следующего статуса и списка доступных действий

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

// Проверка обработки исключений

try {
    $exceptionClass = null;
    $exceptionMessage = null;

    $myTask = new Task(1);
    $myTask->currentStatus = $myTask->getStatusNext('some action');
} catch (Exception $exception) {
    $exceptionClass = get_class($exception);
    $exceptionMessage = $exception->getMessage();
} finally {
    assert($exceptionClass === DataTypeException::class);
    assert($exceptionMessage === "Действие 'some action' не существует.");
}
