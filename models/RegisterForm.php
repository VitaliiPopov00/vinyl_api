<?php

namespace app\models;

use yii\helpers\VarDumper;
use Yii;
use yii\base\Model;

class RegisterForm extends Model
{
    public $fio;
    public $login;
    public $email;
    public $phone;
    public $password;
    public $password_repeat;
    public $rule;

    public function rules()
    {
        return [

            [['fio', 'login', 'email', 'phone', 'password', 'password_repeat'], 'required'],
            [['login', 'password', 'password_repeat', 'fio', 'email'], 'string', 'max' => 255],
            [['email'], 'email'],
            [['rule'], 'compare', 'compareValue' => 1, 'message' => 'Вы согласны на обработку персональных данных'],
            [['fio'], 'match', 'pattern' => '/^[а-яА-ЯЁё\s\-]+$/u', 'message' => 'Непрвильный формат фио'],
            [['login'], 'match', 'pattern' => '/^[a-zA-Z]+$/', 'message' => 'Непрвильный формат логин'],
            [['phone'], 'match', 'pattern' => '/^\+7\(\d{3}\)\-\d{3}(\-\d{2}){2}$/', 'message' => 'Неправильный номер телефона'],
            [['password'], 'string', 'min' => 6],
            [['login'], 'unique', 'targetClass' => User::class],
            ['password_repeat', 'compare', 'compareAttribute' => 'password'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'fio' => 'Фио',
            'login' => 'Логин',
            'email' => 'Email',
            'phone' => 'Телефон',
            'password' => 'Пароль',
            'password_repeat' => 'Повтор пароля',
            'rule' => 'Согласие на обработку персональных данных',
        ];
    }

    public function register()
    {
        if ($this->validate()) {

            $user = new User();
            $user->attributes = $this->attributes;
            $user->password = Yii::$app->security->generatePasswordHash($this->password);
            $user->auth_key = Yii::$app->security->generateRandomString();
            $user->role_id = Role::getRoleId('user');


            if (!$user->save()) {
                VarDumper::dump($this->errors, 10, true);
                //$user = null;
            }
        } else {
            VarDumper::dump($this->errors, 10, true);
        }
        return $user ?? false;
    }
}
