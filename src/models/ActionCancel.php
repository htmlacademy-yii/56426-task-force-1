<?php
namespace HtmlAcademy\models;

class ActionCancel extends Actions {

    public static function getName() {
        return 'Отменить';
    }

    public static function getInnerName() {
        return 'ActionCancel';
    }

    public static function checkAccess() {
        
    }

}
