<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use GuzzleHttp\Client;
use HtmlAcademy\Models\TaskStatus;

class TaskCreateForm extends Model
{
    public $name;
    public $description;
    public $category;
    public $address;
    public $budget;
    public $expire;

    public function attributeLabels()
    {
        return [
            'name' => 'Мне нужно',
            'description' => 'Подробности задания',
            'category' => 'Категория',
            'address' => 'Локация',
            'budget' => 'Бюджет',
            'expire' => 'Срок исполнения'
        ];
    }

    public function rules()
    {
        return [
            [['name', 'description', 'category', 'address', 'budget', 'expire'], 'safe'],
            [['name', 'description', 'category', 'budget', 'expire'], 'required'],
            [['name', 'description', 'address'], 'string'],
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
        $task->address = $this->address;
        $task->budget = $this->budget;
        $task->expire = $this->expire;

        $address_hash = md5($this->address);
        $key_long = 'location:'.$address_hash.':long';
        $key_lat = 'location:'.$address_hash.':lat';

        $value_long = Yii::$app->redis->get($key_long);
        $value_lat = Yii::$app->redis->get($key_lat);

        if (!is_null($value_long) && !is_null($value_lat)) {

            $task->long = $value_long;
            $task->lat = $value_lat;

        } else {

            $client = new Client([
                'base_uri' => 'https://geocode-maps.yandex.ru/',
            ]);

            $query = [
                'apikey' => Yii::$app->params['apiKey'],
                'geocode' => $this->address,
                'format' => 'json',
                'results' => 1
            ];

            $response = $client->request('GET', '1.x', ['query' => $query]);
            $content = $response->getBody()->getContents();
            $response_data = json_decode($content, true);

            if (isset($response_data['response']['GeoObjectCollection']['featureMember']['0']['GeoObject']['Point']['pos'])) {
                $position = explode(' ', $response_data['response']['GeoObjectCollection']['featureMember']['0']['GeoObject']['Point']['pos']);
            }

            if (isset($position[0]) && isset($position[1])) {
                $task->long = $position[0];
                $task->lat = $position[1];

                Yii::$app->redis->executeCommand('set', [$key_long, $task->long, 'ex', '86400']);
                Yii::$app->redis->executeCommand('set', [$key_lat, $task->lat, 'ex', '86400']);
            }
        }

        return $task->save();
    }
}
