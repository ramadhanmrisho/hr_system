<?php

namespace backend\controllers;

use common\models\AssessmentMethod;
use common\models\AssessmentMethodTracking;
use common\models\CourseworkNta4;
use common\models\CourseworkNta5;
use common\models\CourseworkNta6;
use common\models\ExamResult;
use common\models\FinalExam;
use common\models\Grade;
use common\models\Module;
use common\models\Student;
use common\models\YearOfStudy;
use Yii;
use common\models\Supplementary;
use common\models\search\SupplementarySearch;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\filters\AccessControl;

/**
 * SupplementaryController implements the CRUD actions for Supplementary model.
 */
class SupplementaryController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
             'access' => [
                'class' => AccessControl::className(),
                'only' => ['index','create','update','view','delete', 'findModel'],
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
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Supplementary models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SupplementarySearch();



            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);

    }

    /**
     * Displays a single Supplementary model.
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
     * Creates a new Supplementary model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Supplementary();

        if ($model->load(Yii::$app->request->post())) {
            $selected_course=$model->course_id;
            $selected_module=$model->module_id;
            $year_of_stud=YearOfStudy::find()->where(['id'=>$model->year_of_study_id])->one()->name;
            $courseworks4_results_exists= CourseworkNta4::find()->where([ 'semester_id' =>$model->semester_id, 'module_id' => $model->module_id, 'academic_year_id' =>$model->academic_year_id,'course_id'=>$model->course_id])->exists();
            $courseworks5_results_exists= CourseworkNta5::find()->where([ 'semester_id' =>$model->semester_id, 'module_id' => $model->module_id, 'academic_year_id' =>$model->academic_year_id,'course_id'=>$model->course_id])->exists();
            $courseworks6_results_exists= CourseworkNta6::find()->where([ 'semester_id' =>$model->semester_id, 'module_id' => $model->module_id, 'academic_year_id' =>$model->academic_year_id,'course_id'=>$model->course_id])->exists();

            //CHECKING COURSEWORKS NTA4
            if ($year_of_stud =='First Year') {
                if (!$courseworks4_results_exists){
                    Yii::$app->session->setFlash('getDanger','<span class="fa fa-warning">Please Upload All Continuous Assessment Results!</span>');
                    return $this->render('create', ['model' => $model]);
                }

                if($courseworks4_results_exists){
                    $courseworks4_results_score= CourseworkNta4::find()->where([ 'semester_id' =>$model->semester_id, 'module_id' => $model->module_id, 'academic_year_id' =>$model->academic_year_id,'course_id'=>$model->course_id])->one()->total_score;
                    if (empty($courseworks4_results_score)){
                        Yii::$app->session->setFlash('getDanger','<span class="fa fa-warning">Please Upload All Continuous Assessment Results!</span>');
                        return $this->render('create', ['model' => $model]);
                    }
                }
            }

            //CHECKING COURSEWORKS NTA5
            if ($year_of_stud =='Second Year') {
                if (!$courseworks5_results_exists){
                    Yii::$app->session->setFlash('getDanger','<span class="fa fa-warning">Please Upload All Continuous Assessment Results!</span>');
                    return $this->render('create', ['model' => $model]);
                }
                if($courseworks5_results_exists){
                    $courseworks5_results_score= CourseworkNta5::find()->where([ 'semester_id' =>$model->semester_id, 'module_id' => $model->module_id, 'academic_year_id' =>$model->academic_year_id,'course_id'=>$model->course_id])->one()->total_score;
                    if (empty($courseworks5_results_score)){
                        Yii::$app->session->setFlash('getDanger','<span class="fa fa-warning">Please Upload All Continuous Assessment Results!</span>');
                        return $this->render('create', ['model' => $model]);
                    }
                }
            }
            //CHECKING COURSEWORKS NTA6
            if ($year_of_stud =='Third Year') {
                if (!$courseworks6_results_exists){
                    Yii::$app->session->setFlash('getDanger','<span class="fa fa-warning">Please Upload All Continuous Assessment Results!</span>');
                    return $this->render('create', ['model' => $model]);
                }
                if($courseworks6_results_exists){
                    $courseworks6_results_score= CourseworkNta6::find()->where([ 'semester_id' =>$model->semester_id, 'module_id' => $model->module_id, 'academic_year_id' =>$model->academic_year_id,'course_id'=>$model->course_id])->one()->total_score;
                    if (empty($courseworks6_results_score)){
                        Yii::$app->session->setFlash('getDanger','<span class="fa fa-warning">Please Upload All Continuous Assessment Results!</span>');
                        return $this->render('create', ['model' => $model]);
                    }
                }
            }


            $module=Module::find()->where(['course_id'=>$selected_course,'id'=>$selected_module])->exists();
            if (!$module){
                Yii::$app->session->setFlash('getDanger','<span class="fa fa-warning">Please select relevant module for the selected course!</span>');
                return $this->render('create', ['model' => $model]);
            }


            $model->csv_file = UploadedFile::getInstance($model, 'csv_file');
            $time = date('Ymd-His');
            $model->csv_file->saveAs('csv/'. $time.'.' . $model->csv_file->extension);
            $model->csv_file ='csv/'. $time . '.' . $model->csv_file->extension;
            $handle = fopen($model->csv_file, "r");
            $file = fopen( $model->csv_file, "r");
            $allowedColNum=3;

            //  checking for an empty file
            if (filesize($model->csv_file)==0){
                Yii::$app->session->setFlash('getDanger',"<span class='fa fa-warning'> Empty file uploaded! Please upload correct file</span>");
                return $this->render('create', ['model' => $model]);
            }
            while ($line = fgetcsv($file)){
                // count($line) is the number of columns
                $numcols = count($line);

                // Terminate  the loop if columns are incorrect
                if($numcols!= $allowedColNum) {
                    Yii::$app->session->setFlash('getDanger',"<span class=' fa fa-warning'> Invalid file Uploaded! Please check your CSV file</span>");
                    return $this->render('create', ['model' => $model]);
                }


                else{
                    $header=true;
                    while (($fileop = fgetcsv($handle, 1000, ",")) !== false) {
                        if($header){
                            $header=false;
                            continue;
                        }
                        $checkIfExist=FinalExam::find()->where(['registration_number'=>$fileop[0],'module_id'=>$model->module_id,'course_id'=>$model->course_id,'year_of_study_id'=>$model->year_of_study_id,'academic_year_id'=>$model->academic_year_id,'semester_id'=>$model->semester_id])->exists();

                        $check_student_level=Student::find()->where(['registration_number'=>$fileop[0],'course_id'=>$model->course_id,'year_of_study_id'=>$model->year_of_study_id,'academic_year_id'=>$model->academic_year_id])->exists();
                        //                        if(!$check_student_level){
                        //                            Yii::$app->session->setFlash('getWarning', '<span class="fa fa-warning"> Sorry! Registration Number of these students are of another Class!</span>');
                        //                            return $this->render('create', ['model' => $model]);
                        //                        }

                        $assessment_methods_id=AssessmentMethod::find()->where(['name'=>'Written Examination'])->one()->id;
                        $assessment_methods_id1=AssessmentMethod::find()->where(['name'=>'Practical Examination'])->one()->id;
                        $written_exam_parcent=AssessmentMethodTracking::find()->where(['assessment_method_id'=>$assessment_methods_id,'module_id'=>$model->module_id,'category'=>'SE'])->one()->percent;
                        $practical_exam_parcent=AssessmentMethodTracking::find()->where(['assessment_method_id'=>$assessment_methods_id1,'module_id'=>$model->module_id,'category'=>'SE'])->one()->percent;

                        $year_of_stud=YearOfStudy::find()->where(['id'=>$model->year_of_study_id])->one()->name;
                        if ($year_of_stud=='First Year'){
                            $nta_level='4';
                        }
                        if ($year_of_stud=='Second Year'){
                            $nta_level='5';
                        } if ($year_of_stud=='Third Year'){
                            $nta_level='6';
                        }
                        $registration_number= $fileop[0];
                        $written_exam= ($fileop[1]/100)*$written_exam_parcent;
                        $practical=($fileop[2]/100)*$practical_exam_parcent;
                        $total_score=(($fileop[1]/100)*$written_exam_parcent+($fileop[2]/100)*$practical_exam_parcent);
                        $nta=$nta_level;
                        $module=$model->module_id;
                        $course=$model->course_id;
                        $year_of_study=$model->year_of_study_id;
                        $academic_year=$model->academic_year_id;
                        $semester=$model->semester_id;
                        $created_by=Yii::$app->user->identity->user_id;
                        $student_id=Student::find()->where(['registration_number'=>$registration_number])->one()->id;

                        $all_students=Supplementary::find()->where(['module_id'=>$model->module_id,'course_id'=>$model->course_id,'year_of_study_id'=>$model->year_of_study_id,'academic_year_id'=>$model->academic_year_id,'semester_id'=>$model->semester_id])->all();


                        foreach($all_students as $students) {
                            $query = Yii::$app->db->createCommand()->update('supplementary', ['written_exam' => $written_exam, 'practical' => $practical, 'total_score' => $total_score], ['student_id' => $students['student_id'], 'semester_id' => $model->semester_id, 'academic_year_id' => $model->academic_year_id, 'year_of_study_id' => $model->year_of_study_id, 'course_id' => $model->course_id])->execute();
                        }


                    }
                    if($query) {
                        unlink($model->csv_file);
                        //GENERATING EXAM RESULTS
                        $all_students=Supplementary::find()->where(['module_id'=>$model->module_id,'course_id'=>$model->course_id,'year_of_study_id'=>$model->year_of_study_id,'academic_year_id'=>$model->academic_year_id,'semester_id'=>$model->semester_id])->all();
                        $year_of_stud=YearOfStudy::find()->where(['id'=>$model->year_of_study_id])->one()->name;
                        if ($year_of_stud=='First Year'){
                            $nta_level='4';
                        }
                        if ($year_of_stud=='Second Year'){
                            $nta_level='5';
                        } if ($year_of_stud=='Third Year'){
                            $nta_level='6';
                        }


                        foreach($all_students as $students) {
                            if ($year_of_stud == 'First Year') {

                                $coursework = CourseworkNta4::find()->where(['student_id' => $students['student_id'], 'semester_id' => $students['semester_id'], 'module_id' => $students['module_id'], 'academic_year_id' => $students['academic_year_id']])->one()->total_score;
                            }
                            if ($year_of_stud == 'Second Year') {
                                $coursework = CourseworkNta5::find()->where(['student_id' => $students['student_id'], 'semester_id' => $students['semester_id'], 'module_id' => $students['module_id'], 'academic_year_id' => $students['academic_year_id']])->one()->total_score;
                            }
                            if ($year_of_stud == 'Third Year') {
                                $coursework = CourseworkNta6::find()->where(['student_id' => $students['student_id'], 'semester_id' => $students['semester_id'], 'module_id' => $students['module_id'], 'academic_year_id' => $students['academic_year_id']])->one()->total_score;
                            }
                            $new_total= $students['total_score'] + $coursework;



                            $module_credit=Module::find()->where(['id'=>$model->module_id])->one()->module_credit;
                            //GRADE SCHEME FOR NTA 4 AND 5
                            if($year_of_stud=='First Year' || $year_of_stud=='Second Year'){
                                //SWITCHING CASE FOR GRADE
                                switch ($new_total) {
                                    case ($new_total>50 ||$new_total==50):
                                        $grade_id = Grade::find()->where(['academic_year_id' => $model->academic_year_id, 'year_of_study' => $model->year_of_study_id, 'grade' => 'C'])->one()->id;
                                        $remarks = "Pass";
                                        $points =2*$module_credit;
                                        break;

                                    case($new_total<50):
                                        $grade_id = Grade::find()->where(['academic_year_id' => $model->academic_year_id, 'year_of_study' => $model->year_of_study_id, 'grade' => 'D'])->one()->id;
                                        $remarks = "Supplementary";
                                        $points =1*$module_credit;
                                        break;



                                }

                            }
                            //GRADE SCHEME FOR NTA 6
                            if($year_of_stud=='Third Year'){

                                //SWITCHING CASE FOR GRADE
                                switch ($new_total) {
                                    case ($new_total>=50):
                                        $grade_C_id = Grade::find()->where(['academic_year_id' => $model->academic_year_id, 'year_of_study' => $model->year_of_study_id, 'grade' => 'C'])->one()->id;
                                        $grade_id = $grade_C_id;
                                        $remarks = "Pass";
                                        $status='Pass';
                                        $points =3*$module_credit;
                                        break;


                                    case ($new_total<50):
                                        $grade_D_id = Grade::find()->where(['academic_year_id' => $model->academic_year_id, 'year_of_study' => $model->year_of_study_id, 'grade' => 'D'])->one()->id;
                                        $grade_id = $grade_D_id;
                                        $remarks = "Supplementary";
                                        $status='Fail';
                                        $points=1*$module_credit;
                                        break;
                                }

                            }


                            Yii::$app->db->createCommand()->update('exam_result', ['final_exam_score' =>$new_total,'grade_id'=>$grade_id,'points'=>$points,'remarks'=>$remarks], ['student_id' => $students['student_id'], 'semester_id' => $model->semester_id, 'academic_year_id' => $model->academic_year_id, 'year_of_study_id' => $model->year_of_study_id, 'course_id' => $model->course_id])->execute();
                           Yii::$app->db->createCommand()->update('supplementary', ['status' =>$status], ['student_id' => $students['student_id'], 'semester_id' => $model->semester_id, 'academic_year_id' => $model->academic_year_id, 'year_of_study_id' => $model->year_of_study_id, 'course_id' => $model->course_id])->execute();


                        }
                        Yii::$app->session->setFlash('getSuccess', '<span class="fa fa-check-square-o"> Congratulations! Results uploaded successfully</span>');
                        return $this->redirect(['index']);
                    }

                }
            }

        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Supplementary model.
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
     * Deletes an existing Supplementary model.
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
     * Finds the Supplementary model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Supplementary the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Supplementary::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }



    public  function actionPass($id){
        $model = $this->findModel($id);
        $model->status='Pass';
        $model->save(false);

        Yii::$app->session->setFlash('getSuccess', '<span class="fa fa-check-square-o"> Saved Successfully!</span>');
        //Yii::$app->db->createCommand()->update('supplementary',['remarks'=>'Passed'],['student_id' => $model->student_id, 'semester_id' =>$model->semester_id, 'module_id' =>$model->module_id, 'academic_year_id' => $model->academic_year_id])->execute();
        return $this->redirect(['supplementary/index']);

    }




    public  function actionFail($id){



    }


}
