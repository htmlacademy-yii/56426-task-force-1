<?php
namespace HtmlAcademy\Tools;

use Yii;
use GuzzleHttp\Client;

class GeoCoder {

    private $location;
    private $geodata;

    public function __construct(string $location = null) {
        $this->location = $location;
        $this->geodata = null;
    }

    public function setLocation(string $location) {
        $this->location = $location;
        $this->geodata = null;
    }

    public function getGeodata() {

        if (is_null($this->geodata)) {
            $this->request();
        }

        return $this->geodata;
    }

    public function getAddress() {

        if (is_null($this->geodata)) {
            $this->request();
        }

        if (isset($this->geodata['response']['GeoObjectCollection']['featureMember']['0']['GeoObject']['metaDataProperty']['GeocoderMetaData']['Address']['formatted'])) {
            return $this->geodata['response']['GeoObjectCollection']['featureMember']['0']['GeoObject']['metaDataProperty']['GeocoderMetaData']['Address']['formatted'];
        }

        return null;
    }

    public function getPosition() {

        if (is_null($this->geodata)) {
            $this->request();
        }

        if (isset($this->geodata['response']['GeoObjectCollection']['featureMember']['0']['GeoObject']['Point']['pos'])) {
            $position = explode(' ', $this->geodata['response']['GeoObjectCollection']['featureMember']['0']['GeoObject']['Point']['pos']);
            if (isset($position[0]) && isset($position[1])) {
                return [
                    'long' => $position[0],
                    'lat' => $position[1]
                ];
            }
        }

        return ['long' => null, 'lat' => null];
    }

    public function getCityName() {

        if (is_null($this->geodata)) {
            $this->request();
        }

        if (isset($this->geodata['response']['GeoObjectCollection']['featureMember']['0']['GeoObject']['metaDataProperty']['GeocoderMetaData']['Address']['Components'])) {
            $address_components = $this->geodata['response']['GeoObjectCollection']['featureMember']['0']['GeoObject']['metaDataProperty']['GeocoderMetaData']['Address']['Components'];

            $address_items = array_column($address_components, 'name', 'kind');

            if (isset($address_items['locality'])) {
                return $address_items['locality'];
            } elseif (isset($address_items['district'])) {
                return $address_items['district'];
            }
        }

        return null;
    }

    private function request() {

        if (is_null($this->location)) {
            return;
        }

        $key_location = 'location:'.md5($this->location);

        try {
            $content = Yii::$app->redis->get($key_location);
        } catch (Exception $e) {
            Yii::warning("Redis не работает");
        }

        if (is_null($content)) {

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

            try {
                Yii::$app->redis->executeCommand('set', [$key_location, $content, 'ex', '86400']);
            } catch (Exception $e) {
                Yii::warning("Redis не работает");
            }
    
        }

        $this->geodata = json_decode($content, true);
    }
}
