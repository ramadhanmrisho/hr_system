<?php

namespace backend\controllers;

use common\models\ExamResult;
use common\models\Module;
use Yii;
use common\models\Semester;
use common\models\search\SemesterSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SemesterController implements the CRUD actions for Semester model.
 */
class SemesterController extends Controller
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
     * Lists all Semester models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SemesterSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Semester model.
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
     * Creates a new Semester model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Semester();

        if ($model->load(Yii::$app->request->post()) ) {

            $active_semester=Semester::find()->where(['status'=>'Active'])->exists();

            if ($active_semester && $model->status=='Active'){
                Yii::$app->session->setFlash('getDanger','<span class="fa fa-warning"> Active semester already exists!</span>');
                return $this->redirect(['index']);
            }

            if ($model->save()){
                return $this->redirect(['view', 'id' => $model->id]);
            }

        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Semester model.
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
     * Deletes an existing Semester model.
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
     * Finds the Semester model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Semester the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Semester::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }



    //CHANGE ACTIVE SEMESTER
    public function actionChangeSemester(){
        $active_semester=Semester::find()->where(['status'=>'Active'])->one();

        $all_modules=Module::find()->where(['semester_id'=>$active_semester])->count();
        $all_modules_uploaded=ExamResult::find()->where(['semester_id'=>$active_semester])->groupBy(['module_id'])->count();


        $release_result_first=ExamResult::find()->where(['status'=>'Wait for Approval','semester_id'=>$active_semester->id])->exists();
        if ($release_result_first){
            Yii::$app->session->setFlash('getDanger','<span class="fa fa-close"> Failed! Please make sure all student results have been published in order to change Semester</span>');
            return $this->redirect(['index']);
        }
        elseif ($all_modules!=$all_modules_uploaded){
            Yii::$app->session->setFlash('getDanger','<span class="fa fa-close"> Failed! Please make sure that  all module  results of the current semester have been uploaded  in order to change Semester</span>');
            return $this->redirect(['index']);
        }

        $active_semester->status='Inactive';
        if ( $active_semester->save()) {
            $activate_semester_II = Semester::find()->where(['name' => 'II'])->one();
            $activate_semester_II->status = 'Active';
            $activate_semester_II->save();
           Yii::$app->session->setFlash('getSuccess','<span class="fa fa-check-square"> Semester changed successfully! The current semester is II</span>');
            return $this->redirect(['index']);
        }
    }








}
