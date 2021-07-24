<?php

namespace app\models;

use app\models\DbModels\Users;

class User extends \yii\base\BaseObject implements \yii\web\IdentityInterface
{
    public $id;
    public $username;
    public $link;
    public $password;

    public $authKey;
    public $accessToken;


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
            ];

            return new static($user);

        }
        return null;
    }

    /**
     * Не используется
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return null;
    }

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
            ];

            return new static($user);

        }
        return null;
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
        return $this->authKey;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

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
}
