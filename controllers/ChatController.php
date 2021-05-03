<?php


namespace app\controllers;


use app\models\Chat;
use app\models\User;
use Yii;
use yii\web\Controller;

class ChatController extends Controller
{
    function actionIndex(){
        $session = Yii::$app->session;

        return $this->render('index', [
            'user' => $session["user"],
            'chats' => Chat::GetChatsList($session["user"]->id)
        ]);
    }

    function actionSelect(string $link = null){

        return $this->render('select', [
            'chat' => Chat::FindChatByLink($link, User::IsUser($link))
        ]);
    }
}