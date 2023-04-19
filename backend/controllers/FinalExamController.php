<?php

namespace backend\controllers;

use common\models\AssessmentMethod;
use common\models\AssessmentMethodTracking;
use common\models\CourseworkNta4;
use common\models\CourseworkNta5;
use common\models\CourseworkNta6;
use common\models\ExamResult;
use common\models\Grade;
use common\models\Course;
use common\models\Module;
use common\models\Student;
use common\models\Supplementary;
use common\models\YearOfStudy;
use kartik\mpdf\Pdf;
use Yii;
use common\models\FinalExam;
use common\models\search\FinalExamSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\filters\AccessControl;

/**
 * FinalExamController implements the CRUD actions for FinalExam model.
 */
class FinalExamController extends Controller
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
     * Lists all FinalExam models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new FinalExamSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);

//        return $this->render('result');
//        Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
//        $pdf = new Pdf([
//            'mode' => Pdf::MODE_CORE, // leaner size using standard fonts
//            'destination' => Pdf::DEST_BROWSER,
//            'orientation'=>Pdf::ORIENT_LANDSCAPE,
//
//            'content' => $this->renderPartial('result'),
//
//            'options' => [
//                'target'=>'_blank',
//
//            ],
//            'cssInline' => '*,body{font-family:Times New Roman;font-size:12pt}',
//            'methods' => [
//                'SetTitle' => 'KCOHAS Results',
//                'SetWatermarkImage' => [\yii\helpers\Url::to(['/images/logo.png'])],
//                'SetSubject' => 'Generating PDF files via yii2-mpdf extension has never been easy',
//                'SetHeader' => ['Generated On: ' . date("r")],
//                'SetFooter' => ['|Page {PAGENO}|'],
//                'SetAuthor' => 'KCOHAS',
//                'SetCreator' => 'KCOHAS',
//                'SetKeywords' => 'Krajee, Yii2, Export, PDF, MPDF, Output, Privacy, Policy, yii2-mpdf',
//            ]
//        ]);
//        return $pdf->render();
    }





    public function actionViewSlip() {
        Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
        $pdf = new Pdf([
            'mode' => Pdf::MODE_CORE, // leaner size using standard fonts
            'destination' => Pdf::DEST_BROWSER,
            'content' => $this->renderPartial('result'),
            'orientation'=>Pdf::ORIENT_LANDSCAPE,

            'options' => [
                'target'=>'_blank',
            ],
            'cssInline' => '*,body{font-family:Times New Roman;font-size:12pt}',
            'methods' => [
                'SetTitle' => 'KCOHAS Salary Slip',
                'SetWatermarkImage' => [\yii\helpers\Url::to(['/images/logo.png'])],
                'SetSubject' => 'Generating PDF files via yii2-mpdf extension has never been easy',
                'SetHeader' => ['Generated On: ' . date("r")],
                'SetFooter' => ['|Page {PAGENO}|'],
                'SetAuthor' => 'KCOHAS',
                'SetCreator' => 'KCOHAS',
                'SetKeywords' => 'Krajee, Yii2, Export, PDF, MPDF, Output, Privacy, Policy, yii2-mpdf',
            ]
        ]);
        return $pdf->render();
    }





    /**
     * Displays a single FinalExam model.
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
     * Creates a new FinalExam model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {


        $model = new FinalExam();


        if ($model->load(Yii::$app->request->post())) {
            $selected_course=$model->course_id;
            $selected_module=$model->module_id;


            // $year_of_stud=YearOfStudy::find()->where(['id'=>$model->year_of_study_id])->one()->name;
            $courseworks4_results_exists= CourseworkNta4::find()->where([ 'semester_id' =>$model->semester_id, 'module_id' => $model->module_id, 'academic_year_id' =>$model->academic_year_id,'course_id'=>$model->course_id])->exists();
            $courseworks5_results_exists= CourseworkNta5::find()->where([ 'semester_id' =>$model->semester_id, 'module_id' => $model->module_id, 'academic_year_id' =>$model->academic_year_id,'course_id'=>$model->course_id])->exists();
            $courseworks6_results_exists= CourseworkNta6::find()->where([ 'semester_id' =>$model->semester_id, 'module_id' => $model->module_id, 'academic_year_id' =>$model->academic_year_id,'course_id'=>$model->course_id])->exists();

            //CHECKING COURSEWORKS NTA4
            if ($model->nta_level==4) {
                if (!$courseworks4_results_exists){
                    Yii::$app->session->setFlash('getDanger','<span class="fa fa-warning"> Please Upload All Continuous Assessment Results!</span>');
                    return $this->render('create', ['model' => $model]);
                }

                if($courseworks4_results_exists){
                    $courseworks4_results_score= CourseworkNta4::find()->where([ 'semester_id' =>$model->semester_id, 'module_id' => $model->module_id, 'academic_year_id' =>$model->academic_year_id,'course_id'=>$model->course_id])->one()->total_score;
                    if (empty($courseworks4_results_score)){
                        Yii::$app->session->setFlash('getDanger','<span class="fa fa-warning"> Please Upload All Continuous Assessment Results!</span>');
                        return $this->render('create', ['model' => $model]);
                    }
                }
            }

            //CHECKING COURSEWORKS NTA5
            if ($model->nta_level==5) {
                if (!$courseworks5_results_exists){
                    Yii::$app->session->setFlash('getDanger','<span class="fa fa-warning">Please Upload All Continuous Assessment Results!</span>');
                    return $this->render('create', ['model' => $model]);
                }

                if($courseworks5_results_exists){
                    $courseworks5_results_score= CourseworkNta5::find()->where([ 'semester_id' =>$model->semester_id, 'module_id' => $model->module_id, 'academic_year_id' =>$model->academic_year_id,'course_id'=>$model->course_id])->one()->total_score;
                    if (empty($courseworks5_results_score)){
                        Yii::$app->session->setFlash('getDanger','<span class="fa fa-warning"> Please Upload All Continuous Assessment Results!</span>');
                        return $this->render('create', ['model' => $model]);
                    }
                }
            }
            //CHECKING COURSEWORKS NTA6
            if ($model->nta_level==6) {
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
//                        $checkIfExist=FinalExam::find()->where(['registration_number'=>$fileop[0],'module_id'=>$model->module_id,'course_id'=>$model->course_id,'nta_level'=>$model->nta_level,'academic_year_id'=>$model->academic_year_id,'semester_id'=>$model->semester_id])->exists();
//                        if($checkIfExist){
//                            $checkIfExists=FinalExam::findAll(['registration_number'=>$fileop[0],'module_id'=>$model->module_id,'course_id'=>$model->course_id,'nta_level'=>$model->nta_level,'academic_year_id'=>$model->academic_year_id,'semester_id'=>$model->semester_id]);
//
//                            foreach($checkIfExists as $student) {
//                                echo $student["registration_number"];
//                                echo '<br>';
//                            }
//                            Yii::$app->session->setFlash('getWarning', '<span class="fa fa-times"> Sorry! Results of Students with this registration number already exists!</span>');
//                            return $this->render('create', ['model' => $model]);
//                        }
                        $check_student_level=Student::find()->where(['registration_number'=>$fileop[0],'course_id'=>$model->course_id,'nta_level'=>$model->nta_level,'academic_year_id'=>$model->academic_year_id])->exists();
                        //                        if(!$check_student_level){
                        //                            Yii::$app->session->setFlash('getWarning', '<span class="fa fa-warning"> Sorry! Registration Number of these students are of another Class!</span>');
                        //                            return $this->render('create', ['model' => $model]);
                        //                        }

                        $model->nta_level=Course::find()->where(['id'=>$model->course_id])->one()->nta_level;
                        $assessment_methods_id_ipo=AssessmentMethod::find()->where(['name'=>'Written Examination','nta_level'=>$model->nta_level])->exists();
                        $assessment_methods_id_prac=AssessmentMethod::find()->where(['name'=>'Practical Examination','nta_level'=>$model->nta_level])->exists();
                        $assessment_methods_id_clic=AssessmentMethod::find()->where(['name'=>'Clinical Examination','nta_level'=>$model->nta_level])->exists();
                        $assessment_methods_id_oral=AssessmentMethod::find()->where(['name'=>'Oral Examination','nta_level'=>$model->nta_level])->exists();
                        $assessment_methods_id_ospe=AssessmentMethod::find()->where(['name'=>'OSPE','nta_level'=>$model->nta_level])->exists();
                        $assessment_methods_id_report=AssessmentMethod::find()->where(['name'=>'Research Report','nta_level'=>$model->nta_level])->exists();
                        $assessment_methods_id_case=AssessmentMethod::find()->where(['name'=>'Case Presentation','nta_level'=>$model->nta_level])->exists();


                        if($assessment_methods_id_ipo){
                            $assessment_methods_id=AssessmentMethod::find()->where(['name'=>'Written Examination','nta_level'=>$model->nta_level])->one()->id;
                        }

                        //var_dump($assessment_methods_id_prac);die();

                        if($assessment_methods_id_prac){
                            $assessment_methods_id_prac_id=AssessmentMethod::find()->where(['name'=>'Practical Examination','nta_level'=>$model->nta_level])->one()->id;
                        }

                        if($assessment_methods_id_clic){
                            $assessment_methods_id_clic_id=AssessmentMethod::find()->where(['name'=>'Clinical Examination','nta_level'=>$model->nta_level])->one()->id;
                        }
                        if($assessment_methods_id_report){
                            $assessment_methods_id_report_id=AssessmentMethod::find()->where(['name'=>'Research Report','nta_level'=>$model->nta_level])->one()->id;
                        }

                        if($assessment_methods_id_ospe){

                            $assessment_methods_id_prac_id=AssessmentMethod::find()->where(['name'=>'OSPE','nta_level'=>$model->nta_level])->one()->id;

                        }




                        if($assessment_methods_id_case){



                            $assessment_methods_id_prac_id=AssessmentMethod::find()->where(['name'=>'Case Presentation','nta_level'=>$model->nta_level])->one()->id;

                        }

//                        if($assessment_methods_id_oral){
//
//                            $assessment_methods_id_prac_id=AssessmentMethod::find()->where(['name'=>'Oral Examination','nta_level'=>$model->nta_level])->one()->id;
//
//                        }



                        else{
                            $assessment_methods_id=AssessmentMethod::find()->where(['name'=>'Written Examination'])->one()->id;
                            $assessment_methods_id_prac_id=AssessmentMethod::find()->where(['name'=>'Practical Examination'])->one()->id;
                            $assessment_methods_id_clic_id=AssessmentMethod::find()->where(['name'=>'Clinical Examination'])->one()->id;
                            if(empty($assessment_methods_id_prac_id)){
                                $assessment_methods_id_prac_id=AssessmentMethod::find()->where(['name'=>'Case Presentation'])->one()->id;
                            }
                            if(empty($assessment_methods_id_prac_id)){
                                $assessment_methods_id_prac_id=AssessmentMethod::find()->where(['name'=>'Case Presentation'])->one()->id;
                            }


                        }


//var_dump($assessment_methods_id_prac_id);die();

                        $written_exam_parcent=AssessmentMethodTracking::find()->where(['assessment_method_id'=>$assessment_methods_id,'module_id'=>$model->module_id,'category'=>'SE'])->one()->percent;
                        $practical_exam_parcent_exists=AssessmentMethodTracking::find()->where(['assessment_method_id'=>$assessment_methods_id_prac_id,'module_id'=>$model->module_id,'category'=>'SE'])->exists();
                        $clinical_exam_parcent_exists=AssessmentMethodTracking::find()->where(['assessment_method_id'=>$assessment_methods_id_clic_id,'module_id'=>$model->module_id,'category'=>'SE'])->exists();
                        //$research_report_exists=AssessmentMethodTracking::find()->where(['assessment_method_id'=>$assessment_methods_id_report_id,'module_id'=>$model->module_id,'category'=>'SE'])->exists();




// var_dump($practical_exam_parcent_exists);die();
                        if ($practical_exam_parcent_exists){
                            $practical_exam_parcent=AssessmentMethodTracking::find()->where(['assessment_method_id'=>$assessment_methods_id_prac_id,'module_id'=>$model->module_id,'category'=>'SE'])->one()->percent;
                        }
                        elseif ($clinical_exam_parcent_exists){
                            $practical_exam_parcent=AssessmentMethodTracking::find()->where(['assessment_method_id'=>$assessment_methods_id_clic_id,'module_id'=>$model->module_id,'category'=>'SE'])->one()->percent;
                        }
//                        elseif ($research_report_exists){
//                            $practical_exam_parcent=AssessmentMethodTracking::find()->where(['assessment_method_id'=>$assessment_methods_id_report_id,'module_id'=>$model->module_id,'category'=>'SE'])->one()->percent;
//                        }
//                        else{
//                            $practical_exam_parcent=0;
//                        }

                        //var_dump($practical_exam_parcent);


                        $registration_number= $fileop[0];
                        $written_exam= $fileop[1];
                        $practical=$fileop[2];
                        $total_score=(($fileop[1]/100)*$written_exam_parcent+($fileop[2]/100)*$practical_exam_parcent);
                        $nta=$model->nta_level;
                        $module=$model->module_id;
                        $course=$model->course_id;
                        $academic_year=$model->academic_year_id;
                        $semester=$model->semester_id;
                        $created_by=Yii::$app->user->identity->id;
                        $student_id=Student::find()->where(['registration_number'=>$registration_number])->one()->id;
                        $sql="INSERT INTO final_exam(total_score,student_id,registration_number,module_id ,course_id,academic_year_id ,semester_id,nta_level,written_exam,practical,created_by) VALUES ('$total_score','$student_id','$registration_number','$module','$course','$academic_year','$semester','$nta','$written_exam','$practical','$created_by')";
                        $query = Yii::$app->db->createCommand($sql)->execute();

                    }
                    if($query) {
                        unlink($model->csv_file);
                        //GENERATING EXAM RESULTS
                        $all_students=FinalExam::find()->where(['module_id'=>$model->module_id,'course_id'=>$model->course_id,'academic_year_id'=>$model->academic_year_id,'semester_id'=>$model->semester_id])->all();


                        foreach($all_students as $students) {
                            $final_results = new ExamResult();
                            $final_results->student_id = $students['student_id'];
                            $final_results->module_id = $students['module_id'];
                            $final_results->academic_year_id = $students['academic_year_id'];
                            $final_results->nta_level = $students['nta_level'];
                            $final_results->course_id = $students['course_id'];
                            $final_results->semester_id = $students['semester_id'];
                            $final_results->final_exam_id = $students['id'];
                            $final_results->created_by = Yii::$app->user->identity->id;
                            $final_results->final_exam_score = $students['total_score'];
                            if ($model->nta_level==4) {

                                $final_results->coursework = CourseworkNta4::find()->where(['student_id' => $students['student_id'], 'semester_id' => $students['semester_id'], 'module_id' => $students['module_id'], 'academic_year_id' => $students['academic_year_id']])->one()->total_score;
                            }
                            if ($model->nta_level==5) {
                                $final_results->coursework = CourseworkNta5::find()->where(['student_id' => $students['student_id'], 'semester_id' => $students['semester_id'], 'module_id' => $students['module_id'], 'academic_year_id' => $students['academic_year_id']])->one()->total_score;
                            }
                            if ($model->nta_level==6) {
                                $final_results->coursework = CourseworkNta6::find()->where(['student_id' => $students['student_id'], 'semester_id' => $students['semester_id'], 'module_id' => $students['module_id'], 'academic_year_id' => $students['academic_year_id']])->one()->total_score;
                            }
                            $final_results->total_score = round($students['total_score'] + $final_results->coursework,0);


                            $module_credit=Module::find()->where(['id'=>$model->module_id])->one()->module_credit;
                            //GRADE SCHEME FOR NTA 4 AND 5
                            if($model->nta_level==4||$model->nta_level==5){
                                $grade_A_lower = Grade::find()->where(['academic_year_id' => $model->academic_year_id, 'nta_level' => $model->nta_level, 'grade' => 'A'])->one()->lower_score;
                                $grade_A_upper = Grade::find()->where(['academic_year_id' => $model->academic_year_id, 'nta_level' => $model->nta_level, 'grade' => 'A'])->one()->upper_score;
                                $grade_B_lower = Grade::find()->where(['academic_year_id' => $model->academic_year_id, 'nta_level' => $model->nta_level, 'grade' => 'B'])->one()->lower_score;
                                $grade_B_upper = Grade::find()->where(['academic_year_id' => $model->academic_year_id, 'nta_level' => $model->nta_level, 'grade' => 'B'])->one()->upper_score;
                                $grade_C_lower = Grade::find()->where(['academic_year_id' => $model->academic_year_id, 'nta_level' => $model->nta_level, 'grade' => 'C'])->one()->lower_score;
                                $grade_C_upper = Grade::find()->where(['academic_year_id' => $model->academic_year_id, 'nta_level' => $model->nta_level, 'grade' => 'C'])->one()->upper_score;
                                $grade_D_lower = Grade::find()->where(['academic_year_id' => $model->academic_year_id, 'nta_level' => $model->nta_level, 'grade' => 'D'])->one()->lower_score;
                                $grade_D_upper = Grade::find()->where(['academic_year_id' => $model->academic_year_id, 'nta_level' => $model->nta_level, 'grade' => 'D'])->one()->upper_score;
                                $grade_F_lower = Grade::find()->where(['academic_year_id' => $model->academic_year_id, 'nta_level' => $model->nta_level, 'grade' => 'F'])->one()->lower_score;
                                $grade_F_upper = Grade::find()->where(['academic_year_id' => $model->academic_year_id, 'nta_level' => $model->nta_level, 'grade' => 'F'])->one()->upper_score;

                                //SWITCHING CASE FOR GRADE
                                switch ($final_results->total_score) {
                                    case (($final_results->total_score == $grade_A_lower || $final_results->total_score > $grade_A_lower) && ($final_results->total_score == $grade_A_upper || $final_results->total_score < $grade_A_upper)):
                                        $grade_A_id = Grade::find()->where(['academic_year_id' => $model->academic_year_id, 'nta_level' => $model->nta_level, 'grade' => 'A'])->one()->id;
                                        $final_results->grade_id = $grade_A_id;
                                        $final_results->remarks = "Pass";
                                        $final_results->points =4*$module_credit;
                                        break;


                                    case (($final_results->total_score == $grade_B_lower || $final_results->total_score > $grade_B_lower) && ($final_results->total_score == $grade_B_upper || $final_results->total_score < $grade_B_upper)):
                                        $grade_B_id = Grade::find()->where(['academic_year_id' => $model->academic_year_id, 'nta_level' => $model->nta_level, 'grade' => 'B'])->one()->id;
                                        $final_results->grade_id = $grade_B_id;
                                        $final_results->remarks = "Pass";
                                        $final_results->points =3*$module_credit;
                                        break;


                                    case (( $final_results->total_score== $grade_C_lower ||  $final_results->total_score> $grade_C_lower) && ( $final_results->total_score== $grade_C_upper || $final_results->total_score< $grade_C_upper)):
                                        $grade_C_id = Grade::find()->where(['academic_year_id' => $model->academic_year_id, 'nta_level' => $model->nta_level, 'grade' => 'C'])->one()->id;
                                        $final_results->grade_id = $grade_C_id;
                                        $final_results->remarks = "Pass";
                                        $final_results->points =2*$module_credit;
                                        break;

                                    case(( $final_results->total_score == $grade_D_lower|| $final_results->total_score > $grade_D_lower) && ($final_results->total_score==$grade_D_upper||$final_results->total_score<$grade_D_upper)):
                                        $grade_D_id = Grade::find()->where(['academic_year_id' => $model->academic_year_id, 'nta_level' => $model->nta_level, 'grade' => 'D'])->one()->id;
                                        $final_results->grade_id = $grade_D_id;
                                        $final_results->remarks = "Supplementary";
                                        $final_results->points =1*$module_credit;
                                        break;

                                    case(($final_results->total_score == $grade_F_lower ||$final_results->total_score >$grade_F_lower) && ($final_results->total_score == $grade_F_upper||$final_results->total_score <$grade_F_upper)):
                                        $grade_F_id = Grade::find()->where(['academic_year_id' => $model->academic_year_id, 'nta_level' => $model->nta_level, 'grade' => 'F'])->one()->id;
                                        $final_results->grade_id = $grade_F_id;
                                        $final_results->remarks = "Supplementary";
                                        $final_results->points =0*$module_credit;
                                        break;

                                }

                            }
                            //GRADE SCHEME FOR NTA 6
                            if($model->nta_level==6){
                                $grade_A_lower = Grade::find()->where(['academic_year_id' => $model->academic_year_id, 'nta_level' => $model->nta_level, 'grade' => 'A'])->one()->lower_score;
                                $grade_A_upper = Grade::find()->where(['academic_year_id' => $model->academic_year_id, 'nta_level' => $model->nta_level, 'grade' => 'A'])->one()->upper_score;
                                $grade_Bplus_lower = Grade::find()->where(['academic_year_id' => $model->academic_year_id, 'nta_level' => $model->nta_level, 'grade' => 'B+'])->one()->lower_score;
                                $grade_Bplus_upper = Grade::find()->where(['academic_year_id' => $model->academic_year_id, 'nta_level' => $model->nta_level, 'grade' => 'B+'])->one()->upper_score;
                                $grade_B_lower = Grade::find()->where(['academic_year_id' => $model->academic_year_id, 'nta_level' => $model->nta_level, 'grade' => 'B'])->one()->lower_score;
                                $grade_B_upper = Grade::find()->where(['academic_year_id' => $model->academic_year_id, 'nta_level' => $model->nta_level, 'grade' => 'B'])->one()->upper_score;
                                $grade_C_lower = Grade::find()->where(['academic_year_id' => $model->academic_year_id, 'nta_level' => $model->nta_level, 'grade' => 'C'])->one()->lower_score;
                                $grade_C_upper = Grade::find()->where(['academic_year_id' => $model->academic_year_id, 'nta_level' => $model->nta_level, 'grade' => 'C'])->one()->upper_score;
                                $grade_D_lower = Grade::find()->where(['academic_year_id' => $model->academic_year_id, 'nta_level' => $model->nta_level, 'grade' => 'D'])->one()->lower_score;
                                $grade_D_upper = Grade::find()->where(['academic_year_id' => $model->academic_year_id, 'nta_level' => $model->nta_level, 'grade' => 'D'])->one()->upper_score;
                                $grade_F_lower = Grade::find()->where(['academic_year_id' => $model->academic_year_id, 'nta_level' => $model->nta_level, 'grade' => 'F'])->one()->lower_score;
                                $grade_F_upper = Grade::find()->where(['academic_year_id' => $model->academic_year_id, 'nta_level' => $model->nta_level, 'grade' => 'F'])->one()->upper_score;

                                //SWITCHING CASE FOR GRADE
                                switch ($final_results->total_score) {
                                    case (($final_results->total_score == $grade_A_lower || $final_results->total_score > $grade_A_lower) && ($final_results->total_score == $grade_A_upper || $final_results->total_score < $grade_A_upper)):
                                        $grade_A_id = Grade::find()->where(['academic_year_id' => $model->academic_year_id, 'nta_level' => $model->nta_level, 'grade' => 'A'])->one()->id;
                                        $final_results->grade_id = $grade_A_id;
                                        $final_results->remarks = "Pass";
                                        $final_results->points =5*$module_credit;
                                        break;


                                    case (($final_results->total_score == $grade_Bplus_lower || $final_results->total_score > $grade_Bplus_lower) && ($final_results->total_score == $grade_Bplus_upper || $final_results->total_score < $grade_Bplus_upper)):
                                        $grade_Bplus_id = Grade::find()->where(['academic_year_id' => $model->academic_year_id, 'nta_level' => $model->nta_level, 'grade' => 'B+'])->one()->id;
                                        $final_results->grade_id = $grade_Bplus_id;
                                        $final_results->remarks = "Pass";
                                        $final_results->points =4*$module_credit;
                                        break;

                                    case (($final_results->total_score == $grade_B_lower || $final_results->total_score > $grade_B_lower) && ($final_results->total_score == $grade_B_upper || $final_results->total_score < $grade_B_upper)):
                                        $grade_B_id = Grade::find()->where(['academic_year_id' => $model->academic_year_id, 'nta_level' => $model->nta_level, 'grade' => 'B'])->one()->id;
                                        $final_results->grade_id = $grade_B_id;
                                        $final_results->remarks = "Pass";
                                        $final_results->points =3*$module_credit;
                                        break;


                                    case (( $final_results->total_score== $grade_C_lower ||  $final_results->total_score> $grade_C_lower) && ( $final_results->total_score== $grade_C_upper || $final_results->total_score< $grade_C_upper)):
                                        $grade_C_id = Grade::find()->where(['academic_year_id' => $model->academic_year_id, 'nta_level' => $model->nta_level, 'grade' => 'C'])->one()->id;
                                        $final_results->grade_id = $grade_C_id;
                                        $final_results->remarks = "Pass";
                                        $final_results->points =2*$module_credit;
                                        break;

                                    case(( $final_results->total_score == $grade_D_lower|| $final_results->total_score > $grade_D_lower) && ($final_results->total_score==$grade_D_upper||$final_results->total_score<$grade_D_upper)):
                                        $grade_D_id = Grade::find()->where(['academic_year_id' => $model->academic_year_id, 'nta_level' => $model->nta_level, 'grade' => 'D'])->one()->id;
                                        $final_results->grade_id = $grade_D_id;
                                        $final_results->remarks = "Supplementary";
                                        $final_results->points =1*$module_credit;
                                        break;

                                    case(($final_results->total_score == $grade_F_lower ||$final_results->total_score >$grade_F_lower) && ($final_results->total_score == $grade_F_upper||$final_results->total_score <$grade_F_upper)):
                                        $grade_F_id = Grade::find()->where(['academic_year_id' => $model->academic_year_id, 'nta_level' => $model->nta_level, 'grade' => 'F'])->one()->id;
                                        $final_results->grade_id = $grade_F_id;
                                        $final_results->remarks = "Supplementary";
                                        $final_results->points=0*$module_credit;
                                        break;

                                }

                            }

                            if($final_results->save(false)){
                                if($final_results->remarks=='Supplementary'){
                                    $sups=new Supplementary();
                                    $sups->student_id=$students['student_id'];
                                    $sups->module_id=$model->module_id;
                                    $sups->course_id=$model->course_id;
                                    $sups->nta_level=$model->nta_level;
                                    $sups->academic_year_id=$model->academic_year_id;
                                    $sups->semester_id=$model->semester_id;
                                    //$sups->staff_id=Yii::$app->user->identity->id;
                                    $sups->save(false);
                                }
                            }
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


    //UPLOAD SOMO LENYE THREE FINALS
//    public function actionCreate()
//    {
//
//        $model = new FinalExam();
//
//
//        if ($model->load(Yii::$app->request->post())) {
//            $selected_course=$model->course_id;
//            $selected_module=$model->module_id;
//
//
//            // $year_of_stud=YearOfStudy::find()->where(['id'=>$model->year_of_study_id])->one()->name;
//            $courseworks4_results_exists= CourseworkNta4::find()->where([ 'semester_id' =>$model->semester_id, 'module_id' => $model->module_id, 'academic_year_id' =>$model->academic_year_id,'course_id'=>$model->course_id])->exists();
//            $courseworks5_results_exists= CourseworkNta5::find()->where([ 'semester_id' =>$model->semester_id, 'module_id' => $model->module_id, 'academic_year_id' =>$model->academic_year_id,'course_id'=>$model->course_id])->exists();
//            $courseworks6_results_exists= CourseworkNta6::find()->where([ 'semester_id' =>$model->semester_id, 'module_id' => $model->module_id, 'academic_year_id' =>$model->academic_year_id,'course_id'=>$model->course_id])->exists();
//
//            //CHECKING COURSEWORKS NTA4
//            if ($model->nta_level==4) {
//                if (!$courseworks4_results_exists){
//                    Yii::$app->session->setFlash('getDanger','<span class="fa fa-warning"> Please Upload All Continuous Assessment Results!</span>');
//                    return $this->render('create', ['model' => $model]);
//                }
//
//                if($courseworks4_results_exists){
//                    $courseworks4_results_score= CourseworkNta4::find()->where([ 'semester_id' =>$model->semester_id, 'module_id' => $model->module_id, 'academic_year_id' =>$model->academic_year_id,'course_id'=>$model->course_id])->one()->total_score;
//                    if (empty($courseworks4_results_score)){
//                        Yii::$app->session->setFlash('getDanger','<span class="fa fa-warning"> Please Upload All Continuous Assessment Results!</span>');
//                        return $this->render('create', ['model' => $model]);
//                    }
//                }
//            }
//
//            //CHECKING COURSEWORKS NTA5
//            if ($model->nta_level==5) {
//                if (!$courseworks5_results_exists){
//                    Yii::$app->session->setFlash('getDanger','<span class="fa fa-warning">Please Upload All Continuous Assessment Results!</span>');
//                    return $this->render('create', ['model' => $model]);
//                }
//
//                if($courseworks5_results_exists){
//                    $courseworks5_results_score= CourseworkNta5::find()->where([ 'semester_id' =>$model->semester_id, 'module_id' => $model->module_id, 'academic_year_id' =>$model->academic_year_id,'course_id'=>$model->course_id])->one()->total_score;
//                    if (empty($courseworks5_results_score)){
//                        Yii::$app->session->setFlash('getDanger','<span class="fa fa-warning"> Please Upload All Continuous Assessment Results!</span>');
//                        return $this->render('create', ['model' => $model]);
//                    }
//                }
//            }
//            //CHECKING COURSEWORKS NTA6
//            if ($model->nta_level==6) {
//                if (!$courseworks6_results_exists){
//                    Yii::$app->session->setFlash('getDanger','<span class="fa fa-warning">Please Upload All Continuous Assessment Results!</span>');
//                    return $this->render('create', ['model' => $model]);
//                }
//                if($courseworks6_results_exists){
//                    $courseworks6_results_score= CourseworkNta6::find()->where([ 'semester_id' =>$model->semester_id, 'module_id' => $model->module_id, 'academic_year_id' =>$model->academic_year_id,'course_id'=>$model->course_id])->one()->total_score;
//                    if (empty($courseworks6_results_score)){
//                        Yii::$app->session->setFlash('getDanger','<span class="fa fa-warning">Please Upload All Continuous Assessment Results!</span>');
//                        return $this->render('create', ['model' => $model]);
//                    }
//                }
//            }
//
//
//            $module=Module::find()->where(['course_id'=>$selected_course,'id'=>$selected_module])->exists();
//            if (!$module){
//                Yii::$app->session->setFlash('getDanger','<span class="fa fa-warning">Please select relevant module for the selected course!</span>');
//                return $this->render('create', ['model' => $model]);
//            }
//
//
//            $model->csv_file = UploadedFile::getInstance($model, 'csv_file');
//            $time = date('Ymd-His');
//            $model->csv_file->saveAs('csv/'. $time.'.' . $model->csv_file->extension);
//            $model->csv_file ='csv/'. $time . '.' . $model->csv_file->extension;
//            $handle = fopen($model->csv_file, "r");
//            $file = fopen( $model->csv_file, "r");
//            $allowedColNum=4;
//
//            //  checking for an empty file
//            if (filesize($model->csv_file)==0){
//                Yii::$app->session->setFlash('getDanger',"<span class='fa fa-warning'> Empty file uploaded! Please upload correct file</span>");
//                return $this->render('create', ['model' => $model]);
//            }
//            while ($line = fgetcsv($file)){
//                // count($line) is the number of columns
//                $numcols = count($line);
//
//                // Terminate  the loop if columns are incorrect
//                if($numcols!= $allowedColNum) {
//                    Yii::$app->session->setFlash('getDanger',"<span class=' fa fa-warning'> Invalid file Uploaded! Please check your CSV file</span>");
//                    return $this->render('create', ['model' => $model]);
//                }
//
//
//                else{
//                    $header=true;
//                    while (($fileop = fgetcsv($handle, 1000, ",")) !== false) {
//                        if($header){
//                            $header=false;
//                            continue;
//                        }
////
//
//                        $model->nta_level=Course::find()->where(['id'=>$model->course_id])->one()->nta_level;
//                        $assessment_methods_id_ipo=AssessmentMethod::find()->where(['name'=>'Written Examination','nta_level'=>$model->nta_level])->exists();
//                        if($assessment_methods_id_ipo){
//                            $assessment_methods_id=AssessmentMethod::find()->where(['name'=>'Written Examination','nta_level'=>$model->nta_level])->one()->id;
//                            $assessment_methods_id_prac_id=AssessmentMethod::find()->where(['name'=>'Practical Examination','nta_level'=>$model->nta_level])->one()->id;
//                            $assessment_methods_id_clic_id=AssessmentMethod::find()->where(['name'=>'Clinical Examination','nta_level'=>$model->nta_level])->one()->id;
//                            $assessment_methods_id_project_ipo=AssessmentMethod::find()->where(['name'=>'Project Work','nta_level'=>$model->nta_level])->exists();
//                            $assessment_methods_id_presentation_ipo=AssessmentMethod::find()->where(['name'=>'Research report presentation','nta_level'=>$model->nta_level])->exists();
//                            $assessment_methods_id_report_ipo=AssessmentMethod::find()->where(['name'=>'Research Report','nta_level'=>$model->nta_level])->exists();
//
//
//                            if ($assessment_methods_id_project_ipo){
//                                $assessment_methods_id_project=AssessmentMethod::find()->where(['name'=>'Project Work','nta_level'=>$model->nta_level])->one()->id;
//                                $project_work_parcent_exists=AssessmentMethodTracking::find()->where(['assessment_method_id'=>$assessment_methods_id_project,'module_id'=>$model->module_id,'category'=>'SE'])->exists();
//
//                            }
//                            if ($assessment_methods_id_presentation_ipo){
//                                $assessment_methods_id_presentation=AssessmentMethod::find()->where(['name'=>'Research report presentation','nta_level'=>$model->nta_level])->one()->id;
//
//                            }
//                            if ($assessment_methods_id_report_ipo){
//                                $assessment_methods_id_report=AssessmentMethod::find()->where(['name'=>'Research Report','nta_level'=>$model->nta_level])->one()->id;
//
//                            }
//
//
//                        }
//                        else{
//                            $assessment_methods_id=AssessmentMethod::find()->where(['name'=>'Written Examination'])->one()->id;
//                            $assessment_methods_id_prac_id=AssessmentMethod::find()->where(['name'=>'Practical Examination'])->one()->id;
//                            $assessment_methods_id_clic_id=AssessmentMethod::find()->where(['name'=>'Clinical Examination'])->one()->id;
//                            $assessment_methods_id_project=AssessmentMethod::find()->where(['name'=>'Project Work'])->one()->id;
//
//
//                        }
//
//                        //$assessment_methods_id1=AssessmentMethod::find()->where(['name'=>'Practical Examination'])->one()->id;
//
//
//
//
//                        // $assessment_methods_id_prac_id=AssessmentMethod::find()->where(['name'=>'Practical Examination','nta_level'=>$model->nta_level])->one()->id;
//                        //$assessment_methods_id_clic_id=AssessmentMethod::find()->where(['name'=>'Clinical Examination','nta_level'=>$model->nta_level])->one()->id;
//
//
//
//
//
//
//                        $written_exam_parcent=AssessmentMethodTracking::find()->where(['assessment_method_id'=>$assessment_methods_id,'module_id'=>$model->module_id,'category'=>'SE'])->one()->percent;
//                        $practical_exam_parcent_exists=AssessmentMethodTracking::find()->where(['assessment_method_id'=>$assessment_methods_id_prac_id,'module_id'=>$model->module_id,'category'=>'SE'])->exists();
//                        $clinical_exam_parcent_exists=AssessmentMethodTracking::find()->where(['assessment_method_id'=>$assessment_methods_id_clic_id,'module_id'=>$model->module_id,'category'=>'SE'])->exists();
//                        $presentation_parcent_exists=AssessmentMethodTracking::find()->where(['assessment_method_id'=>$assessment_methods_id_presentation,'module_id'=>$model->module_id,'category'=>'SE'])->exists();
//                        $report_exam_parcent_exists=AssessmentMethodTracking::find()->where(['assessment_method_id'=>$assessment_methods_id_report,'module_id'=>$model->module_id,'category'=>'SE'])->exists();
//
////                        if ($project_work_parcent_exists){
////                            $project_work_parcent=AssessmentMethodTracking::find()->where(['assessment_method_id'=>$assessment_methods_id_project,'module_id'=>$model->module_id,'category'=>'SE'])->one()->percent;
////                        }
//
//                        if ($presentation_parcent_exists){
//                            $presentation_parcent=AssessmentMethodTracking::find()->where(['assessment_method_id'=>$assessment_methods_id_presentation,'module_id'=>$model->module_id,'category'=>'SE'])->one()->percent;
//
//                        }
//
//
//
//
//                        if ($practical_exam_parcent_exists){
//                            $practical_exam_parcent=AssessmentMethodTracking::find()->where(['assessment_method_id'=>$assessment_methods_id_prac_id,'module_id'=>$model->module_id,'category'=>'SE'])->one()->percent;
//                        }
//                        elseif ($clinical_exam_parcent_exists){
//                            $practical_exam_parcent=AssessmentMethodTracking::find()->where(['assessment_method_id'=>$assessment_methods_id_clic_id,'module_id'=>$model->module_id,'category'=>'SE'])->one()->percent;
//                        }
//                        elseif ($report_exam_parcent_exists){
//                            $practical_exam_parcent=AssessmentMethodTracking::find()->where(['assessment_method_id'=>$assessment_methods_id_report,'module_id'=>$model->module_id,'category'=>'SE'])->one()->percent;
//
//
//                        }
//                        else{
//                            $practical_exam_parcent=0;
//                        }
//
////var_dump($practical_exam_parcent);die();
//
//                        $registration_number= $fileop[0];
//                        $written_exam= $fileop[1];
//                        $practical=$fileop[2];
//                        //Project work==Report Presentation
//                        $project_work=$fileop[3];
//                        $total_score=(($fileop[1]/100)*$written_exam_parcent+($fileop[2]/100)*$practical_exam_parcent +($fileop[3]/100)*$presentation_parcent);
//
//                        $nta=$model->nta_level;
//                        $module=$model->module_id;
//                        $course=$model->course_id;
//                        $academic_year=$model->academic_year_id;
//                        $semester=$model->semester_id;
//                        $created_by=Yii::$app->user->identity->id;
//                        $student_id=Student::find()->where(['registration_number'=>$registration_number])->one()->id;
//                        //var_dump($total_score);
//                        $sql="INSERT INTO final_exam(total_score,student_id,registration_number,module_id ,course_id,academic_year_id ,semester_id,nta_level,written_exam,practical,project_work,created_by) VALUES ('$total_score','$student_id','$registration_number','$module','$course','$academic_year','$semester','$nta','$written_exam','$practical','$project_work','$created_by')";
//                        $query = Yii::$app->db->createCommand($sql)->execute();
//
//                    }
//                    if($query) {
//                        unlink($model->csv_file);
//                        //GENERATING EXAM RESULTS
//                        $all_students=FinalExam::find()->where(['module_id'=>$model->module_id,'course_id'=>$model->course_id,'academic_year_id'=>$model->academic_year_id,'semester_id'=>$model->semester_id])->all();
//
//
//                        foreach($all_students as $students) {
//                            $final_results = new ExamResult();
//                            $final_results->student_id = $students['student_id'];
//                            $final_results->module_id = $students['module_id'];
//                            $final_results->academic_year_id = $students['academic_year_id'];
//                            $final_results->nta_level = $students['nta_level'];
//                            $final_results->course_id = $students['course_id'];
//                            $final_results->semester_id = $students['semester_id'];
//                            $final_results->final_exam_id = $students['id'];
//                            $final_results->created_by = Yii::$app->user->identity->id;
//                            $final_results->final_exam_score = $students['total_score'];
//                            if ($model->nta_level==4) {
//
//                                $final_results->coursework = CourseworkNta4::find()->where(['student_id' => $students['student_id'], 'semester_id' => $students['semester_id'], 'module_id' => $students['module_id'], 'academic_year_id' => $students['academic_year_id']])->one()->total_score;
//                            }
//                            if ($model->nta_level==5) {
//                                $final_results->coursework = CourseworkNta5::find()->where(['student_id' => $students['student_id'], 'semester_id' => $students['semester_id'], 'module_id' => $students['module_id'], 'academic_year_id' => $students['academic_year_id']])->one()->total_score;
//                            }
//                            if ($model->nta_level==6) {
//                                $final_results->coursework = CourseworkNta6::find()->where(['student_id' => $students['student_id'], 'semester_id' => $students['semester_id'], 'module_id' => $students['module_id'], 'academic_year_id' => $students['academic_year_id']])->one()->total_score;
//                            }
//                            $final_results->total_score = round($students['total_score'] + $final_results->coursework,0);
//
//
//                            $module_credit=Module::find()->where(['id'=>$model->module_id])->one()->module_credit;
//                            //GRADE SCHEME FOR NTA 4 AND 5
//                            if($model->nta_level==4||$model->nta_level==5){
//                                $grade_A_lower = Grade::find()->where(['academic_year_id' => $model->academic_year_id, 'nta_level' => $model->nta_level, 'grade' => 'A'])->one()->lower_score;
//                                $grade_A_upper = Grade::find()->where(['academic_year_id' => $model->academic_year_id, 'nta_level' => $model->nta_level, 'grade' => 'A'])->one()->upper_score;
//                                $grade_B_lower = Grade::find()->where(['academic_year_id' => $model->academic_year_id, 'nta_level' => $model->nta_level, 'grade' => 'B'])->one()->lower_score;
//                                $grade_B_upper = Grade::find()->where(['academic_year_id' => $model->academic_year_id, 'nta_level' => $model->nta_level, 'grade' => 'B'])->one()->upper_score;
//                                $grade_C_lower = Grade::find()->where(['academic_year_id' => $model->academic_year_id, 'nta_level' => $model->nta_level, 'grade' => 'C'])->one()->lower_score;
//                                $grade_C_upper = Grade::find()->where(['academic_year_id' => $model->academic_year_id, 'nta_level' => $model->nta_level, 'grade' => 'C'])->one()->upper_score;
//                                $grade_D_lower = Grade::find()->where(['academic_year_id' => $model->academic_year_id, 'nta_level' => $model->nta_level, 'grade' => 'D'])->one()->lower_score;
//                                $grade_D_upper = Grade::find()->where(['academic_year_id' => $model->academic_year_id, 'nta_level' => $model->nta_level, 'grade' => 'D'])->one()->upper_score;
//                                $grade_F_lower = Grade::find()->where(['academic_year_id' => $model->academic_year_id, 'nta_level' => $model->nta_level, 'grade' => 'F'])->one()->lower_score;
//                                $grade_F_upper = Grade::find()->where(['academic_year_id' => $model->academic_year_id, 'nta_level' => $model->nta_level, 'grade' => 'F'])->one()->upper_score;
//
//                                //SWITCHING CASE FOR GRADE
//                                switch ($final_results->total_score) {
//                                    case (($final_results->total_score == $grade_A_lower || $final_results->total_score > $grade_A_lower) && ($final_results->total_score == $grade_A_upper || $final_results->total_score < $grade_A_upper)):
//                                        $grade_A_id = Grade::find()->where(['academic_year_id' => $model->academic_year_id, 'nta_level' => $model->nta_level, 'grade' => 'A'])->one()->id;
//                                        $final_results->grade_id = $grade_A_id;
//                                        $final_results->remarks = "Pass";
//                                        $final_results->points =4*$module_credit;
//                                        break;
//
//
//                                    case (($final_results->total_score == $grade_B_lower || $final_results->total_score > $grade_B_lower) && ($final_results->total_score == $grade_B_upper || $final_results->total_score < $grade_B_upper)):
//                                        $grade_B_id = Grade::find()->where(['academic_year_id' => $model->academic_year_id, 'nta_level' => $model->nta_level, 'grade' => 'B'])->one()->id;
//                                        $final_results->grade_id = $grade_B_id;
//                                        $final_results->remarks = "Pass";
//                                        $final_results->points =3*$module_credit;
//                                        break;
//
//
//                                    case (( $final_results->total_score== $grade_C_lower ||  $final_results->total_score> $grade_C_lower) && ( $final_results->total_score== $grade_C_upper || $final_results->total_score< $grade_C_upper)):
//                                        $grade_C_id = Grade::find()->where(['academic_year_id' => $model->academic_year_id, 'nta_level' => $model->nta_level, 'grade' => 'C'])->one()->id;
//                                        $final_results->grade_id = $grade_C_id;
//                                        $final_results->remarks = "Pass";
//                                        $final_results->points =2*$module_credit;
//                                        break;
//
//                                    case(( $final_results->total_score == $grade_D_lower|| $final_results->total_score > $grade_D_lower) && ($final_results->total_score==$grade_D_upper||$final_results->total_score<$grade_D_upper)):
//                                        $grade_D_id = Grade::find()->where(['academic_year_id' => $model->academic_year_id, 'nta_level' => $model->nta_level, 'grade' => 'D'])->one()->id;
//                                        $final_results->grade_id = $grade_D_id;
//                                        $final_results->remarks = "Supplementary";
//                                        $final_results->points =1*$module_credit;
//                                        break;
//
//                                    case(($final_results->total_score == $grade_F_lower ||$final_results->total_score >$grade_F_lower) && ($final_results->total_score == $grade_F_upper||$final_results->total_score <$grade_F_upper)):
//                                        $grade_F_id = Grade::find()->where(['academic_year_id' => $model->academic_year_id, 'nta_level' => $model->nta_level, 'grade' => 'F'])->one()->id;
//                                        $final_results->grade_id = $grade_F_id;
//                                        $final_results->remarks = "Supplementary";
//                                        $final_results->points =0*$module_credit;
//                                        break;
//
//                                }
//
//                            }
//                            //GRADE SCHEME FOR NTA 6
//                            if($model->nta_level==6){
//                                $grade_A_lower = Grade::find()->where(['academic_year_id' => $model->academic_year_id, 'nta_level' => $model->nta_level, 'grade' => 'A'])->one()->lower_score;
//                                $grade_A_upper = Grade::find()->where(['academic_year_id' => $model->academic_year_id, 'nta_level' => $model->nta_level, 'grade' => 'A'])->one()->upper_score;
//                                $grade_Bplus_lower = Grade::find()->where(['academic_year_id' => $model->academic_year_id, 'nta_level' => $model->nta_level, 'grade' => 'B+'])->one()->lower_score;
//                                $grade_Bplus_upper = Grade::find()->where(['academic_year_id' => $model->academic_year_id, 'nta_level' => $model->nta_level, 'grade' => 'B+'])->one()->upper_score;
//                                $grade_B_lower = Grade::find()->where(['academic_year_id' => $model->academic_year_id, 'nta_level' => $model->nta_level, 'grade' => 'B'])->one()->lower_score;
//                                $grade_B_upper = Grade::find()->where(['academic_year_id' => $model->academic_year_id, 'nta_level' => $model->nta_level, 'grade' => 'B'])->one()->upper_score;
//                                $grade_C_lower = Grade::find()->where(['academic_year_id' => $model->academic_year_id, 'nta_level' => $model->nta_level, 'grade' => 'C'])->one()->lower_score;
//                                $grade_C_upper = Grade::find()->where(['academic_year_id' => $model->academic_year_id, 'nta_level' => $model->nta_level, 'grade' => 'C'])->one()->upper_score;
//                                $grade_D_lower = Grade::find()->where(['academic_year_id' => $model->academic_year_id, 'nta_level' => $model->nta_level, 'grade' => 'D'])->one()->lower_score;
//                                $grade_D_upper = Grade::find()->where(['academic_year_id' => $model->academic_year_id, 'nta_level' => $model->nta_level, 'grade' => 'D'])->one()->upper_score;
//                                $grade_F_lower = Grade::find()->where(['academic_year_id' => $model->academic_year_id, 'nta_level' => $model->nta_level, 'grade' => 'F'])->one()->lower_score;
//                                $grade_F_upper = Grade::find()->where(['academic_year_id' => $model->academic_year_id, 'nta_level' => $model->nta_level, 'grade' => 'F'])->one()->upper_score;
//
//                                //SWITCHING CASE FOR GRADE
//                                switch ($final_results->total_score) {
//                                    case (($final_results->total_score == $grade_A_lower || $final_results->total_score > $grade_A_lower) && ($final_results->total_score == $grade_A_upper || $final_results->total_score < $grade_A_upper)):
//                                        $grade_A_id = Grade::find()->where(['academic_year_id' => $model->academic_year_id, 'nta_level' => $model->nta_level, 'grade' => 'A'])->one()->id;
//                                        $final_results->grade_id = $grade_A_id;
//                                        $final_results->remarks = "Pass";
//                                        $final_results->points =5*$module_credit;
//                                        break;
//
//
//                                    case (($final_results->total_score == $grade_Bplus_lower || $final_results->total_score > $grade_Bplus_lower) && ($final_results->total_score == $grade_Bplus_upper || $final_results->total_score < $grade_Bplus_upper)):
//                                        $grade_Bplus_id = Grade::find()->where(['academic_year_id' => $model->academic_year_id, 'nta_level' => $model->nta_level, 'grade' => 'B+'])->one()->id;
//                                        $final_results->grade_id = $grade_Bplus_id;
//                                        $final_results->remarks = "Pass";
//                                        $final_results->points =4*$module_credit;
//                                        break;
//
//                                    case (($final_results->total_score == $grade_B_lower || $final_results->total_score > $grade_B_lower) && ($final_results->total_score == $grade_B_upper || $final_results->total_score < $grade_B_upper)):
//                                        $grade_B_id = Grade::find()->where(['academic_year_id' => $model->academic_year_id, 'nta_level' => $model->nta_level, 'grade' => 'B'])->one()->id;
//                                        $final_results->grade_id = $grade_B_id;
//                                        $final_results->remarks = "Pass";
//                                        $final_results->points =3*$module_credit;
//                                        break;
//
//
//                                    case (( $final_results->total_score== $grade_C_lower ||  $final_results->total_score> $grade_C_lower) && ( $final_results->total_score== $grade_C_upper || $final_results->total_score< $grade_C_upper)):
//                                        $grade_C_id = Grade::find()->where(['academic_year_id' => $model->academic_year_id, 'nta_level' => $model->nta_level, 'grade' => 'C'])->one()->id;
//                                        $final_results->grade_id = $grade_C_id;
//                                        $final_results->remarks = "Pass";
//                                        $final_results->points =2*$module_credit;
//                                        break;
//
//                                    case(( $final_results->total_score == $grade_D_lower|| $final_results->total_score > $grade_D_lower) && ($final_results->total_score==$grade_D_upper||$final_results->total_score<$grade_D_upper)):
//                                        $grade_D_id = Grade::find()->where(['academic_year_id' => $model->academic_year_id, 'nta_level' => $model->nta_level, 'grade' => 'D'])->one()->id;
//                                        $final_results->grade_id = $grade_D_id;
//                                        $final_results->remarks = "Supplementary";
//                                        $final_results->points =1*$module_credit;
//                                        break;
//
//                                    case(($final_results->total_score == $grade_F_lower ||$final_results->total_score >$grade_F_lower) && ($final_results->total_score == $grade_F_upper||$final_results->total_score <$grade_F_upper)):
//                                        $grade_F_id = Grade::find()->where(['academic_year_id' => $model->academic_year_id, 'nta_level' => $model->nta_level, 'grade' => 'F'])->one()->id;
//                                        $final_results->grade_id = $grade_F_id;
//                                        $final_results->remarks = "Supplementary";
//                                        $final_results->points=0*$module_credit;
//                                        break;
//
//                                }
//
//                            }
//
//                            if($final_results->save(false)){
//                                if($final_results->remarks=='Supplementary'){
//                                    $sups=new Supplementary();
//                                    $sups->student_id=$students['student_id'];
//                                    $sups->module_id=$model->module_id;
//                                    $sups->course_id=$model->course_id;
//                                    $sups->nta_level=$model->nta_level;
//                                    $sups->academic_year_id=$model->academic_year_id;
//                                    $sups->semester_id=$model->semester_id;
//                                    //$sups->staff_id=Yii::$app->user->identity->id;
//                                    $sups->save(false);
//                                }
//                            }
//                        }
//                        Yii::$app->session->setFlash('getSuccess', '<span class="fa fa-check-square-o"> Congratulations! Results uploaded successfully</span>');
//                        return $this->redirect(['index']);
//                    }
//
//                }
//            }
//
//        }
//
//        return $this->render('create', [
//            'model' => $model,
//        ]);
//    }

    /**
     * Updates an existing FinalExam model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {

        $model = $this->findModel($id);
        $assessment_methods_id=AssessmentMethod::find()->where(['name'=>'Written Examination'])->one()->id;
        $assessment_methods_id1=AssessmentMethod::find()->where(['name'=>'Practical Examination'])->one()->id;
        $written_exam_parcent=AssessmentMethodTracking::find()->where(['assessment_method_id'=>$assessment_methods_id,'module_id'=>$model->module_id,'category'=>'SE'])->one()->percent;
        $practical_exam_parcent=AssessmentMethodTracking::find()->where(['assessment_method_id'=>$assessment_methods_id1,'module_id'=>$model->module_id,'category'=>'SE'])->one()->percent;

        if ($model->load(Yii::$app->request->post())) {

            $model->total_score=(($model->written_exam/100)*$written_exam_parcent+($model->practical/100)*$practical_exam_parcent);

            if ($model->save(false)){
                Yii::$app->session->setFlash('getSuccess', '<span class="fa fa-check-square-o"> Congratulations! Changes saved successfully</span>');
                return $this->redirect(['view', 'id' => $model->id]);
            }

        }
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing FinalExam model.
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
     * Finds the FinalExam model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return FinalExam the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = FinalExam::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionListsmodule($id){
        $active_semester=\common\models\Semester::find()->where(['status'=>'Active'])->one()->id;
        $ids = preg_split('/,/', $id);
        $module = \common\models\Module::find()
            ->where(['IN','course_id',$ids])
            ->andWhere(['semester_id'=>$active_semester])
            ->orderBy('module_name ASC')
            ->all();
        if (!empty($module)) {
            foreach($module as $mod) {
                echo "<option value =''> ----- Select Module ----- </option>";
                echo "<option value='".$mod->id."'>".$mod->module_name."</option>";
            }
        }
    }
}
