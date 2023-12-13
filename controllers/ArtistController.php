<?php

namespace app\controllers;

use app\models\Artist;
use Yii;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\Cors;
use yii\rest\ActiveController;

class ArtistController extends ActiveController
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
            'except' => ['options', 'info', 'detail'],
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

    public function actionInfo()
    {
        Yii::$app->response->statusCode = 200;
        
        return $this->asJson([
            'status' => true,
            'data' => [
                'artists' => Artist::find()->all(),
            ],
        ]);
    }

    public function actionDetail($id)
    {
        if (($artistInfo = Artist::getArtistInfo($id))) {
            Yii::$app->response->statusCode = 200;

            return $this->asJson([
                'status' => true,
                'data' => [
                    'artist' => $artistInfo,
                ]
            ]);
        } else {
            Yii::$app->response->statusCode = 404;
            
            return $this->asJson([
                'status' => false,
                'error' => [
                    'code' => 404,
                    'message' => 'Artist not found',
                ],
            ]);
        }
    }
}