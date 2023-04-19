<?php

namespace backend\controllers;

use common\models\AcademicYear;
use common\models\Course;
use common\models\Semester;
use common\models\Supplementary;
use common\models\YearOfStudy;
use Yii;
use common\models\ExamResult;
use common\models\search\ExamResultSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ExamResultController implements the CRUD actions for ExamResult model.
 */
class ExamResultController extends Controller
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
     * Lists all ExamResult models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ExamResultSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ExamResult model.
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
     * Creates a new ExamResult model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ExamResult();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing ExamResult model.
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
     * Deletes an existing ExamResult model.
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
     * Finds the ExamResult model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ExamResult the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ExamResult::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }


    public function actionApprove($authorization){
        $first_year=YearOfStudy::find()->where(['name'=>'First Year'])->one()->id;
        $second_year=YearOfStudy::find()->where(['name'=>'Second Year'])->one()->id;
        $third_year=YearOfStudy::find()->where(['name'=>'Third Year'])->one()->id;

        $cm1=Course::find()->where(['abbreviation'=>'NTA4_CM'])->one()->id;
        $cm2=Course::find()->where(['abbreviation'=>'NTA5_CM'])->one()->id;
        $cm3=Course::find()->where(['abbreviation'=>'NTA6_CM'])->one()->id;

        $nm1=Course::find()->where(['abbreviation'=>'NTA4_NM'])->one()->id;
        $nm2=Course::find()->where(['abbreviation'=>'NTA5_NM'])->one()->id;
        $nm3=Course::find()->where(['abbreviation'=>'NTA6_NM'])->one()->id;



        $current_academic_year=AcademicYear::find()->where(['status'=>'Active'])->one()->id;
        $semester1=Semester::find()->where(['name'=>'I'])->one()->id;
        $semester2=Semester::find()->where(['name'=>'II'])->one()->id;


        //CLINICAL MEDICINE
      if($authorization=='clinical_11'){
          Yii::$app->db->createCommand()->update('exam_result',['status'=>'Released'],['semester_id'=>$semester1, 'academic_year_id' =>$current_academic_year,'course_id'=>$cm1])->execute();
          Yii::$app->session->setFlash('getSuccess', '<span class="fa fa-check-square-o"> Congratulations! Results Approved Successfully</span>');
          return $this->redirect(['index','authorization'=>'clinical_11']);
      }

        if($authorization=='clinical_12'){
            Yii::$app->db->createCommand()->update('exam_result',['status'=>'Released'],['semester_id'=>$semester2, 'academic_year_id' =>$current_academic_year,'course_id'=>$cm1])->execute();
            Yii::$app->session->setFlash('getSuccess', '<span class="fa fa-check-square-o"> Congratulations! Results Approved Successfully</span>');
            return $this->redirect(['index','authorization'=>'clinical_12']);
        }

        if($authorization=='clinical_21'){
            Yii::$app->db->createCommand()->update('exam_result',['status'=>'Released'],['semester_id'=>$semester1, 'academic_year_id' =>$current_academic_year,'course_id'=>$cm2])->execute();
            Yii::$app->session->setFlash('getSuccess', '<span class="fa fa-check-square-o"> Congratulations! Results Approved Successfully</span>');
            return $this->redirect(['index','authorization'=>'clinical_21']);
        }

        if($authorization=='clinical_22'){
            Yii::$app->db->createCommand()->update('exam_result',['status'=>'Released'],['semester_id'=>$semester2, 'academic_year_id' =>$current_academic_year,'course_id'=>$cm2])->execute();
            Yii::$app->session->setFlash('getSuccess', '<span class="fa fa-check-square-o"> Congratulations! Results Approved Successfully</span>');
            return $this->redirect(['index','authorization'=>'clinical_22']);
        }

        if($authorization=='clinical_31'){
            Yii::$app->db->createCommand()->update('exam_result',['status'=>'Released'],['semester_id'=>$semester1, 'academic_year_id' =>$current_academic_year,'course_id'=>$cm3])->execute();
            Yii::$app->session->setFlash('getSuccess', '<span class="fa fa-check-square-o"> Congratulations! Results Approved Successfully</span>');
            return $this->redirect(['index','authorization'=>'clinical_31']);
        }

        if($authorization=='clinical_32'){
            Yii::$app->db->createCommand()->update('exam_result',['status'=>'Released'],['semester_id'=>$semester2, 'academic_year_id' =>$current_academic_year,'course_id'=>$cm3])->execute();
            Yii::$app->session->setFlash('getSuccess', '<span class="fa fa-check-square-o"> Congratulations! Results Approved Successfully</span>');
            return $this->redirect(['index','authorization'=>'clinical_31']);
        }

        //NURSING AND MIDWIFERY
        if($authorization=='nursing_11'){
            Yii::$app->db->createCommand()->update('exam_result',['status'=>'Released'],['semester_id'=>$semester1, 'academic_year_id' =>$current_academic_year,'course_id'=>$nm1])->execute();
            Yii::$app->session->setFlash('getSuccess', '<span class="fa fa-check-square-o"> Congratulations! Results Approved Successfully</span>');
            return $this->redirect(['index','authorization'=>'clinical_11']);
        }

        if($authorization=='nursing_12'){
            Yii::$app->db->createCommand()->update('exam_result',['status'=>'Released'],['semester_id'=>$semester2, 'academic_year_id' =>$current_academic_year,'course_id'=>$nm1])->execute();
            Yii::$app->session->setFlash('getSuccess', '<span class="fa fa-check-square-o"> Congratulations! Results Approved Successfully</span>');
            return $this->redirect(['index','authorization'=>'clinical_12']);
        }

        if($authorization=='nursing_21'){
            Yii::$app->db->createCommand()->update('exam_result',['status'=>'Released'],['semester_id'=>$semester1, 'academic_year_id' =>$current_academic_year,'course_id'=>$nm2])->execute();
            Yii::$app->session->setFlash('getSuccess', '<span class="fa fa-check-square-o"> Congratulations! Results Approved Successfully</span>');
            return $this->redirect(['index','authorization'=>'clinical_21']);
        }

        if($authorization=='nursing_22'){
            Yii::$app->db->createCommand()->update('exam_result',['status'=>'Released'],['semester_id'=>$semester2, 'academic_year_id' =>$current_academic_year,'course_id'=>$nm2])->execute();
            Yii::$app->session->setFlash('getSuccess', '<span class="fa fa-check-square-o"> Congratulations! Results Approved Successfully</span>');
            return $this->redirect(['index','authorization'=>'clinical_22']);
        }

        if($authorization=='nursing_31'){
            Yii::$app->db->createCommand()->update('exam_result',['status'=>'Released'],['semester_id'=>$semester1, 'academic_year_id' =>$current_academic_year,'course_id'=>$nm3])->execute();
            Yii::$app->session->setFlash('getSuccess', '<span class="fa fa-check-square-o"> Congratulations! Results Approved Successfully</span>');
            return $this->redirect(['index','authorization'=>'clinical_31']);
        }

        if($authorization=='nursing_32'){
            Yii::$app->db->createCommand()->update('exam_result',['status'=>'Released'],['semester_id'=>$semester2, 'academic_year_id' =>$current_academic_year,'course_id'=>$nm3])->execute();
            Yii::$app->session->setFlash('getSuccess', '<span class="fa fa-check-square-o"> Congratulations! Results Approved Successfully</span>');
            return $this->redirect(['index','authorization'=>'clinical_32']);
        }


    }
}
