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

$client = new Client([
    'base_uri' => 'https://geocode-maps.yandex.ru/',
]);

$query_template = [
    'apikey'  => 'e666f398-c983-4bde-8f14-e3fec900592a',
    'geocode' => '',
    'format'  => 'json',
    'results' => 1
];

$cities = [
    'Абакан',
    'Анадырь',
    'Архангельск',
    'Астрахань',
    'Барнаул',
    'Белгород',
    'Биробиджан',
    'Благовещенск',
    'Брянск',
    'Великий Новгород',
    'Владивосток',
    'Владикавказ',
    'Владимир',
    'Волгоград',
    'Вологда',
    'Воронеж',
    'Горно-Алтайск',
    'Грозный',
    'Екатеринбург',
    'Иваново',
    'Ижевск',
    'Иркутск',
    'Йошкар-Ола',
    'Казань',
    'Калининград',
    'Калуга',
    'Кемерово',
    'Киров',
    'Кострома',
    'Красногорск',
    'Краснодар',
    'Красноярск',
    'Курган',
    'Курск',
    'Кызыл',
    'Липецк',
    'Магадан',
    'Магас',
    'Майкоп',
    'Махачкала',
    'Москва',
    'Мурманск',
    'Нальчик',
    'Нарьян-Мар',
    'Нижний Новгород',
    'Новосибирск',
    'Омск',
    'Орёл',
    'Оренбург',
    'Пенза',
    'Пермь',
    'Петрозаводск',
    'Петропавловск-Камчатский',
    'Псков',
    'Ростов-на-Дону',
    'Рязань',
    'Салехард',
    'Самара',
    'Санкт-Петербург',
    'Саранск',
    'Саратов',
    'Севастополь',
    'Симферополь',
    'Смоленск',
    'Ставрополь',
    'Сыктывкар',
    'Тамбов',
    'Тверь',
    'Томск',
    'Тула',
    'Тюмень',
    'Улан-Удэ',
    'Ульяновск',
    'Уфа',
    'Хабаровск',
    'Ханты-Мансийск',
    'Чебоксары',
    'Челябинск',
    'Черкесск',
    'Чита',
    'Элиста',
    'Южно-Сахалинск',
    'Якутск',
    'Ярославль'
];

echo "\nid,name,lat,long\n";

$city_id = 1;

foreach ($cities as $city_name) {

    $query = $query_template;

    $query['geocode'] = $city_name;

    $response = $client->request('GET', '1.x', ['query' => $query]);

    $content = $response->getBody()->getContents();
    
    $response_data = json_decode($content, true);

    $city_long = '';
    $city_lat = '';
    if (isset($response_data['response']['GeoObjectCollection']['featureMember']['0']['GeoObject']['Point']['pos'])) {
        $city_position = explode(' ', $response_data['response']['GeoObjectCollection']['featureMember']['0']['GeoObject']['Point']['pos']);
        if (isset($city_position[0]) && isset($city_position[1])) {
            $city_long = $city_position[0];
            $city_lat = $city_position[1];
        }
    }

    echo $city_id.",".$city_name.",".$city_lat.",".$city_long."\n";

    $city_id++;
}

echo "\n";
