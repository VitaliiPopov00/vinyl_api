<?php

namespace app\models;

use yii\db\ActiveRecord;

class User extends ActiveRecord implements \yii\web\IdentityInterface
{
    public $password_repeat;

    const SCENARIO_LOGIN = 'login';
    const SCENARIO_REGISTER = 'register';

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'update_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['update_at'],
                ],
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['login', 'password', 'email', 'role_id'], 'required'],

            [['password_repeat'], 'compare', 'compareAttribute' => 'password', 'on' => static::SCENARIO_REGISTER],
            [['password_repeat'], 'required', 'on' => static::SCENARIO_REGISTER],
            [['login', 'email'], 'unique', 'on' => static::SCENARIO_LOGIN],
            [['password'], 'match', 'pattern' => '/^[a-zA-Z\d]{6,}$/'],

            [['created_at', 'updated_at'], 'safe'],
            [['role_id'], 'integer'],
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
    public function getSales()
    {
        return $this->hasMany(Sale::class, ['user_id' => 'id']);
    }

    public function setPasswordHash()
    {
        return $this->password = Yii::$app->security->generatePasswordHash($this->password);
    }

    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password);
    }

    public static function tableName()
    {
        return 'user';
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

    public function validateAuthKey($authKey)
    {
        return $this->token === $token;
    }
}
