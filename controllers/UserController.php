<?php

namespace app\controllers;

use yii\rest\ActiveController;
use app\models\User;
use Yii;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\Cors;

class UserController extends ActiveController
{
    public $modelClass = '';
    public $enableCsrfValidation = false;

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        // remove authentication filter
        $auth = $behaviors['authenticator'];
        unset($behaviors['authenticator']);

        // add CORS filter
        $behaviors['corsFilter'] = [
            'class' => Cors::class,
            'cors' => [
                'Origin' => [
                    (isset($_SERVER['HTTP_ORIGIN']) ? $_SERVER['HTTP_ORIGIN'] : 'http://' . $_SERVER['REMOTE_ADDR'])
                ],
                'Access-Control-Request-Headers' => ['content-type', 'Authorization'],
                'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'OPTIONS'],
            ],
            'actions' => [
                'login' => [
                    'Access-Control-Allow-Credentials' => true,
                ]
            ],
        ];

        $auth = [
            'class' => HttpBearerAuth::class,
            'except' => ['options', 'register', 'login', 'info'],
        ];

        // re-add authentication filter
        $behaviors['authenticator'] = $auth;

        return $behaviors;
    }

    public function actions()
    {
        $actions = parent::actions();

        unset($actions['delete'], $actions['create'], $actions['index'], $actions['update'], $actions['view']);

        return $actions;
    }

    public function actionRegister()
    {
        $user = new User();
        $user->scenario = User::SCENARIO_REGISTER;

        if ($user->load(Yii::$app->request->post(), '') && $user->validate()) {
            $user->setPasswordHash();
            $user->setRoleID();

            if ($user->save(false)) {
                Yii::$app->response->statusCode = 204;
            } else {
                Yii::$app->response->statusCode = 500;
            }
        } else {
            Yii::$app->response->statusCode = 422;
            return $this->asJson([
                'status' => false,
                'error' => [
                    'code' => 422,
                    'message' => 'Validation failed',
                    'errors' => $user->errors,
                ],
            ]);
        }
    }

    public function actionLogin()
    {
        $user = new User();

        if ($user->load(Yii::$app->request->post(), '') && $user->validate()) {
            $password = $user->password;

            if (($user = User::findOne(['login' => $user->login]))) {
                if ($user->validatePassword($password)) {
                    $user->setToken();

                    if ($user->save(false)) {
                        Yii::$app->response->statusCode = 200;
                        return $this->asJson([
                            'status' => true,
                            'data' => [
                                'token' => $user->token,
                            ],
                        ]);
                    } else {
                        Yii::$app->response->statusCode = 500;
                    }
                } else {
                    Yii::$app->response->statusCode = 422;
                    return $this->asJson([
                        'status' => false,
                        'error' => [
                            'code' => 422,
                            'message' => 'Validation failed',
                            'errors' => [
                                'password' => [
                                    'Пароль введен неверно',
                                ],
                            ],
                        ],
                    ]);
                }
            } else {
                Yii::$app->response->statusCode = 422;
                return $this->asJson([
                    'status' => false,
                    'error' => [
                        'code' => 404,
                        'message' => 'User not found',
                    ],
                ]);
            }
        } else {
            Yii::$app->response->statusCode = 422;
            return $this->asJson([
                'status' => false,
                'error' => [
                    'code' => 422,
                    'message' => 'Validation failed',
                    'errors' => $user->errors,
                ],
            ]);
        }
    }

    public function actionInfo($id)
    {
        if (($user = User::findOne($id))) {
            Yii::$app->response->statusCode = 200;
            return $this->asJson([
                'status' => true,
                'data' => [
                    'user' => [
                        'id' => $user->id,
                        'login' => $user->login,
                        'email' => $user->email,
                        'created_at' => $user->created_at,
                        'role_id' => $user->role_id,
                    ],
                ],
            ]);
        } else {
            Yii::$app->response->statusCode = 404;
            return $this->asJson([
                'status' => false,
                'error' => [
                    'code' => 404,
                    'message' => 'User not found',
                ],
            ]);
        }
    }

    public function actionLogout()
    {
        $user = User::findOne(Yii::$app->user->identity->id);
        $user->token = null;

        if ($user->save(false)) {
            Yii::$app->response->statusCode = 204;
        } else {
            Yii::$app->response->statusCode = 500;
        }
    }
}