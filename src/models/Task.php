<?php
namespace HtmlAcademy\models\Task;

class Task {

    public $customerId;
    public $contractorId;
    public $createdAt;
    public $deadlineAt;
    public $currentStatus;

    public $lifecycleMap = [
        TaskStatus::NEW_TASK =>[
            TaskAction::ACCEPT => TaskStatus::IN_PROGRESS,
            TaskAction::CANCEL => TaskStatus::CANCELED
        ],
        TaskStatus::IN_PROGRESS =>[
            TaskAction::COMPLETE => TaskStatus::COMPLETED,
            TaskAction::REJECT => TaskStatus::FAILED
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
