<?php


namespace app\controllers;


use Yii;
use yii\web\Controller;

class ChatController extends Controller
{
    function actionIndex(){
        $session = Yii::$app->session;

        return $this->render('index', [
            'user' => $session["user"]
        ]);
    }

    function actionSelect(string $id = null){
        return $this->render('select', [
            'id' => $id
        ]);
    }
}