<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\db\Exception;
use GuzzleHttp\Client;
use HtmlAcademy\Models\TaskStatus;

class TaskCreateForm extends Model
{
    public $name;
    public $description;
    public $category;
    public $location;
    public $budget;
    public $expire;

    public function attributeLabels()
    {
        return [
            'name' => 'Мне нужно',
            'description' => 'Подробности задания',
            'category' => 'Категория',
            'location' => 'Локация',
            'budget' => 'Бюджет',
            'expire' => 'Срок исполнения'
        ];
    }

    public function rules()
    {
        return [
            [['name', 'description', 'category', 'location', 'budget', 'expire'], 'safe'],
            [['name', 'description', 'category', 'budget', 'expire'], 'required'],
            [['name', 'description', 'location'], 'string'],
            [['category'], 'exist', 'targetClass' => Category::className(), 'targetAttribute' => ['category' => 'id']],
            [['budget'], 'integer', 'min' => 1],
            [['expire'], 'date', 'format' => 'php:Y-m-d']
        ];
    }

    public function save()
    {
        $task = new Task();

        $task->customer_id = Yii::$app->user->getId();
        $task->status = TaskStatus::NEW_TASK;

        $task->name = $this->name;
        $task->description = $this->description;
        $task->category_id = $this->category;
        //$task->address = $this->location;
        $task->budget = $this->budget;
        $task->expire = $this->expire;

        $task->city_id = null;
        $task->address = null;
        $task->long = null;
        $task->lat = null;

        $key_city = null;
        $key_address = null;
        $key_long = null;
        $key_lat = null;

        if (!empty($this->location)) {
            $address_hash = md5($this->location);
            $key_city = 'location:'.$address_hash.':city';
            $key_address = 'location:'.$address_hash.':address';
            $key_long = 'location:'.$address_hash.':long';
            $key_lat = 'location:'.$address_hash.':lat';
            try {
                $task->city_id = Yii::$app->redis->get($key_city);
                $task->address = Yii::$app->redis->get($key_address);
                $task->long = Yii::$app->redis->get($key_long);
                $task->lat = Yii::$app->redis->get($key_lat);
            } catch (Exception $e) {
                Yii::warning("Redis не работает");
            }
        }

        if (!empty($this->location) && (is_null($task->address) || is_null($task->long) || is_null($task->lat))) {

            $client = new Client([
                'base_uri' => 'https://geocode-maps.yandex.ru/',
            ]);

            $query = [
                'apikey' => Yii::$app->params['apiKey'],
                'geocode' => $this->location,
                'format' => 'json',
                'results' => 1
            ];

            $response = $client->request('GET', '1.x', ['query' => $query]);
            $content = $response->getBody()->getContents();
            $response_data = json_decode($content, true);

            $task_city_name = null;
            if (isset($response_data['response']['GeoObjectCollection']['featureMember']['0']['GeoObject']['metaDataProperty']['GeocoderMetaData']['Address']['Componenets'])) {
                $address_components = explode(' ', $response_data['response']['GeoObjectCollection']['featureMember']['0']['GeoObject']['metaDataProperty']['GeocoderMetaData']['Address']['Componenets']);
                foreach ($address_components as $address_item) {
                    if ($address_item['kind'] === 'locality') {
                        $task_city_name = $address_item['name'];
                    }
                }
            }

            $task_city_id = null;
            if (!is_null($task_city_name)) {
                $task_city = City::findOne(['name' => $task_city_name]);
                if (!is_null($task_city)) {
                    $task_city_id = $task_city->id;
                }
            }

            if (isset($response_data['response']['GeoObjectCollection']['featureMember']['0']['GeoObject']['metaDataProperty']['GeocoderMetaData']['Address']['formatted'])) {
                $task_address = explode(' ', $response_data['response']['GeoObjectCollection']['featureMember']['0']['GeoObject']['metaDataProperty']['GeocoderMetaData']['Address']['formatted']);
            }

            if (isset($response_data['response']['GeoObjectCollection']['featureMember']['0']['GeoObject']['Point']['pos'])) {
                $task_position = explode(' ', $response_data['response']['GeoObjectCollection']['featureMember']['0']['GeoObject']['Point']['pos']);
            }

            if (isset($task_city_id) && isset($task_address) && isset($task_position[0]) && isset($task_position[1])) {
                $task->city_id = $task_city_id;
                $task->address = $task_address;
                $task->long = $task_position[0];
                $task->lat = $task_position[1];
                try {
                    Yii::$app->redis->executeCommand('set', [$key_city, $task->city_id, 'ex', '86400']);
                    Yii::$app->redis->executeCommand('set', [$key_address, $task->address, 'ex', '86400']);
                    Yii::$app->redis->executeCommand('set', [$key_long, $task->long, 'ex', '86400']);
                    Yii::$app->redis->executeCommand('set', [$key_lat, $task->lat, 'ex', '86400']);
                } catch (Exception $e) {
                    Yii::warning("Redis не работает");
                }
            }
        }

        return $task->save();
    }
}
