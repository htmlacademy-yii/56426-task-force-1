<?php

class Task {

    public const STATUS_NEW = "Новое задание";
    public const STATUS_EXECUTE = "Задание выполняется";
    public const STATUS_FINISH = "Задание завершено";
    public const STATUS_CANCEL = "Задание отменено";
    public const STATUS_FAIL = "Задание провалено";

    public const ACTION_ACCEPT = "Принять задание";
    public const ACTION_CANCEL = "Отменить задание";
    public const ACTION_FINISH = "Завершить задание";
    public const ACTION_REFUSE = "Отказаться от задания";

    public const ROLE_CUSTOMER = "Заказчик";
    public const ROLE_EXECUTOR = "Исполнитель";

    public $id_customer;
    public $id_executor;
    public $completion_time;
    public $current_status;

    public function __construct($id_customer, $completion_time) {
        $this->$id_customer = $id_customer;
        $this->$id_executor = null;
        $this->$completion_time = $completion_time;
        $this->$current_status = self::STATUS_NEW;
    }

    public function getStatusList() {
        return array(
            "STATUS_NEW" => self::STATUS_NEW,
            "STATUS_EXECUTE" => self::STATUS_EXECUTE,
            "STATUS_FINISH" => self::STATUS_FINISH,
            "STATUS_CANCEL" => self::STATUS_CANCEL,
            "STATUS_FAIL" => self::STATUS_FAIL
        );
    }

    public function getActionList() {
        return array(
            "ACTION_ACCEPT" => self::ACTION_ACCEPT,
            "ACTION_CANCEL" => self::ACTION_CANCEL,
            "ACTION_FINISH" => self::ACTION_FINISH,
            "ACTION_REFUSE" => self::ACTION_REFUSE
        );
    }

    public function getStatusNext($action) {
        $nextStatus = null;
        switch ($this->$current_status) {
            case self::STATUS_NEW:
                if ($action == self::ACTION_ACCEPT) {
                    $nextStatus = self::STATUS_EXECUTE;
                } else if ($action == self::ACTION_CANCEL) {
                    $nextStatus = self::STATUS_CANCEL;
                }
                break;
            case self::STATUS_EXECUTE:
                if ($action == self::ACTION_FINISH) {
                    $nextStatus = self::STATUS_FINISH;
                } else if ($action == self::ACTION_REFUSE) {
                    $nextStatus = self::STATUS_FAIL;
                }
        }
        return $nextStatus;
    }

}

?>
