<?php
namespace HtmlAcademy\models;

class Task {

    public $customerId;
    public $contractorId;
    public $createdAt;
    public $deadlineAt;
    public $currentStatus;

    public $lifecycleMap = [
        TaskStatus::NEW_TASK => [
            ActionAccept::class => TaskStatus::IN_PROGRESS,
            ActionCancel::class => TaskStatus::CANCELED
        ],
        TaskStatus::IN_PROGRESS => [
            ActionComplete::class => TaskStatus::COMPLETED,
            ActionReject::class => TaskStatus::FAILED
        ]
    ];

    public function __construct(int $customerId, int $deadlineAt = NULL) {
        $this->customerId = $customerId;
        $this->contractorId = NULL;
        $this->createdAt = time();
        $this->deadlineAt = ($deadlineAt !== NULL) ? $deadlineAt : $this->createdAt + 864000;
        $this->currentStatus = TaskStatus::NEW_TASK;
    }

    public function getStatusNext($action) {
        return $this->lifecycleMap[$this->currentStatus][$action] ?? NULL;
    }

}
