<?php
namespace HtmlAcademy\models;

class AvailableActions {

    protected static $actions = [
        ActionAccept::class => 'Принять',
        ActionCancel::class => 'Отменить',
        ActionComplete::class => 'Завершить',
        ActionReject::class => 'Отказаться'
    ];

    public function getAll() {
        return $this->$actions;
    }

}
