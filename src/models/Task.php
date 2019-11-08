<?php
namespace HtmlAcademy\models;

class Task {

    public $customerId;
    public $contractorId;
    public $createdAt;
    public $deadlineAt;
    public $currentStatus;
    public $lifecycleMap;

    public function __construct(int $customerId, int $deadlineAt = NULL) {
        $this->customerId = $customerId;
        $this->contractorId = NULL;
        $this->createdAt = time();
        $this->deadlineAt = ($deadlineAt !== NULL) ? $deadlineAt : $this->createdAt + 864000;
        $this->currentStatus = TaskStatus::NEW_TASK;
        $this->lifecycleMap = [
            TaskStatus::NEW_TASK => [
                ActionAccept::getName() => TaskStatus::IN_PROGRESS,
                ActionCancel::getName() => TaskStatus::CANCELED
            ],
            TaskStatus::IN_PROGRESS => [
                ActionComplete::getName() => TaskStatus::COMPLETED,
                ActionReject::getName() => TaskStatus::FAILED
            ]
        ];
    }

    public function getStatusNext($action) {
        return $this->lifecycleMap[$this->currentStatus][$action] ?? NULL;
    }

}
