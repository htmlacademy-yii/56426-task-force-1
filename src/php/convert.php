<?php
declare(strict_types=1);

ini_set('display_errors', 'On');
error_reporting(E_ALL);

require_once('vendor/autoload.php');

use HtmlAcademy\Tools\Converter;

$sourcePath = 'data/';
$targetPath = 'src/sql/';

// city

$city = new Converter($sourcePath.'cities.csv', $targetPath.'city.sql', 'city');
$cityCount = $city->convert();
printf("city: %d\n", $cityCount);

// skill

$skill = new Converter($sourcePath.'skills.csv', $targetPath.'skill.sql', 'skill');
$skillCount = $skill->convert();
printf("skill: %d\n", $skillCount);

// category

$category = new Converter($sourcePath.'categories.csv', $targetPath.'category.sql', 'category');
$categoryCount = $category->convert();
printf("category: %d\n", $categoryCount);
