<?php
declare(strict_types=1);

ini_set('display_errors', 'On');
error_reporting(E_ALL);

require_once('vendor/autoload.php');

use frontend\models\Category;

$category = Category::find()->orderBy('id')->all();
