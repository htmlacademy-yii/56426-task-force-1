<?php

class Task {

    public const STATUS_NEW = "Новое задание";
    public const STATUS_IN_PROGRESS = "Задание выполняется";
    public const STATUS_FINISHED = "Задание завершено";
    public const STATUS_CANCELED = "Задание отменено";
    public const STATUS_FAILED = "Задание провалено";

    public const ACTION_ACCEPT = "Принять задание";
    public const ACTION_CANCEL = "Отменить задание";
    public const ACTION_FINISH = "Завершить задание";
    public const ACTION_REJECT = "Отказаться от задания";

    public const ROLE_CUSTOMER = "Заказчик";
    public const ROLE_CONTRACTOR = "Исполнитель";

    public $customerId;
    public $contractorId;
    public $deadlineTime;
    public $currentStatus;

    public function __construct($customerId, $deadlineTime) {
        $this->$customerId = $customerId;
        $this->$contractorId = null;
        $this->$deadlineTime = $deadlineTime;
        $this->$currentStatus = self::STATUS_NEW;
    }

    public function getStatusList() {
        return [
            "STATUS_NEW" => self::STATUS_NEW,
            "STATUS_IN_PROGRESS" => self::STATUS_IN_PROGRESS,
            "STATUS_FINISHED" => self::STATUS_FINISHED,
            "STATUS_CANCELED" => self::STATUS_CANCELED,
            "STATUS_FAILED" => self::STATUS_FAILED
        ];
    }

    public function getActionList() {
        return [
            "ACTION_ACCEPT" => self::ACTION_ACCEPT,
            "ACTION_CANCEL" => self::ACTION_CANCEL,
            "ACTION_FINISH" => self::ACTION_FINISH,
            "ACTION_REJECT" => self::ACTION_REJECT
        ];
    }

    public function getStatusNext($action) {
        $nextStatus = null;
        switch ($this->$currentStatus) {
            case self::STATUS_NEW:
                if ($action == self::ACTION_ACCEPT) {
                    $nextStatus = self::STATUS_IN_PROGRESS;
                } else if ($action == self::ACTION_CANCEL) {
                    $nextStatus = self::STATUS_CANCELED;
                }
                break;
            case self::STATUS_IN_PROGRESS:
                if ($action == self::ACTION_FINISH) {
                    $nextStatus = self::STATUS_FINISHED;
                } else if ($action == self::ACTION_REJECT) {
                    $nextStatus = self::STATUS_FAILED;
                }
        }
        return $nextStatus;
    }

}

?>
