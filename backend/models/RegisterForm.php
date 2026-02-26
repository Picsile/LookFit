<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class RegisterForm extends Model
{
    public $login;
    public $username;
    public $email;
    public $password;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['login', 'username', 'email', 'password'], 'required'],

            ['login', 'unique', 'targetClass' => User::class],

            ['email', 'unique', 'targetClass' => User::class],

            ['email', 'email'],
        ];
    }

    public function register(): User | false
    {
        if ($this->validate()) {
            $user = new User();
            $user->load($this->attributes, '');
            $user->password = Yii::$app->security->generatePasswordHash($user->password);
            $user->auth_key = Yii::$app->security->generateRandomString();
            $user->save();
        }
        return $user ?? false;
    }
}
