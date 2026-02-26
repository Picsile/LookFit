<?php

namespace app\controllers;

use Yii;
use yii\web\Response;
use app\models\LoginForm;
use app\models\RegisterForm;
use app\models\User;
use yii\filters\auth\HttpBearerAuth;
use yii\rest\ActiveController;

class SiteController extends ActiveController
{
    public $modelClass = '';
    public $enableCsrfValidation = false;

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        unset($behaviors['authenticator']);

        // CORS filter
        $behaviors['corsFilter'] = [
            'class' => \yii\filters\Cors::class,
            'cors' => [
                'Origin' => [isset($_SERVER['HTTP_ORIGIN']) ? $_SERVER['HTTP_ORIGIN'] : 'http ://' . $_SERVER['REMOTE_ADDR']],
                'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
                'Access-Control-Request-Headers' => ['*'],
                'Access-Control-Allow-Credentials' => false,
                'Access-Control-Allow-Origin' => ['*'],
            ],
        ];

        $auth = [
            'class' => HttpBearerAuth::class,
            'except' => ['options', "login", "register"],
        ];
        // Re-add authentication filter
        $behaviors['authenticator'] = $auth;
        // Avoid authentication on CORS-pre-flight requests (HTTP OPTIONS method)

        return $behaviors;
    }

    public function actions()
    {
        $actions = parent::actions();

        // Disable the "delete" and "create" actions
        unset($actions['delete'], $actions['create'], $actions['view']);

        // Customize the data provider preparation with the "prepareDataProvider()" method
        // $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];

        return $actions;
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionRegister()
    {
        $model = new RegisterForm();

        Yii::$app->response->format = Response::FORMAT_JSON;

        if ($model->load(Yii::$app->request->post(), '')) {

            if ($user = $model->register()) {
                Yii::$app->user->login($user, 3600 * 24 * 30);
                return ['status' => 'success', 'token' => $user->auth_key];
            } else {
                return ['status' => 'error', 'message' => 'Ошибка при сохранении пользователя', 'errors' => $model->errors];
            }
        }
        return ['status' => 'error', 'message' => 'Ошибка при получении данных', 'post' => Yii::$app->request->getBodyParams()];
    }

    public function actionLogin()
    {
        $model = new LoginForm();

        Yii::$app->response->format = Response::FORMAT_JSON;

        if ($model->load(Yii::$app->request->post(), '')) {

            if ($model->login()) {
                $user = Yii::$app->user->identity;
                return ['status' => 'success', 'token' => $user->auth_key];
            } else {
                Yii::$app->response->statusCode = 404;
                return ['status' => 'error', 'message' =>  "User not found"];
            }
        }

        return ['status' => 'error', 'message' => 'Error get data', 'post' => Yii::$app->request->post()];
    }

    public function actionFindByToken()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        if ($user_id = Yii::$app->user->id) {
            return ['status' => 'success', 'user' => User::findOne(['id' => $user_id])];
        } else {
            return ['status' => 'error', 'message' => 'Undefind token'];
        };
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return ['status' => 'success'];
    }
}
