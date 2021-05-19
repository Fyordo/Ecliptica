<?php

namespace app\models;

use app\models\databases\Chats;
use app\models\databases\Users;
use Yii;

class User extends \yii\base\BaseObject implements \yii\web\IdentityInterface
{
    public $id;
    public $username;
    public $link;
    public $password;
    public $status;

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        $UserFromDB = Users::findOne($id);

        if (isset($UserFromDB)){

            $user = [
                'id' => $UserFromDB->attributes["id"],
                'username' => $UserFromDB->attributes["name"],
                'link' => $UserFromDB->attributes["link"],
                'password' => $UserFromDB->attributes["password"],
                'status' => $UserFromDB->attributes["status"]
            ];

            return new static($user);

        }
        return null;
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return null;
    } // Не используется

    /**
     * Находит пользователя по имени
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {

        $UserFromDB = Users::find()->where([
            "name" => $username
        ])->one();

        if (isset($UserFromDB)){

            $user = [
                'id' => $UserFromDB->attributes["id"],
                'username' => $UserFromDB->attributes["name"],
                'link' => $UserFromDB->attributes["link"],
                'password' => $UserFromDB->attributes["password"],
                'status' => $UserFromDB->attributes["status"]
            ];

            return new static($user);

        }
        return null;
    }

    /**
     * Находит пользователя по ссылке
     *
     * @param string $link
     * @return static|null
     */
    public static function findByLink($link)
    {

        $UserFromDB = Users::find()->where([
            "link" => $link
        ])->one();

        if (isset($UserFromDB)){

            $user = [
                'id' => $UserFromDB->attributes["id"],
                'username' => $UserFromDB->attributes["name"],
                'link' => $UserFromDB->attributes["link"],
                'password' => $UserFromDB->attributes["password"],
                'status' => $UserFromDB->attributes["status"]
            ];

            return new static($user);

        }
        return null;
    }

    /**
     * Возращает 1, если пользователь, и 0, если чат
     *
     * @param string $link
     * @return int
     */
    public static function IsUser($link) : int
    {

        $UserFromDB = Users::find()->where([
            "link" => $link
        ])->one();

        return isset($UserFromDB) ? 1 : 0;
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return null;
    } // Не используется

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return true;
    } // Не используется

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $this->password === $password;
    }

    public static function GetLastID(){
        $lastUser = Users::find()->orderBy(['id' => SORT_DESC])->one();
        return $lastUser->attributes["id"];
    }
}

