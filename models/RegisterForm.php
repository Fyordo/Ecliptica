<?php


namespace app\models;

use app\models\databases\Users;
use Yii;
use yii\base\Model;

class RegisterForm  extends Model
{
    public $username;
    public $link;
    public $password;
    private $_user = false;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'password', 'link'], 'required'],
            // password is validated by validatePassword()
            ['link', 'validateLink'],
        ];
    }

    /**
     * Validates the link.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validateLink($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->TryGetUser();

            if ($user !== null) {
                $this->addError($attribute, 'Такой пользователь уже есть!');
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     * @return bool whether the user is logged in successfully
     */
    public function register()
    {
        if ($this->validate()) {
            $user = new Users();
            $user->id = User::GetLastID() + 1;
            $user->name = $this->username;
            $user->link = $this->link;
            $user->password = $this->password;
            $user->status = 1;
            $user->save();
            return Yii::$app->user->login($this->getUser(), 3600*24*30);
        }
        return false;
    }

    private function getUser()
    {
        return User::findByUsername($this->username);
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function TryGetUser()
    {
        if ($this->_user === false) {
            return User::findByLink($this->link);
        }

        return null;
    }
}