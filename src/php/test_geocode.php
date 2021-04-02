<?php
declare(strict_types=1);

ini_set('display_errors', 'On');
error_reporting(E_ALL);

defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

require __DIR__ . '/../../vendor/autoload.php';
require __DIR__ . '/../../vendor/yiisoft/yii2/Yii.php';
require __DIR__ . '/../../common/config/bootstrap.php';
require __DIR__ . '/../../frontend/config/bootstrap.php';

$config = yii\helpers\ArrayHelper::merge(
    require __DIR__ . '/../../common/config/main.php',
    require __DIR__ . '/../../common/config/main-local.php',
    require __DIR__ . '/../../frontend/config/main.php',
    require __DIR__ . '/../../frontend/config/main-local.php'
);

$app = new yii\web\Application($config);

use GuzzleHttp\Client;
use frontend\models\City;

// Geocode query

$client = new Client([
    'base_uri' => 'https://geocode-maps.yandex.ru/',
]);

$query = [
    'apikey'  => 'e666f398-c983-4bde-8f14-e3fec900592a',
//    'geocode' => 'екатеринбург 8 марта 197',
    'geocode' => 'paris',
    'format'  => 'json',
    'results' => 1
];

$response = $client->request('GET', '1.x', ['query' => $query]);

$content = $response->getBody()->getContents();

$response_data = json_decode($content, true);

// Print responsed data

echo "\nAddress components\n\n";

$task_city_name = null;
if (isset($response_data['response']['GeoObjectCollection']['featureMember']['0']['GeoObject']['metaDataProperty']['GeocoderMetaData']['Address']['Components'])) {
    $address_components = $response_data['response']['GeoObjectCollection']['featureMember']['0']['GeoObject']['metaDataProperty']['GeocoderMetaData']['Address']['Components'];
    foreach ($address_components as $address_item) {
        echo "\t'".$address_item['kind']."' => '".$address_item['name']."'\n";
        if ($address_item['kind'] === 'locality') {
            $task_city_name = $address_item['name'];
        }
    }
}

echo "\nDatabase\n\n";

if (!is_null($task_city_name)) {
    $task_city = City::findOne(['name' => $task_city_name]);
    if (!is_null($task_city)) {
        echo "\t'".$task_city->id."' => '".$task_city->name."'\n";
    } else {
        echo "\tCity '".$task_city_name."' not fount in database\n";
    }
}

echo "\nAddress formatted\n\n";

$task_address = null;
if (isset($response_data['response']['GeoObjectCollection']['featureMember']['0']['GeoObject']['metaDataProperty']['GeocoderMetaData']['Address']['formatted'])) {
    $task_address = $response_data['response']['GeoObjectCollection']['featureMember']['0']['GeoObject']['metaDataProperty']['GeocoderMetaData']['Address']['formatted'];
}

echo "\t'".$task_address."'\n";

echo "\nAddress position\n\n";

$task_long = null;
$task_lat = null;
if (isset($response_data['response']['GeoObjectCollection']['featureMember']['0']['GeoObject']['Point']['pos'])) {
    $task_position = explode(' ', $response_data['response']['GeoObjectCollection']['featureMember']['0']['GeoObject']['Point']['pos']);
    if (isset($task_position[0]) && isset($task_position[1])) {
        $task_long = $task_position[0];
        $task_lat = $task_position[1];
    }
}

echo "\tLong: ".$task_long."\n";
echo "\tLat:  ".$task_lat."\n";

echo "\n";
