<?php

namespace app\controllers;

use app\models\Chat;
use app\models\DbModels\ChatBinds;
use app\models\DbModels\Chats;
use app\models\Forms\AddAdminForm;
use app\models\Forms\ChatCreationForm;
use app\models\Forms\ChatSearchForm;
use app\models\Forms\ExitForm;
use app\models\Message;
use app\models\User;
use Yii;

class ChatController extends \yii\web\Controller
{
    public $enableCsrfValidation = false;

    public function beforeAction($action)
    {
        return parent::beforeAction($action);
    }

    public function actionCreate()
    {
        $model = new ChatCreationForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            self::CreateChat($model->title, $model->link);
            return $this->redirect('/chat');
        }
        else {
            return $this->render('create', ['model' => $model]);
        }
    }

    public function actionIndex()
    {
        $model = new ChatSearchForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            self::AddToChat($model->link, Yii::$app->user->id, 0);
        }

        return $this->render('index', [
            'chats' => self::GetChatsList(Yii::$app->user->id),
            'model' => $model
        ]);
    }

    public function actionSelect($link = null)
    {
        $modelAdmin = new AddAdminForm();

        if ($modelAdmin->load(Yii::$app->request->post()) && $modelAdmin->validate()) {
            self::SetToAdmin($link, User::findByLink($modelAdmin->userLink)->id);
        }

        $messages = MessageController::FindMessagesFromChat($link);

        return $this->render('select', [
            'modelAdmin' => $modelAdmin,
            'chat' => self::FindChatByLink($link),
            'messages' => $messages,
            'isadmin' => self::IsAdmin(Yii::$app->user->id, $link) == 1
        ]);
    }

    // -------------- Вспомогательные действия -----------------

    function actionSend(){
        if ($_POST["user"] != null){
            MessageController::AddMessage($_POST["chat"], $_POST["message"], $_POST["time"], User::findByLink($_POST["user"]));
        }
        else{
            MessageController::AddMessage($_POST["chat"], $_POST["message"], $_POST["time"]);
        }
    }

    public function actionExitchat(){
        self::RemoveUserFromChat($_GET["link"]);
        return $this->redirect('/');
    }

    // -------------- ВСПОМОГАТЕЛЬНЫЕ ФУНКЦИИ ----------------

    /**
     * Найти чат по ссылке
     *
     * @param $link
     * @return Chat|null
     */
    private function FindChatByLink($link): Chat
    {
        $ChatFromDB = Chats::find()->where([
            "link" => $link
        ])->one();

        $chat = [
            'id' => $ChatFromDB->attributes["id"],
            'title' => $ChatFromDB->attributes["title"],
            'link' => $link,
            'status' => 0
        ];
        return new Chat($chat);
    }

    /**
     * Найти все чаты из списка пользователя
     *
     * @param $UserID
     * @return array
     */
    private function GetChatsList($UserID) : array{
        $chatsList = ChatBinds::find()->where(['user_id' => $UserID])->all();
        $chats = [];

        foreach ($chatsList as $CurrChat){
            $chat = self::FindChatByLink($CurrChat->attributes["chat_link"]);

            array_push($chats, $chat);
        }
        return $chats;
    }

    /**
     * Получить последний ID чатов из существующих
     *
     * @return mixed
     */
    private function GetLastID(){
        $lastChat = Chats::find()->orderBy(['id' => SORT_DESC])->one();
        return $lastChat->attributes["id"];
    }

    /**
     * Создаёт чат, проверив ссылку
     *
     * @param $title
     * @param $link
     */
    private function CreateChat($title, $link){
        if (!Chats::find()->where(["link" => $link])->exists()){
            $chat = new Chats();
            $chat->id = self::GetLastID() + 1;
            $chat->title = $title;
            $chat->link = $link;
            $chat->save();

            self::AddToChat($link, \Yii::$app->user->id, 1);

        }
    }

    /**
     * Добавляет чат в списки к пользователю
     *
     * @param $chatlink
     * @param $userID
     * @param $isadmin
     */
    private function AddToChat($chatlink, $userID, $isadmin){
        try{
            $chat1 = new ChatBinds();
            $chat1->user_id = $userID;
            $chat1->chat_link = $chatlink;
            $chat1->isadmin = $isadmin;
            $chat1->save();
        }
        catch (\yii\db\Exception $ex){
            var_dump($ex);
            die();
        }
    }

    /**
     * Дать пользователю права админу в чате
     *
     * @param $chatLink
     * @param $userID
     */
    private function SetToAdmin($chatLink, $userID){
        try{
            $bond = ChatBinds::find()->where([
                'user_id' => $userID,
                'chat_link' => $chatLink
            ])->one();
            $bond->isadmin = 1;
            $bond->update();
        }
        catch (\yii\db\Exception $ex){
            var_dump($ex);
            die();
        }
    }

    /**
     * Убрать чат из списка пользователя + забрать все права
     *
     * @param $link
     * @param null $userID
     */
    private function RemoveUserFromChat($link, $userID = null){
        if ($userID == null) $userID = Yii::$app->user->id;
        try{
            ChatBinds::find()->where(["user_id" => \Yii::$app->user->id, "chat_link" => $link])->one()->delete();
        }
        catch (\yii\db\Exception $ex){
            var_dump($ex);
            die();
        }
    }

    /**
     * Является ли пользователь админом?
     *
     * @param $userID
     * @param $chatLink
     * @return mixed
     */
    private function IsAdmin($userID, $chatLink){
        $chatInfo = ChatBinds::find()->where([
            'user_id' => $userID,
            'chat_link' => $chatLink
        ])->one();
        return $chatInfo->attributes["isadmin"];
    }
}
