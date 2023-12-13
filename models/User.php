<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

class User extends ActiveRecord implements \yii\web\IdentityInterface
{
    public $password_repeat;

    const SCENARIO_LOGIN = 'login';
    const SCENARIO_REGISTER = 'register';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['login', 'password'], 'required'],

            [['password'], 'match', 'pattern' => '/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[a-zA-Z\d]{6,}$/', 'on' => static::SCENARIO_REGISTER],
            [['email', 'password_repeat'], 'required', 'on' => static::SCENARIO_REGISTER],
            [['password_repeat'], 'compare', 'compareAttribute' => 'password', 'on' => static::SCENARIO_REGISTER],
            [['login', 'email'], 'unique', 'on' => static::SCENARIO_REGISTER],
            [['email'], 'email', 'on' => static::SCENARIO_REGISTER],

            [['created_at', 'updated_at'], 'safe'],
            [['role_id'], 'safe'],
            [['login', 'password', 'email', 'token'], 'string', 'max' => 255],
            [['role_id'], 'exist', 'skipOnError' => true, 'targetClass' => Role::class, 'targetAttribute' => ['role_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'login' => 'Логин',
            'password' => 'Пароль',
            'email' => 'Почта',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'token' => 'Token',
            'role_id' => 'Role ID',
        ];
    }

    /**
     * Gets query for [[Role]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRole()
    {
        return $this->hasOne(Role::class, ['id' => 'role_id']);
    }

    /**
     * Gets query for [[Sales]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Order::class, ['user_id' => 'id']);
    }

    public function setPasswordHash()
    {
        return $this->password = Yii::$app->security->generatePasswordHash($this->password);
    }

    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password);
    }

    public function setRoleID()
    {
        $this->role_id = Role::getRoleIDByTitle('user');
    }

    public function setToken()
    {
        $this->token = Yii::$app->security->generateRandomString();
    }

    public function register()
    {
        if ($this->validate()) {
            $this->setPasswordHash();
            $this->setRoleID();

            return $this->save(false);
        } else {
            return false;
        }
    }

    public static function getUserInfo($id)
    {
        if (($user = static::findOne($id))) {
            return [
                'status' => true,
                'data' => [
                    'user' => [
                        'id' => $user->id,
                        'login' => $user->login,
                        'email' => $user->email,
                        'created_at' => $user->created_at,
                        'role' => Role::getRole($user->role_id),
                        'orders' => $user->getOrders()->all(),
                    ],
                ],
            ];
        } else {
            return null;
        }
    }

    public static function logout($id)
    {
        if (($user = User::findOne($id))) {
            $user->token = null;

            return $user->save(false);
        } else {
            return null;
        }
    }

    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['token' => $token]);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return $this->token;
    }

    public function validateAuthKey($token)
    {
        return $this->token === $token;
    }
}
