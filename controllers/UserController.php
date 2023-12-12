<?php

namespace app\controllers;

use yii\rest\ActiveController;
use app\models\User;
use app\models\Role;

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
        var_dump('test');die;
        $user = new User();
        $user->scenario = User::SCENARIO_REGISTER;

        if ($user->load(Yii::$app->request->post(), '') && $user->validate()) {
            $user->setPasswordHash();
            $user->role_id = Role::getRoleIDByTitle('user');

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
    
}