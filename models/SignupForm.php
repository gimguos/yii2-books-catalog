<?php

namespace app\models;

use yii\base\Model;

/**
 * Модель для формы регистрации.
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;

    /**
     * Правила валидации.
     */
    public function rules()
    {
        return [
            [['username', 'email', 'password'], 'required'],
            ['username', 'string', 'min' => 3, 'max' => 255],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => User::class, 'message' => 'Этот email уже занят.'],
            ['password', 'string', 'min' => 6],
        ];
    }

    /**
     * Лейблы для полей формы.
     */
    public function attributeLabels()
    {
        return [
            'username' => 'Имя пользователя',
            'email' => 'Email',
            'password' => 'Пароль',
        ];
    }

    /**
     * Регистрация пользователя.
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }

        $user = new User();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->setPassword($this->password);
        $user->generateAuthKey();

        return $user->save() ? $user : null;
    }
}