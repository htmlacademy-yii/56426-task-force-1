<?php
namespace models;

class Task {

    public $customerId;
    public $contractorId;
    public $deadlineTime;
    public $currentStatus;

    public $lifecycleMap = [
        TaskStatus::NEW =>[
            TaskAction::ACCEPT => TaskStatus::IN_PROGRESS,
            TaskAction::CANCEL => TaskStatus::CANCELED
        ],
        TaskStatus::IN_PROGRESS =>[
            TaskAction::COMPLETE => TaskStatus::CANCELED,
            TaskAction::REJECT => TaskStatus::FAILED
        ]
    ];

    public function __construct(int $customerId, timestamp $deadlineTime) {
        $this->customerId = $customerId;
        $this->contractorId = null;
        $this->deadlineTime = $deadlineTime;
        $this->currentStatus = TaskStatus::NEW;
    }

    public function getStatusNext($action) {
        return $this->lifecycleMap[$this->currentStatus][$action] ?? null;
    }

}
