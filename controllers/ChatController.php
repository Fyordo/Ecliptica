<?php


namespace app\controllers;


use app\models\classes\ChatClass;
use app\models\classes\MessageClass;
use app\models\databases\Messages;
use app\models\User;
use Yii;
use yii\web\Controller;

class ChatController extends Controller
{
    function actionIndex(){
        $session = Yii::$app->session;

        return $this->render('index', [
            'user' => $session["user"],
            'chats' => ChatClass::GetChatsList($session["user"]->id)
        ]);
    }

    function actionSelect($link = null){

        $messages = MessageClass::FindMessagesFromChat($link);
        /*
        return $this->render('select', [
            'chat' => ChatClass::FindChatByLink($link, User::IsUser($link)),
            'messages' => $messages
        ]);
        */
        $session = Yii::$app->session;
        $_COOKIE["login"] = $session["user"]->username;

        //$this->redirect("http://localhost:3000");

        return $this->render('select', [
            'chat' => ChatClass::FindChatByLink($link, User::IsUser($link)),
            'messages' => $messages
        ]);


    }
}