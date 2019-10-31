<?php
namespace HtmlAcademy\models;

abstract class Actions {

    abstract public static function getName();
    abstract public static function getInnerName();
    abstract public static function checkAccess();

}
