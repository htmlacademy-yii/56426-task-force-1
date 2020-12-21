<?php

namespace frontend\controllers;

use Yii;
use GuzzleHttp\Client;
use yii\web\Controller;
use frontend\models\UserLoginForm;

class LandingController extends UnsecuredController
{
    public $layout = 'landing';
    public $model;

    public function actionIndex()
    {
        $this->model = new UserLoginForm();

        return $this->render('index');
    }

    public function actionAuth()
    {
        $this->model = new UserLoginForm();

        if (Yii::$app->request->getIsGet()) {

            $client = new Client([
                'base_uri' => 'https://oauth.vk.com/',
            ]);
    
            $query = [
                'client_id' => '7702913',
                'client_secret' => 'SEjrzWmaK5Akm40iuXUj',
                'redirect_uri' => 'http://taskforce.pc1/auth',
                'code' => Yii::$app->request->get()['code']
            ];
    
            $response = $client->request('GET', 'access_token', ['query' => $query]);
            $content = $response->getBody()->getContents();
            $response_data = json_decode($content, true);

            if (isset($response_data['email'])) {
                $this->model->email = $response_data['email'];
                if ($user = $this->model->getUser()) {
                    Yii::$app->user->login($user);
                    return $this->redirect('/tasks');
                } else {
                    return $this->redirect('/signup?email='.$response_data['email']);
                }
            }

        }

        return $this->goHome();
    }

    public function actionLogin()
    {
        $this->model = new UserLoginForm();

        if (Yii::$app->request->getIsPost()) {
            $this->model->load(Yii::$app->request->post());
            if ($this->model->validate()) {
                Yii::$app->user->login($this->model->getUser());
                return $this->redirect('/tasks');
            }
        }

        return $this->goHome();
    }
}
