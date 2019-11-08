<?php
namespace HtmlAcademy\models;

class AvailableActions {

    protected $actions;

    public function __construct() {
        $this->actions = [
            ActionAccept::getName() => 'Принять',
            ActionCancel::getName() => 'Отменить',
            ActionComplete::getName() => 'Завершить',
            ActionReject::getName() => 'Отказаться'
        ];
    }

    public function getAll() {
        return $this->$actions;
    }

}
