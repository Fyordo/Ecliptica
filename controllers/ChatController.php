<?php


namespace app\controllers;


use app\models\classes\ChatClass;
use app\models\classes\MessageClass;
use app\models\databases\Messages;
use app\models\databases\UserChats;
use app\models\User;
use Yii;
use yii\web\Controller;

/**
 * Контроллер CHAT
 * @package app\controllers
 */
class ChatController extends Controller
{
    /**
     * Главная страница выбора чатов
     *
     * @return string
     */
    function actionIndex(){
        return $this->render('index', [
            'chats' => ChatClass::GetChatsList(Yii::$app->user->id)
        ]);
    }

    /**
     * Страница выбранного чата
     *
     * @param null $link
     * @return string
     */
    function actionSelect($link = null){

        $messages = MessageClass::FindMessagesFromChat($link);

        return $this->render('select', [
            'chat' => ChatClass::FindChatByLink($link),
            'messages' => $messages,
            'isadmin' => ChatClass::IsAdmin(Yii::$app->user->id, $link) == 1
        ]);


    }

    // Вспомогательные страницы

    function actionSend(){
        return $this->render('send');
    }

    function actionFindchat(){
        return $this->render('findchat');
    }

    function actionAddadmin(){
        return $this->render('addadmin');
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