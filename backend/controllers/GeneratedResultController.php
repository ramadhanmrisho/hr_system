<?php

namespace backend\controllers;

use common\models\Course;
use common\models\ExamResult;
use common\models\FinalExam;
use common\models\GpaClass;
use common\models\Module;
use common\models\Student;
use kartik\mpdf\Pdf;
use Yii;
use common\models\GeneratedResult;
use common\models\search\GeneratedResultSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * GeneratedResultController implements the CRUD actions for GeneratedResult model.
 */
class GeneratedResultController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index','create','update','view','delete', 'findModel','staff'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all GeneratedResult models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new GeneratedResultSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single GeneratedResult model.
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
     * Creates a new GeneratedResult model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new GeneratedResult();

        $model->created_by=Yii::$app->user->identity->user_id;
        if ($model->load(Yii::$app->request->post())) {

            $model->nta_level=Course::find()->where(['id'=>$model->course_id])->one()->nta_level;
            $final_results_exists=ExamResult::find()->where(['academic_year_id'=>$model->academic_year_id,'course_id'=>$model->course_id,'semester_id'=>$model->semester_id,'nta_level'=>$model->nta_level])->exists();

            if (!$final_results_exists){
                Yii::$app->session->setFlash('getDanger','<span class="fa fa-warning"> The selected results are currently unavailable!</span>');
                return $this->render('create', ['model' => $model,]);
            }

            if ($model->save()){
                $final_results=ExamResult::find()->where(['academic_year_id'=>$model->academic_year_id,'course_id'=>$model->course_id,'semester_id'=>$model->semester_id])->groupBy(['student_id'])->all();
                $student_modules=ExamResult::find()->where(['academic_year_id'=>$model->academic_year_id,'course_id'=>$model->course_id,'semester_id'=>$model->semester_id])->orderby(['created_at' => SORT_DESC])->groupBy(['module_id'])->all();
                $final_results_count=ExamResult::find()->where(['academic_year_id'=>$model->academic_year_id,'course_id'=>$model->course_id,'semester_id'=>$model->semester_id])->groupBy(['student_id'])->count();
                $sum_of_n=Module::find()->where(['course_id'=>$model->course_id,'semester_id'=>$model->semester_id])->sum('module_credit');


                if ($model->nta_level==4 ||$model->nta_level==5){
                    $first_class_start=GpaClass::find()->where(['academic_year_id'=>$model->academic_year_id,'nta_level'=>$model->nta_level,'gpa_class'=>'FIRST CLASS'])->one()->starting_point;
                    $first_class_end=GpaClass::find()->where(['academic_year_id'=>$model->academic_year_id,'nta_level'=>$model->nta_level,'gpa_class'=>'FIRST CLASS'])->one()->end_point;
                    $second_class_start=GpaClass::find()->where(['academic_year_id'=>$model->academic_year_id,'nta_level'=>$model->nta_level,'gpa_class'=>'SECOND CLASS'])->one()->starting_point;
                    $second_class_end=GpaClass::find()->where(['academic_year_id'=>$model->academic_year_id,'nta_level'=>$model->nta_level,'gpa_class'=>'SECOND CLASS'])->one()->end_point;
                    $pass_class_start=GpaClass::find()->where(['academic_year_id'=>$model->academic_year_id,'nta_level'=>$model->nta_level,'gpa_class'=>'PASS'])->one()->starting_point;
                    $pass_class_end=GpaClass::find()->where(['academic_year_id'=>$model->academic_year_id,'nta_level'=>$model->nta_level,'gpa_class'=>'PASS'])->one()->end_point;
                    $uppersecond_class_start=$uppersecond_class_end=$lowersecond_class_start=$lowersecond_class_end=0;
                    return $this->render('result',[
                        'model'=>$model,
                        'final_results'=>$final_results,
                        'student_modules'=>$student_modules,
                        'sum_of_n'=>$sum_of_n,
                        'first_class_start'=>$first_class_start,
                        'first_class_end'=>$first_class_end,
                        'second_class_start'=>$second_class_start,
                        'second_class_end'=>$second_class_end,
                        'pass_class_start'=>$pass_class_start,
                        'pass_class_end'=>$pass_class_end,
                        'uppersecond_class_start'=>$uppersecond_class_start,
                        'uppersecond_class_end'=>$uppersecond_class_end,
                        'lowersecond_class_start'=>$lowersecond_class_start,
                        'lowersecond_class_end'=>$lowersecond_class_end,

                    ]);

                }

                if ($model->nta_level==6){
                    $first_class_start=GpaClass::find()->where(['academic_year_id'=>$model->academic_year_id,'nta_level'=>$model->nta_level,'gpa_class'=>'FIRST CLASS'])->one()->starting_point;
                    $first_class_end=GpaClass::find()->where(['academic_year_id'=>$model->academic_year_id,'nta_level'=>$model->nta_level,'gpa_class'=>'FIRST CLASS'])->one()->end_point;
                    $uppersecond_class_start=GpaClass::find()->where(['academic_year_id'=>$model->academic_year_id,'nta_level'=>$model->nta_level,'gpa_class'=>'UPPER SECOND CLASS'])->one()->starting_point;
                    $uppersecond_class_end=GpaClass::find()->where(['academic_year_id'=>$model->academic_year_id,'nta_level'=>$model->nta_level,'gpa_class'=>'UPPER SECOND CLASS'])->one()->end_point;
                    $lowersecond_class_start=GpaClass::find()->where(['academic_year_id'=>$model->academic_year_id,'nta_level'=>$model->nta_level,'gpa_class'=>'LOWER SECOND CLASS'])->one()->starting_point;
                    $lowersecond_class_end=GpaClass::find()->where(['academic_year_id'=>$model->academic_year_id,'nta_level'=>$model->nta_level,'gpa_class'=>'LOWER SECOND CLASS'])->one()->end_point;
                    $pass_class_start=GpaClass::find()->where(['academic_year_id'=>$model->academic_year_id,'nta_level'=>$model->nta_level,'gpa_class'=>'PASS'])->one()->starting_point;
                    $pass_class_end=GpaClass::find()->where(['academic_year_id'=>$model->academic_year_id,'nta_level'=>$model->nta_level,'gpa_class'=>'PASS'])->one()->end_point;



                    return $this->render('result',[
                        'model'=>$model,
                        'final_results'=>$final_results,
                        'student_modules'=>$student_modules,
                        'sum_of_n'=>$sum_of_n,
                        'first_class_start'=>$first_class_start,
                        'first_class_end'=>$first_class_end,
                        'pass_class_start'=>$pass_class_start,
                        'pass_class_end'=>$pass_class_end,
                        'uppersecond_class_start'=>$uppersecond_class_start,
                        'uppersecond_class_end'=>$uppersecond_class_end,
                        'lowersecond_class_start'=>$lowersecond_class_start,
                        'lowersecond_class_end'=>$lowersecond_class_end,

                    ]);
                }

            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }


    public function actionTest(){


        return $this->render('test');
    }


    /**
     * Updates an existing GeneratedResult model.
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
     * Deletes an existing GeneratedResult model.
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
     * Finds the GeneratedResult model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return GeneratedResult the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = GeneratedResult::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
