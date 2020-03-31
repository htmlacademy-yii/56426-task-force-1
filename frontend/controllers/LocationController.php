<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use GuzzleHttp\Client;

class LocationController extends Controller
{
    public function actionIndex()
    {
        if (Yii::$app->request->getIsGet()) {

            $client = new Client([
                'base_uri' => 'https://geocode-maps.yandex.ru/',
            ]);
    
            $query = [
                'apikey' => Yii::$app->params['apiKey'],
                'geocode' => Yii::$app->request->get()['query'],
                'format' => 'json',
                'results' => 5
            ];
    
            $response = $client->request('GET', '1.x', ['query' => $query]);

            $content = $response->getBody()->getContents();

            $response_data = json_decode($content, true);

            $data = [];
            foreach ($response_data['response']['GeoObjectCollection']['featureMember'] as $item) {
                $data[] = ['name' => $item['GeoObject']['metaDataProperty']['GeocoderMetaData']['text']];
            }

            return json_encode($data, JSON_UNESCAPED_UNICODE);
        }
    }
}
