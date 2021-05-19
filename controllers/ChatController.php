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
        return $this->render('index', [
            'chats' => ChatClass::GetChatsList(Yii::$app->user->id)
        ]);
    }

    function actionSelect($link = null){

        $messages = MessageClass::FindMessagesFromChat($link);

        return $this->render('select', [
            'chat' => ChatClass::FindChatByLink($link, User::IsUser($link)),
            'messages' => $messages
        ]);


    }

    function actionSend(){
        return $this->render('send');
    }

    function actionFindchat(){
        return $this->render('findchat');
    }

    function actionCreate(){
        return $this->render('create');
    }

    function actionCreatechat(){
        return $this->render('createchat');
    }

    function actionExitchat(){
        ChatClass::RemoveUserFromChat($_GET["link"]);
        return $this->redirect('/');
    }
}