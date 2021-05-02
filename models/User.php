<?php

namespace app\models;

use app\models\users\Users;
use Yii;

class User extends \yii\base\BaseObject implements \yii\web\IdentityInterface
{
    public $id;
    public $username;
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
                'password' => $UserFromDB->attributes["password"],
                'status' => $UserFromDB->attributes["status"]
            ];

            Yii::$app->session->set("user", $user);

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
    }

    /**
     * Finds user by username
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
                'id' => $UserFromDB["id"],
                'username' => $UserFromDB["name"],
                'password' => $UserFromDB["password"],
                'status' => $UserFromDB->attributes["status"]
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

