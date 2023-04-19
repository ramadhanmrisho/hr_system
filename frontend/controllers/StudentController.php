<?php

namespace frontend\controllers;

use Yii;
use common\models\Student;
use common\models\search\StudentSearch;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * StudentController implements the CRUD actions for Student model.
 */
class StudentController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Student models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new StudentSearch();
        $dataProvider =new ActiveDataProvider(['query'=>Student::find()->where(['id'=>Yii::$app->user->identity->user_id])]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Student model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Student model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Student();

        if ($model->load(Yii::$app->request->post())) {
            $model->created_by=Yii::$app->user->identity->getId();
            if( $model->save()){
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Student model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Student model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Student model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Student the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Student::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }



    public function actionUploadPhoto($id){
        $model = $this->findModel($id);
        $model->passport_size = UploadedFile::getInstance($model, 'passport_size');
        $model->created_by=Yii::$app->user->identity->getId();
        if( !is_null($model->passport_size) && file_exists('/'.$model->passport_size)){
            unlink('/'.$model->passport_size);
            $file = $this->upload($model);
            if($model->save() && $model->passport_size->saveAs($file))
            {
                return $this->redirect(['view', 'id' => $id]);
            }
            else
            {
                var_dump($model->getErrors());
                die();
            }
        }

        else{


            $model->passport_size = Uploadedfile::getInstance($model, 'passport_size');

            if (!empty($model->passport_size)){
                $saved=$model->passport_size->saveAs('student_photo/' . $model->passport_size->baseName. '.' . $model->passport_size->extension);
            }

            if($model->save(false) && $saved)
            {
                return $this->redirect(['view', 'id' => $id]);
            }
            else
            {
                var_dump($model->getErrors());
                die();
            }
        }
    }

    private function upload($model){
        $fileName = $model->fname.'_'.$model->registration_number.'_' .Yii::$app->user->identity->id.'-' . date('Ymdhis');
        $model->passport_size = $fileName . '.' . $model->passport_size->extension;
        return $model->passport_size;
    }

}
