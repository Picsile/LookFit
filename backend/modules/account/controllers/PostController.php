<?php

namespace app\modules\account\controllers;

use app\models\Image;
use app\models\Post;
use app\models\PostImage;
use app\models\PostType;
use app\models\UploadForm;
use app\modules\account\search\PostSearch;
use Yii;
use yii\web\Response;
use yii\filters\auth\HttpBearerAuth;
use yii\web\NotFoundHttpException;
use yii\rest\ActiveController;
use yii\web\UploadedFile;

/**
 * PostController implements the CRUD actions for Post model.
 */
class PostController extends ActiveController
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
            'except' => ['options'],
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
     * Lists all Post models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new PostSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Post model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionPublicThing()
    {
        $post = new Post();
        $uploadForm = new UploadForm();

        Yii::$app->response->format = Response::FORMAT_JSON;

        if ($data = Yii::$app->request->post()) {
            // Post
            $post->type_id = 1;
            $post->user_id = Yii::$app->user->id;
            $post->title = $data['title'];
            $post->description = $data['description'];
            $post->status_id = 1;

            // Images
            $images = UploadedFile::getInstancesByName('images');

            foreach ($image as $images) {
                $postImageModel = new PostImage();
                $imageModel = new Image();
                
                
            }

            return ['status' => 'success', '1' => $images];


            // Tags


            return ['status' => 'success', '1' => $post];
        }
        return ['status' => 'error', 'message' => 'Ошибка при получении данных', 'post' => Yii::$app->request->post()];
    }

    /**
     * Displays a single Post model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Post model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Post();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Post model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Post model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Post model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Post the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Post::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
