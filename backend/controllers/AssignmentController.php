<?php

namespace backend\controllers;

use common\helpers\ImportHelper;
use common\models\AssessmentMethod;
use common\models\AssessmentMethodTracking;
use common\models\Course;
use common\models\CourseworkNta4;
use common\models\CourseworkNta5;
use common\models\CourseworkNta6;
use common\models\Module;
use common\models\Semester;
use common\models\Student;
use common\models\UserAccount;
use common\models\YearOfStudy;
use Yii;
use common\models\Assignment;
use common\models\search\AssignmentSearch;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\filters\AccessControl;

/**
 * AssignmentController implements the CRUD actions for Assignment model.
 */
class AssignmentController extends Controller
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
     * Lists all Assignment models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AssignmentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        //$dataProvider = new ActiveDataProvider(['query'=>Assignment::find()->where(['created_by'=>Yii::$app->user->identity->user_id,'semester_id'=>$active_semester])]);


        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Assignment model.
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
     * Creates a new Assignment model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Assignment();

        if ($model->load(Yii::$app->request->post()) ) {

            $model->csv_file = UploadedFile::getInstance($model, 'csv_file');
            if ($model->csv_file) {
                $time = time();
                //$model->csv_file->saveAs('csv/' . $time . '.' . $model->csv_file->extension);
                $filename = 'csv/' . $time . '.' . $model->csv_file->extension;



                if ($model->csv_file->saveAs($filename)) {
                    $file = fopen($filename, 'r+');
                    $line = 0;
                    $header = [];
                    $transaction = Yii::$app->db->beginTransaction();
                    try {

                        $previous_row = null;
                        while ($file && $row = fgetcsv($file)) {


                            // count($line) is the number of columns
                            $numcols = count($row);
                            $allowedColNum=2;
                            // Terminate  the loop if columns are incorrect
                            if($numcols!= $allowedColNum) {
                                Yii::$app->session->setFlash('getDanger'," <span class='fa fa-close'> Invalid File Uploaded! Please Check your CSV file</span>");
                                return $this->redirect(['assignment/create']);
                            }
                            //$model = new Assignment();
                            $line++;
                            if ($line == 1) {
                                $header = $row;
                            } else {
                                $registration_number= $row[0];
                                $score= $row[1];
                                $assessment_method=$model->assessment_method_id;
                                $module=$model->module_id;
                                $course=$model->course_id;
                                $year_of_study=Course::find()->where(['id'=>$model->course_id])->one()->nta_level;
                                $academic_year=$model->academic_year_id;
                                $semester=$model->semester_id;
                                $created_by=Yii::$app->user->identity->id;
                                //$student_id= Student::find()->where(['registration_number'=>$row[0]])->one()->id;
                                $student_id= ImportHelper::value2Id(Student::className(), 'registration_number',$row[0]);


                                $sql="INSERT INTO assignment (student_id,registration_number,assessment_method_id,module_id ,course_id ,nta_level ,academic_year_id ,semester_id ,score,created_by) VALUES ('$student_id','$registration_number','$assessment_method','$module','$course','$year_of_study','$academic_year','$semester','$score','$created_by')";
                                $query = Yii::$app->db->createCommand($sql)->execute();

                            }
                        }

                        if($query){

                            //unlink($model->csv_file);
                            //INSERT INTO COURSEWORK
                            $year_of_studies=Course::find()->where(['id'=>$model->course_id])->one()->nta_level;
                            $all_students=Assignment::find()->where(['assessment_method_id'=>$model->assessment_method_id,'module_id'=>$model->module_id,'course_id'=>$model->course_id,'academic_year_id'=>$model->academic_year_id,'semester_id'=>$model->semester_id])->all();


                            //NTA 4
                            if($year_of_studies=='4'){

                                $student_exist=CourseworkNta4::find()->where(['student_id'=>Student::find()->where(['registration_number'=>$registration_number])->one()->id,'semester_id'=>$model->semester_id,'module_id'=>$model->module_id,'academic_year_id'=>$model->academic_year_id])->exists();
                                $assessment_methods=AssessmentMethod::find()->where(['id'=>$model->assessment_method_id])->one()->name;

                                if($student_exist) {

                                    $all_students = Assignment::find()->where(['assessment_method_id' => $model->assessment_method_id, 'module_id' => $model->module_id, 'course_id' => $model->course_id, 'academic_year_id' => $model->academic_year_id, 'semester_id' => $model->semester_id])->all();
                                    foreach ($all_students as $students) {
                                        $student_exists = CourseworkNta4::find()->where(['student_id' => $students['student_id'], 'semester_id' =>$students['semester_id'], 'module_id' =>$students['module_id'], 'academic_year_id' => $students['academic_year_id']])->one();
                                        if ($assessment_methods == 'CAT 1') {
                                            $assessment_methods_id=AssessmentMethod::find()->where(['name'=>'CAT 1','nta_level'=>'4'])->one()->id;
                                            $parcent=AssessmentMethodTracking::find()->where(['assessment_method_id'=>$assessment_methods_id,'module_id'=>$model->module_id,'category'=>'CA'])->one()->percent;
                                            $student_exists->cat_1=$students['score'];
                                            $student_exists->cat_1p=round(($students['score']/100)*$parcent,1);

                                            $student_exists->save(false);
                                        }
                                        if ($assessment_methods == 'CAT 2') {
                                            $assessment_methods_id=AssessmentMethod::find()->where(['name'=>'CAT 2','nta_level'=>'4'])->one()->id;
                                            $parcent=AssessmentMethodTracking::find()->where(['assessment_method_id'=>$assessment_methods_id,'module_id'=>$model->module_id,'category'=>'CA'])->one()->percent;
                                            $student_exists->cat_2=$students['score'];
                                            $student_exists->cat_2p=round(($students['score']/100)*$parcent,1);
                                            $student_exists->save(false);
                                        }
                                        if ($assessment_methods == 'ASSIGNMENT 1') {
                                            $assessment_methods_id=AssessmentMethod::find()->where(['name'=>'ASSIGNMENT 1','nta_level'=>'4'])->one()->id;
                                            $parcent=AssessmentMethodTracking::find()->where(['assessment_method_id'=>$assessment_methods_id,'module_id'=>$model->module_id,'category'=>'CA'])->one()->percent;
                                            $student_exists->assignment_1=$students['score'];
                                            $student_exists->assignment_1p=round(($students['score']/100)*$parcent,1);
                                            $student_exists->save(false);
                                        }
                                        if ($assessment_methods == 'ASSIGNMENT 2') {
                                            $assessment_methods_id=AssessmentMethod::find()->where(['name'=>'ASSIGNMENT 2','nta_level'=>'4'])->one()->id;
                                            $parcent=AssessmentMethodTracking::find()->where(['assessment_method_id'=>$assessment_methods_id,'module_id'=>$model->module_id,'category'=>'CA'])->one()->percent;
                                            $student_exists->assignment_2=$students['score'];
                                            $student_exists->assignment_2p=round(($students['score']/100)*$parcent,1);

                                            $student_exists->save(false);
                                        }
                                        if ($assessment_methods == 'Clinical Examination') {
                                            $assessment_methods_id=AssessmentMethod::find()->where(['name'=>'Clinical Examination','nta_level'=>'4'])->one()->id;
                                            $parcent=AssessmentMethodTracking::find()->where(['assessment_method_id'=>$assessment_methods_id,'module_id'=>$model->module_id,'category'=>'CA'])->one()->percent;
                                            $student_exists->practical=$students['score'];
                                            $student_exists->practicalp=round(($students['score']/100)*$parcent,1);
                                            $student_exists->save(false);
                                        }
                                        if ($assessment_methods == 'Practical Examination') {
                                            $assessment_methods_id=AssessmentMethod::find()->where(['name'=>'Practical Examination','nta_level'=>'4'])->one()->id;
                                            $parcent=AssessmentMethodTracking::find()->where(['assessment_method_id'=>$assessment_methods_id,'module_id'=>$model->module_id,'category'=>'CA'])->one()->percent;
                                            $student_exists->practical=$students['score'];
                                            $student_exists->practicalp=round(($students['score']/100)*$parcent,1);
                                            $student_exists->save(false);
                                        }

                                        if ($assessment_methods == 'Case Study') {
                                            $assessment_methods_id=AssessmentMethod::find()->where(['name'=>'Case Study','nta_level'=>'4'])->one()->id;
                                            $parcent=AssessmentMethodTracking::find()->where(['assessment_method_id'=>$assessment_methods_id,'module_id'=>$model->module_id,'category'=>'CA'])->one()->percent;
                                            $student_exists->practical=$students['score'];
                                            $student_exists->practicalp=round(($students['score']/100)*$parcent,1);

                                            $student_exists->save(false);
                                        }
                                        if ($assessment_methods == 'PPB') {
                                            $assessment_methods_id=AssessmentMethod::find()->where(['name'=>'PPB','nta_level'=>'4'])->one()->id;
                                            $parcent=AssessmentMethodTracking::find()->where(['assessment_method_id'=>$assessment_methods_id,'module_id'=>$model->module_id,'category'=>'CA'])->one()->percent;
                                            $student_exists->ppb=$students['score'];
                                            $student_exists->ppbp=round(($students['score']/100)*$parcent,1);
                                            $student_exists->save(false);
                                        }
                                        if ($assessment_methods == 'Oral Examination') {
                                            $assessment_methods_id=AssessmentMethod::find()->where(['name'=>'Oral Examination','nta_level'=>'4'])->one()->id;
                                            $parcent=AssessmentMethodTracking::find()->where(['assessment_method_id'=>$assessment_methods_id,'module_id'=>$model->module_id,'category'=>'CA'])->one()->percent;
                                            $student_exists->practical=$students['score'];
                                            $student_exists->practicalp=round(($students['score']/100)*$parcent,1);
                                            $student_exists->save(false);
                                        }
                                        if ($assessment_methods == 'OSPE') {
                                            $assessment_methods_id=AssessmentMethod::find()->where(['name'=>'OSPE','nta_level'=>'4'])->one()->id;
                                            $parcent=AssessmentMethodTracking::find()->where(['assessment_method_id'=>$assessment_methods_id,'module_id'=>$model->module_id,'category'=>'CA'])->one()->percent;
                                            $student_exists->practical=$students['score'];
                                            $student_exists->practicalp=round(($students['score']/100)*$parcent,1);
                                            $student_exists->save(false);
                                        }
                                        //CHEK IF IS THE LAST SUBJECT TO SAVE TOTAL SCORE AND REMARKS
                                        $assessment_methods_count=AssessmentMethodTracking::find()->where(['module_id'=>$model->module_id,'category'=>'CA'])->count();

                                        $cat1 = CourseworkNta4::find()->where([ 'semester_id' =>$students['semester_id'], 'module_id' =>$students['module_id'], 'academic_year_id' => $students['academic_year_id']])->sum('cat_1');
                                        $cat2 = CourseworkNta4::find()->where([ 'semester_id' =>$students['semester_id'], 'module_id' =>$students['module_id'], 'academic_year_id' => $students['academic_year_id']])->sum('cat_2');
                                        $assignment_1 = CourseworkNta4::find()->where([ 'semester_id' =>$students['semester_id'], 'module_id' =>$students['module_id'], 'academic_year_id' => $students['academic_year_id']])->sum('assignment_1');
                                        $assignment_2 = CourseworkNta4::find()->where([ 'semester_id' =>$students['semester_id'], 'module_id' =>$students['module_id'], 'academic_year_id' => $students['academic_year_id']])->sum('assignment_2');
                                        $clinical_exam = CourseworkNta4::find()->where([ 'semester_id' =>$students['semester_id'], 'module_id' =>$students['module_id'], 'academic_year_id' => $students['academic_year_id']])->sum('practical');

                                        $ppb= CourseworkNta4::find()->where([ 'semester_id' =>$students['semester_id'], 'module_id' =>$students['module_id'], 'academic_year_id' => $students['academic_year_id']])->sum('ppb');

                                        if((!empty($cat1)&& !empty($cat2)&& !empty($assignment_1)&& !empty($assignment_2))|| (!empty($ppb) || !empty($clinical_exam))){


                                            $cat1_score = CourseworkNta4::find()->where([ 'student_id' => $students['student_id'],'semester_id' =>$students['semester_id'], 'module_id' =>$students['module_id'], 'academic_year_id' => $students['academic_year_id']])->sum('cat_1p');
                                            $cat2_score = CourseworkNta4::find()->where(['student_id' => $students['student_id'], 'semester_id' =>$students['semester_id'], 'module_id' =>$students['module_id'], 'academic_year_id' => $students['academic_year_id']])->sum('cat_2p');
                                            $assignment_1_score = CourseworkNta4::find()->where(['student_id' => $students['student_id'], 'semester_id' =>$students['semester_id'], 'module_id' =>$students['module_id'], 'academic_year_id' => $students['academic_year_id']])->sum('assignment_1p');
                                            $assignment_2_score = CourseworkNta4::find()->where(['student_id' => $students['student_id'], 'semester_id' =>$students['semester_id'], 'module_id' =>$students['module_id'], 'academic_year_id' => $students['academic_year_id']])->sum('assignment_2p');
                                            $clinical_exam_score= CourseworkNta4::find()->where([ 'student_id' => $students['student_id'],'semester_id' =>$students['semester_id'], 'module_id' =>$students['module_id'], 'academic_year_id' => $students['academic_year_id']])->sum('practicalp');
                                            $ppb_score= CourseworkNta4::find()->where(['student_id' => $students['student_id'], 'semester_id' =>$students['semester_id'], 'module_id' =>$students['module_id'], 'academic_year_id' => $students['academic_year_id']])->sum('ppbp');


                                            $total_score=round($cat1_score+$cat2_score+$assignment_1_score+$assignment_2_score+$clinical_exam_score+$ppb_score,1);
                                            $student_exists->total_score=$total_score;
                                            $student_exists->save(false);
                                            if ($total_score>20 || $total_score==20){
                                                $student_exists->remarks='Passed';
                                                $student_exists->save(false);
                                            }
                                            else{
                                                $student_exists->remarks='Failed';
                                                $student_exists->save(false);
                                            }

                                        }



                                    }
                                }

                                else{


                                    $all_students=Assignment::find()->where(['assessment_method_id'=>$model->assessment_method_id,'module_id'=>$model->module_id,'course_id'=>$model->course_id,'academic_year_id'=>$model->academic_year_id,'semester_id'=>$model->semester_id])->all();
                                    foreach($all_students as $students) {
                                        $course_work = new CourseworkNta4();
                                        $course_work->student_id = $students['student_id'];
                                        $course_work->module_id = $students['module_id'];
                                        $course_work->academic_year_id =$students['academic_year_id'];
                                        $course_work->course_id =$students['course_id'];
                                        $course_work->semester_id =$students['semester_id'];
                                        $course_work->staff_id = Yii::$app->user->identity->user_id;


                                        if ($assessment_methods == "CAT 1") {
                                            $assessment_methods_id=AssessmentMethod::find()->where(['name'=>'CAT 1'])->one()->id;
                                            $parcent=AssessmentMethodTracking::find()->where(['assessment_method_id'=>$assessment_methods_id,'module_id'=>$model->module_id,'category'=>'CA'])->one()->percent;
                                            $course_work->cat_1=$students['score'];
                                            $course_work->cat_1p=round(($students['score']/100)*$parcent,1);

                                        }
                                        if ($assessment_methods == "CAT 2") {
                                            $assessment_methods_id=AssessmentMethod::find()->where(['name'=>'CAT 2'])->one()->id;
                                            $parcent=AssessmentMethodTracking::find()->where(['assessment_method_id'=>$assessment_methods_id,'module_id'=>$model->module_id,'category'=>'CA'])->one()->percent;
                                            $course_work->cat2=$students['score'];
                                            $course_work->cat_2p=round(($students['score']/100)*$parcent,1);
                                        }
                                        if ($assessment_methods == "ASSIGNMENT 1") {
                                            $assessment_methods_id=AssessmentMethod::find()->where(['name'=>'ASSIGNMENT 1'])->one()->id;
                                            $parcent=AssessmentMethodTracking::find()->where(['assessment_method_id'=>$assessment_methods_id,'module_id'=>$model->module_id,'category'=>'CA'])->one()->percent;
                                            $course_work->assignment_1=$students['score'];
                                            $course_work->assignment_1p=round(($students['score']/100)*$parcent,1);
                                            $course_work->save(false);
                                        }
                                        if ($assessment_methods == "ASSIGNMENT 2") {
                                            $assessment_methods_id=AssessmentMethod::find()->where(['name'=>'ASSIGNMENT 2'])->one()->id;
                                            $parcent=AssessmentMethodTracking::find()->where(['assessment_method_id'=>$assessment_methods_id,'module_id'=>$model->module_id,'category'=>'CA'])->one()->percent;
                                            $course_work->assignment_2=$students['score'];
                                            $course_work->assignment_2p=round(($students['score']/100)*$parcent,1);


                                        }
                                        if ($assessment_methods == 'Clinical Examination') {
                                            $assessment_methods_id=AssessmentMethod::find()->where(['name'=>'Clinical Examination'])->one()->id;
                                            $parcent=AssessmentMethodTracking::find()->where(['assessment_method_id'=>$assessment_methods_id,'module_id'=>$model->module_id,'category'=>'CA'])->one()->percent;
                                            $course_work->practical=$students['score'];
                                            $course_work->practicalp=round(($students['score']/100)*$parcent,1);
                                        }

                                        if ($assessment_methods == 'Practical Examination') {
                                            $assessment_methods_id=AssessmentMethod::find()->where(['name'=>'Practical Examination'])->one()->id;
                                            $parcent=AssessmentMethodTracking::find()->where(['assessment_method_id'=>$assessment_methods_id,'module_id'=>$model->module_id,'category'=>'CA'])->one()->percent;
                                            $course_work->practical=$students['score'];
                                            $course_work->practicalp=round(($students['score']/100)*$parcent,1);


                                        }


                                        if ($assessment_methods == 'PPB') {
                                            $assessment_methods_id=AssessmentMethod::find()->where(['name'=>'PPB'])->one()->id;
                                            $parcent=AssessmentMethodTracking::find()->where(['assessment_method_id'=>$assessment_methods_id,'module_id'=>$model->module_id,'category'=>'CA'])->one()->percent;
                                            $course_work->ppb=$students['score'];
                                            $course_work->ppbp=round(($students['score']/100)*$parcent,1);


                                        }


                                        if ($assessment_methods == 'Oral Examination') {
                                            $assessment_methods_id=AssessmentMethod::find()->where(['name'=>'Oral Examination','nta_level'=>'4'])->one()->id;
                                            $parcent=AssessmentMethodTracking::find()->where(['assessment_method_id'=>$assessment_methods_id,'module_id'=>$model->module_id,'category'=>'CA'])->one()->percent;
                                            $course_work->practical=$students['score'];
                                            $course_work->practicalp=round(($students['score']/100)*$parcent,1);
                                            $course_work->save(false);
                                        }
                                        if ($assessment_methods == 'OSPE') {
                                            $assessment_methods_id=AssessmentMethod::find()->where(['name'=>'OSPE','nta_level'=>'4'])->one()->id;
                                            $parcent=AssessmentMethodTracking::find()->where(['assessment_method_id'=>$assessment_methods_id,'module_id'=>$model->module_id,'category'=>'CA'])->one()->percent;
                                            $course_work->practical=$students['score'];
                                            $course_work->practicalp=round(($students['score']/100)*$parcent,1);
                                            $course_work->save(false);
                                        }
                                        $course_work->save(false);
                                    }


                                }

                            }

                            elseif($year_of_studies=='5'){
                                $student_exist=CourseworkNta5::find()->where(['student_id'=>Student::find()->where(['registration_number'=>$registration_number])->one()->id,'semester_id'=>$model->semester_id,'module_id'=>$model->module_id,'academic_year_id'=>$model->academic_year_id])->exists();
                                $assessment_methods=AssessmentMethod::find()->where(['id'=>$model->assessment_method_id])->one()->name;


                                if($student_exist) {

                                    $all_students = Assignment::find()->where(['assessment_method_id' => $model->assessment_method_id, 'module_id' => $model->module_id, 'course_id' => $model->course_id, 'academic_year_id' => $model->academic_year_id, 'semester_id' => $model->semester_id])->all();
                                    foreach ($all_students as $students) {
                                        $student_exists = CourseworkNta5::find()->where(['student_id' => $students['student_id'], 'semester_id' =>$students['semester_id'], 'module_id' =>$students['module_id'], 'academic_year_id' => $students['academic_year_id']])->one();
                                        if ($assessment_methods =='CAT 1'){
                                            $assessment_methods_id=AssessmentMethod::find()->where(['name'=>'CAT 1'])->one()->id;
                                            $parcent=AssessmentMethodTracking::find()->where(['assessment_method_id'=>$assessment_methods_id,'module_id'=>$model->module_id,'category'=>'CA'])->one()->percent;
                                            $student_exists->cat_1=$students['score'];
                                            $student_exists->cat_1p=round(($students['score']/100)*$parcent,1);
                                            $student_exists->save(false);
                                        }
                                        if ($assessment_methods =='CAT 2') {
                                            $assessment_methods_id=AssessmentMethod::find()->where(['name'=>'CAT 2'])->one()->id;
                                            $parcent=AssessmentMethodTracking::find()->where(['assessment_method_id'=>$assessment_methods_id,'module_id'=>$model->module_id,'category'=>'CA'])->one()->percent;
                                            $student_exists->cat_2=$students['score'];
                                            $student_exists->cat_2p=round(($students['score']/100)*$parcent,1);
                                            $student_exists->save(false);
                                        }
                                        if ($assessment_methods =='ASSIGNMENT 1') {
                                            $assessment_methods_id=AssessmentMethod::find()->where(['name'=>'ASSIGNMENT 1'])->one()->id;
                                            $parcent=AssessmentMethodTracking::find()->where(['assessment_method_id'=>$assessment_methods_id,'module_id'=>$model->module_id,'category'=>'CA'])->one()->percent;
                                            $student_exists->assignment_1=$students['score'];
                                            $student_exists->assignment_1p=round(($students['score']/100)*$parcent,1);
                                            $student_exists->save(false);
                                        }
                                        if ($assessment_methods =='ASSIGNMENT 2') {
                                            $assessment_methods_id=AssessmentMethod::find()->where(['name'=>'ASSIGNMENT 2'])->one()->id;
                                            $parcent=AssessmentMethodTracking::find()->where(['assessment_method_id'=>$assessment_methods_id,'module_id'=>$model->module_id,'category'=>'CA'])->one()->percent;
                                            $student_exists->assignment_2=$students['score'];
                                            $student_exists->assignment_2p=round(($students['score']/100)*$parcent,1);
                                            $student_exists->save(false);
                                        }
                                        if ($assessment_methods =='Clinical Examination') {
                                            $assessment_methods_id=AssessmentMethod::find()->where(['name'=>'Clinical Examination','nta_level'=>'5'])->one()->id;
                                            $parcent=AssessmentMethodTracking::find()->where(['assessment_method_id'=>$assessment_methods_id,'module_id'=>$model->module_id,'category'=>'CA'])->one()->percent;
                                            $student_exists->practical=$students['score'];
                                            $student_exists->practicalp=round(($students['score']/100)*$parcent,1);
                                            $student_exists->save(false);
                                        }

                                        if ($assessment_methods =='Practical Examination') {
                                            $assessment_methods_id=AssessmentMethod::find()->where(['name'=>'Practical Examination'])->one()->id;
                                            $parcent=AssessmentMethodTracking::find()->where(['assessment_method_id'=>$assessment_methods_id,'module_id'=>$model->module_id,'category'=>'CA'])->one()->percent;
                                            $student_exists->practical=$students['score'];
                                            $student_exists->practicalp=round(($students['score']/100)*$parcent,1);
                                            $student_exists->save(false);
                                        }


                                        if ($assessment_methods =='Portfolio') {
                                            $assessment_methods_id=AssessmentMethod::find()->where(['name'=>'Portfolio'])->one()->id;
                                            $parcent=AssessmentMethodTracking::find()->where(['assessment_method_id'=>$assessment_methods_id,'module_id'=>$model->module_id,'category'=>'CA'])->one()->percent;
                                            $student_exists->practical_2=$students['score'];
                                            $student_exists->practical_2p=round(($students['score']/100)*$parcent,1);
                                            $student_exists->save(false);
                                        }
                                        if ($assessment_methods =='Case Study') {
                                            $assessment_methods_id=AssessmentMethod::find()->where(['name'=>'Case Study'])->one()->id;
                                            $parcent=AssessmentMethodTracking::find()->where(['assessment_method_id'=>$assessment_methods_id,'module_id'=>$model->module_id,'category'=>'CA'])->one()->percent;
                                            $student_exists->practical_2=$students['score'];
                                            $student_exists->practical_2p=round(($students['score']/100)*$parcent,1);
                                            $student_exists->save(false);

                                        }if ($assessment_methods =='Field Report') {
                                            $assessment_methods_id=AssessmentMethod::find()->where(['name'=>'Field Report'])->one()->id;
                                            $parcent=AssessmentMethodTracking::find()->where(['assessment_method_id'=>$assessment_methods_id,'module_id'=>$model->module_id,'category'=>'CA'])->one()->percent;
                                            $student_exists->practical_2=$students['score'];
                                            $student_exists->practical_2p=round(($students['score']/100)*$parcent,1);
                                            $student_exists->save(false);
                                        }

                                        if ($assessment_methods =='PPB') {
                                            $assessment_methods_id=AssessmentMethod::find()->where(['name'=>'PPB'])->one()->id;
                                            $parcent=AssessmentMethodTracking::find()->where(['assessment_method_id'=>$assessment_methods_id,'module_id'=>$model->module_id,'category'=>'CA'])->one()->percent;
                                            $student_exists->ppb=$students['score'];
                                            $student_exists->ppbp=round(($students['score']/100)*$parcent,1);
                                            $student_exists->save(false);
                                        }
                                        if ($assessment_methods == 'Oral Examination') {
                                            $assessment_methods_id=AssessmentMethod::find()->where(['name'=>'Oral Examination','nta_level'=>'5'])->one()->id;
                                            $parcent=AssessmentMethodTracking::find()->where(['assessment_method_id'=>$assessment_methods_id,'module_id'=>$model->module_id,'category'=>'CA'])->one()->percent;
                                            $student_exists->practical=$students['score'];
                                            $student_exists->practicalp=round(($students['score']/100)*$parcent,1);
                                            $student_exists->save(false);
                                        }
                                        if ($assessment_methods == 'OSPE') {
                                            $assessment_methods_id=AssessmentMethod::find()->where(['name'=>'OSPE','nta_level'=>'5'])->one()->id;
                                            $parcent=AssessmentMethodTracking::find()->where(['assessment_method_id'=>$assessment_methods_id,'module_id'=>$model->module_id,'category'=>'CA'])->one()->percent;
                                            $student_exists->practical=$students['score'];
                                            $student_exists->practicalp=round(($students['score']/100)*$parcent,1);
                                            $student_exists->save(false);
                                        }

                                        //CHEK IF IS THE LAST SUBJECT TO SAVE TOTAL SCORE AND REMARKS
                                        $assessment_methods_count=AssessmentMethodTracking::find()->where(['module_id'=>$model->module_id,'category'=>'CA'])->count();

                                        $cat1 = CourseworkNta5::find()->where([ 'semester_id' =>$students['semester_id'], 'module_id' =>$students['module_id'], 'academic_year_id' => $students['academic_year_id']])->sum('cat_1');
                                        $cat2 = CourseworkNta5::find()->where([ 'semester_id' =>$students['semester_id'], 'module_id' =>$students['module_id'], 'academic_year_id' => $students['academic_year_id']])->sum('cat_2');
                                        $assignment_1 = CourseworkNta5::find()->where([ 'semester_id' =>$students['semester_id'], 'module_id' =>$students['module_id'], 'academic_year_id' => $students['academic_year_id']])->sum('assignment_1');
                                        $assignment_2 = CourseworkNta5::find()->where([ 'semester_id' =>$students['semester_id'], 'module_id' =>$students['module_id'], 'academic_year_id' => $students['academic_year_id']])->sum('assignment_2');
                                        $clinical_exam = CourseworkNta5::find()->where([ 'semester_id' =>$students['semester_id'], 'module_id' =>$students['module_id'], 'academic_year_id' => $students['academic_year_id']])->sum('practical');
                                        $practical_2 = CourseworkNta5::find()->where([ 'semester_id' =>$students['semester_id'], 'module_id' =>$students['module_id'], 'academic_year_id' => $students['academic_year_id']])->sum('practical_2');
                                        $ppb= CourseworkNta5::find()->where([ 'semester_id' =>$students['semester_id'], 'module_id' =>$students['module_id'], 'academic_year_id' => $students['academic_year_id']])->sum('ppb');

                                        if((!empty($cat1)&& !empty($cat2)&& !empty($assignment_1)&& !empty($assignment_2) && (!empty($clinical_exam) || !empty($practical_2)|| (!empty($ppb)) )) ){
                                            $cat1_score = CourseworkNta5::find()->where([ 'student_id' => $students['student_id'],'semester_id' =>$students['semester_id'], 'module_id' =>$students['module_id'], 'academic_year_id' => $students['academic_year_id']])->sum('cat_1p');
                                            $cat2_score = CourseworkNta5::find()->where(['student_id' => $students['student_id'], 'semester_id' =>$students['semester_id'], 'module_id' =>$students['module_id'], 'academic_year_id' => $students['academic_year_id']])->sum('cat_2p');
                                            $assignment_1_score = CourseworkNta5::find()->where(['student_id' => $students['student_id'], 'semester_id' =>$students['semester_id'], 'module_id' =>$students['module_id'], 'academic_year_id' => $students['academic_year_id']])->sum('assignment_1p');
                                            $assignment_2_score = CourseworkNta5::find()->where(['student_id' => $students['student_id'], 'semester_id' =>$students['semester_id'], 'module_id' =>$students['module_id'], 'academic_year_id' => $students['academic_year_id']])->sum('assignment_2p');
                                            $clinical_exam_score= CourseworkNta5::find()->where([ 'student_id' => $students['student_id'],'semester_id' =>$students['semester_id'], 'module_id' =>$students['module_id'], 'academic_year_id' => $students['academic_year_id']])->sum('practicalp');
                                            $practical_2_score= CourseworkNta5::find()->where([ 'student_id' => $students['student_id'],'semester_id' =>$students['semester_id'], 'module_id' =>$students['module_id'], 'academic_year_id' => $students['academic_year_id']])->sum('practical_2p');
                                            $ppb_score= CourseworkNta5::find()->where(['student_id' => $students['student_id'], 'semester_id' =>$students['semester_id'], 'module_id' =>$students['module_id'], 'academic_year_id' => $students['academic_year_id']])->sum('ppbp');
                                            $total_score=round($cat1_score+$cat2_score+$assignment_1_score+$assignment_2_score+$clinical_exam_score+$practical_2_score+$ppb_score,1);
                                            $student_exists->total_score=$total_score;
                                            $student_exists->save(false);
                                            if ($total_score>20 || $total_score==20){
                                                $student_exists->remarks='Passed';
                                                $student_exists->save(false);
                                            }
                                            else{
                                                $student_exists->remarks='Failed';
                                                $student_exists->save(false);
                                            }

                                        }


                                    }
                                }

                                else{
                                    $all_students=Assignment::find()->where(['assessment_method_id'=>$model->assessment_method_id,'module_id'=>$model->module_id,'course_id'=>$model->course_id,'nta_level'=>$year_of_study,'academic_year_id'=>$model->academic_year_id,'semester_id'=>$model->semester_id])->all();
                                    foreach($all_students as $students) {
                                        $course_work = new CourseworkNta5();
                                        $course_work->student_id = $students['student_id'];
                                        $course_work->module_id = $students['module_id'];
                                        $course_work->academic_year_id =$students['academic_year_id'];
                                        $course_work->course_id =$students['course_id'];
                                        $course_work->semester_id =$students['semester_id'];
                                        $course_work->staff_id = Yii::$app->user->identity->user_id;
                                        if ($assessment_methods == 'CAT 1') {
                                            $assessment_methods_id=AssessmentMethod::find()->where(['name'=>'CAT 1'])->one()->id;
                                            $parcent=AssessmentMethodTracking::find()->where(['assessment_method_id'=>$assessment_methods_id,'module_id'=>$model->module_id,'category'=>'CA'])->one()->percent;

                                            $course_work->cat_1=$students['score'];
                                            $course_work->cat_1p=round(($students['score']/100)*$parcent,1);

                                        }
                                        if($assessment_methods == 'CAT 2') {
                                            $assessment_methods_id=AssessmentMethod::find()->where(['name'=>'CAT 2'])->one()->id;
                                            $parcent=AssessmentMethodTracking::find()->where(['assessment_method_id'=>$assessment_methods_id,'module_id'=>$model->module_id,'category'=>'CA'])->one()->percent;
                                            $course_work->cat_2=$students['score'];
                                            $course_work->cat_2p=round(($students['score']/100)*$parcent,1);
                                        }

                                        if($assessment_methods == 'ASSIGNMENT 1') {
                                            $assessment_methods_id=AssessmentMethod::find()->where(['name'=>'ASSIGNMENT 1'])->one()->id;
                                            $parcent=AssessmentMethodTracking::find()->where(['assessment_method_id'=>$assessment_methods_id,'module_id'=>$model->module_id,'category'=>'CA'])->one()->percent;

                                            $course_work->assignment_1=$students['score'];
                                            $course_work->assignment_1p=round(($students['score']/100)*$parcent,1);

                                        }
                                        if ($assessment_methods == 'ASSIGNMENT 2') {
                                            $assessment_methods_id=AssessmentMethod::find()->where(['name'=>'ASSIGNMENT 2'])->one()->id;
                                            $parcent=AssessmentMethodTracking::find()->where(['assessment_method_id'=>$assessment_methods_id,'module_id'=>$model->module_id,'category'=>'CA'])->one()->percent;
                                            $course_work->assignment_2=$students['score'];
                                            $course_work->assignment_2p=round(($students['score']/100)*$parcent,1);
                                        }

                                        if ($assessment_methods == 'Clinical Examination') {
                                            $assessment_methods_id=AssessmentMethod::find()->where(['name'=>'Clinical Examination','nta_level'=>'5'])->one()->id;
                                            $parcent=AssessmentMethodTracking::find()->where(['assessment_method_id'=>$assessment_methods_id,'module_id'=>$model->module_id,'category'=>'CA'])->one()->percent;

                                            $course_work->practical=$students['score'];
                                            $course_work->practicalp=round(($students['score']/100)*$parcent,1);
                                        }
                                        if ($assessment_methods == 'Practical Examination') {
                                            $assessment_methods_id=AssessmentMethod::find()->where(['name'=>'Practical Examination'])->one()->id;
                                            $parcent=AssessmentMethodTracking::find()->where(['assessment_method_id'=>$assessment_methods_id,'module_id'=>$model->module_id,'category'=>'CA'])->one()->percent;
                                            $course_work->practical=$students['score'];
                                            $course_work->practicalp=round(($students['score']/100)*$parcent,1);
                                        }
                                        if ($assessment_methods =='PPB') {
                                            $assessment_methods_id=AssessmentMethod::find()->where(['name'=>'PPB'])->one()->id;
                                            $parcent=AssessmentMethodTracking::find()->where(['assessment_method_id'=>$assessment_methods_id,'module_id'=>$model->module_id,'category'=>'CA'])->one()->percent;
                                            $course_work->ppb=$students['score'];
                                            $course_work->ppbp=round(($students['score']/100)*$parcent,1);
                                        }
                                        if ($assessment_methods == 'Oral Examination') {
                                            $assessment_methods_id=AssessmentMethod::find()->where(['name'=>'Oral Examination','nta_level'=>'5'])->one()->id;
                                            $parcent=AssessmentMethodTracking::find()->where(['assessment_method_id'=>$assessment_methods_id,'module_id'=>$model->module_id,'category'=>'CA'])->one()->percent;
                                            $course_work->practical=$students['score'];
                                            $course_work->practicalp=round(($students['score']/100)*$parcent,1);
                                            $course_work->save(false);
                                        }
                                        if ($assessment_methods == 'OSPE') {
                                            $assessment_methods_id=AssessmentMethod::find()->where(['name'=>'OSPE','nta_level'=>'5'])->one()->id;
                                            $parcent=AssessmentMethodTracking::find()->where(['assessment_method_id'=>$assessment_methods_id,'module_id'=>$model->module_id,'category'=>'CA'])->one()->percent;
                                            $course_work->practical=$students['score'];
                                            $course_work->practicalp=round(($students['score']/100)*$parcent,1);
                                            $course_work->save(false);
                                        }
                                        $course_work->save(false);
                                    }


                                }

                            }




                            elseif($year_of_studies=='6'){
                                $student_exist=CourseworkNta6::find()->where(['student_id'=>Student::find()->where(['registration_number'=>$registration_number])->one()->id,'semester_id'=>$model->semester_id,'module_id'=>$model->module_id,'academic_year_id'=>$model->academic_year_id])->exists();
                                $assessment_methods=AssessmentMethod::find()->where(['id'=>$model->assessment_method_id])->one()->name;


                                if($student_exist) {
                                    $all_students = Assignment::find()->where(['assessment_method_id' => $model->assessment_method_id, 'module_id' => $model->module_id, 'course_id' => $model->course_id, 'academic_year_id' => $model->academic_year_id, 'semester_id' => $model->semester_id])->all();
                                    foreach ($all_students as $students) {
                                        $student_exists = CourseworkNta6::find()->where(['student_id' => $students['student_id'], 'semester_id' =>$students['semester_id'], 'module_id' =>$students['module_id'], 'academic_year_id' => $students['academic_year_id']])->one();
                                        if ($assessment_methods =='CAT 1'){
                                            $assessment_methods_id=AssessmentMethod::find()->where(['name'=>'CAT 1'])->one()->id;
                                            $parcent=AssessmentMethodTracking::find()->where(['assessment_method_id'=>$assessment_methods_id,'module_id'=>$model->module_id,'category'=>'CA'])->one()->percent;
                                            $student_exists->cat_1=$students['score'];
                                            $student_exists->cat_1p=round(($students['score']/100)*$parcent,1);
                                            $student_exists->save(false);
                                        }
                                        if ($assessment_methods =='CAT 2') {
                                            $assessment_methods_id=AssessmentMethod::find()->where(['name'=>'CAT 2'])->one()->id;
                                            $parcent=AssessmentMethodTracking::find()->where(['assessment_method_id'=>$assessment_methods_id,'module_id'=>$model->module_id,'category'=>'CA'])->one()->percent;
                                            $student_exists->cat_2=$students['score'];
                                            $student_exists->cat_2p=round(($students['score']/100)*$parcent,1);
                                            $student_exists->save(false);
                                        }
                                        if ($assessment_methods =='ASSIGNMENT 1') {
                                            $assessment_methods_id=AssessmentMethod::find()->where(['name'=>'ASSIGNMENT 1'])->one()->id;
                                            $parcent=AssessmentMethodTracking::find()->where(['assessment_method_id'=>$assessment_methods_id,'module_id'=>$model->module_id,'category'=>'CA'])->one()->percent;

                                            $student_exists->assignment_1=$students['score'];
                                            $student_exists->assignment_1p=round(($students['score']/100)*$parcent,1);
                                            $student_exists->save(false);
                                        }
                                        if ($assessment_methods =='ASSIGNMENT 2') {
                                            $assessment_methods_id=AssessmentMethod::find()->where(['name'=>'ASSIGNMENT 2'])->one()->id;
                                            $parcent=AssessmentMethodTracking::find()->where(['assessment_method_id'=>$assessment_methods_id,'module_id'=>$model->module_id,'category'=>'CA'])->one()->percent;

                                            $student_exists->assignment_2=$students['score'];
                                            $student_exists->assignment_2p=round(($students['score']/100)*$parcent,1);
                                            $student_exists->save(false);
                                        }
                                        if ($assessment_methods == 'Practical Examination') {
                                            $assessment_methods_id=AssessmentMethod::find()->where(['name'=>'Practical Examination'])->one()->id;
                                            $parcent=AssessmentMethodTracking::find()->where(['assessment_method_id'=>$assessment_methods_id,'module_id'=>$model->module_id,'category'=>'CA'])->one()->percent;
                                            $student_exists->practical=$students['score'];
                                            $student_exists->practicalp=round(($students['score']/100)*$parcent,1);
                                        }
                                        if ($assessment_methods =='Clinical Examination') {
                                            $assessment_methods_id=AssessmentMethod::find()->where(['name'=>'Clinical Examination'])->one()->id;
                                            $parcent=AssessmentMethodTracking::find()->where(['assessment_method_id'=>$assessment_methods_id,'module_id'=>$model->module_id,'category'=>'CA'])->one()->percent;
                                            $student_exists->practical=$students['score'];
                                            $student_exists->practicalp=round(($students['score']/100)*$parcent,1);
                                            $student_exists->save(false);
                                        } if ($assessment_methods =='Case Presentation') {
                                            $assessment_methods_id=AssessmentMethod::find()->where(['name'=>'Case Presentation'])->one()->id;
                                            $parcent=AssessmentMethodTracking::find()->where(['assessment_method_id'=>$assessment_methods_id,'module_id'=>$model->module_id,'category'=>'CA'])->one()->percent;
                                            $student_exists->practical=$students['score'];
                                            $student_exists->practicalp=round(($students['score']/100)*$parcent,1);
                                            $student_exists->save(false);
                                        }
                                        if ($assessment_methods =='Portfolio') {
                                            $assessment_methods_id=AssessmentMethod::find()->where(['name'=>'Portfolio'])->one()->id;
                                            $parcent=AssessmentMethodTracking::find()->where(['assessment_method_id'=>$assessment_methods_id,'module_id'=>$model->module_id,'category'=>'CA'])->one()->percent;
                                            $student_exists->practical_2=$students['score'];
                                            $student_exists->practical_2p=round(($students['score']/100)*$parcent,1);
                                            $student_exists->save(false);
                                        }if ($assessment_methods =='Case Study') {
                                            $assessment_methods_id=AssessmentMethod::find()->where(['name'=>'Case Study'])->one()->id;
                                            $parcent=AssessmentMethodTracking::find()->where(['assessment_method_id'=>$assessment_methods_id,'module_id'=>$model->module_id,'category'=>'CA'])->one()->percent;
                                            $student_exists->practical_2=$students['score'];
                                            $student_exists->practical_2p=round(($students['score']/100)*$parcent,1);
                                            $student_exists->save(false);
                                        }if ($assessment_methods =='Field Report') {
                                            $assessment_methods_id=AssessmentMethod::find()->where(['name'=>'Field Report'])->one()->id;
                                            $parcent=AssessmentMethodTracking::find()->where(['assessment_method_id'=>$assessment_methods_id,'module_id'=>$model->module_id,'category'=>'CA'])->one()->percent;
                                            $student_exists->practical_2=$students['score'];
                                            $student_exists->practical_2p=round(($students['score']/100)*$parcent,1);
                                            $student_exists->save(false);
                                        }
                                        if ($assessment_methods =='Research Proposal') {
                                            $assessment_methods_id=AssessmentMethod::find()->where(['name'=>'Research Proposal'])->one()->id;
                                            $parcent=AssessmentMethodTracking::find()->where(['assessment_method_id'=>$assessment_methods_id,'module_id'=>$model->module_id,'category'=>'CA'])->one()->percent;
                                            $student_exists->practical_2=$students['score'];
                                            $student_exists->practical_2p=round(($students['score']/100)*$parcent,1);
                                            $student_exists->save(false);
                                        }

                                        if ($assessment_methods =='Delivery Book') {
                                            $assessment_methods_id=AssessmentMethod::find()->where(['name'=>'Delivery Book'])->one()->id;
                                            $parcent=AssessmentMethodTracking::find()->where(['assessment_method_id'=>$assessment_methods_id,'module_id'=>$model->module_id,'category'=>'CA'])->one()->percent;
                                            $student_exists->delivery_book=$students['score'];
                                            $student_exists->delivery_bookp=round(($students['score']/100)*$parcent,1);
                                            $student_exists->save(false);
                                        }

                                        if ($assessment_methods =='PPB') {
                                            $assessment_methods_id=AssessmentMethod::find()->where(['name'=>'PPB'])->one()->id;
                                            $parcent=AssessmentMethodTracking::find()->where(['assessment_method_id'=>$assessment_methods_id,'module_id'=>$model->module_id,'category'=>'CA'])->one()->percent;
                                            $student_exists->ppb=$students['score'];
                                            $student_exists->ppbp=round(($students['score']/100)*$parcent,1);
                                            $student_exists->save(false);
                                        }
                                        if ($assessment_methods == 'Oral Examination') {
                                            $assessment_methods_id=AssessmentMethod::find()->where(['name'=>'Oral Examination','nta_level'=>'6'])->one()->id;
                                            $parcent=AssessmentMethodTracking::find()->where(['assessment_method_id'=>$assessment_methods_id,'module_id'=>$model->module_id,'category'=>'CA'])->one()->percent;
                                            $student_exists->practical=$students['score'];
                                            $student_exists->practicalp=round(($students['score']/100)*$parcent,1);
                                            $student_exists->save(false);
                                        }
                                        if ($assessment_methods == 'OSPE') {
                                            $assessment_methods_id=AssessmentMethod::find()->where(['name'=>'OSPE','nta_level'=>'6'])->one()->id;
                                            $parcent=AssessmentMethodTracking::find()->where(['assessment_method_id'=>$assessment_methods_id,'module_id'=>$model->module_id,'category'=>'CA'])->one()->percent;
                                            $student_exists->practical=$students['score'];
                                            $student_exists->practicalp=round(($students['score']/100)*$parcent,1);
                                            $student_exists->save(false);
                                        }

                                        //CHEK IF IS THE LAST SUBJECT TO SAVE TOTAL SCORE AND REMARKS
                                        $assessment_methods_count=AssessmentMethodTracking::find()->where(['module_id'=>$model->module_id,'category'=>'CA'])->count();

                                        $cat1 = CourseworkNta6::find()->where([ 'semester_id' =>$students['semester_id'], 'module_id' =>$students['module_id'], 'academic_year_id' => $students['academic_year_id']])->sum('cat_1');
                                        $cat2 = CourseworkNta6::find()->where([ 'semester_id' =>$students['semester_id'], 'module_id' =>$students['module_id'], 'academic_year_id' => $students['academic_year_id']])->sum('cat_2');
                                        $assignment_1 = CourseworkNta6::find()->where([ 'semester_id' =>$students['semester_id'], 'module_id' =>$students['module_id'], 'academic_year_id' => $students['academic_year_id']])->sum('assignment_1');
                                        $assignment_2 = CourseworkNta6::find()->where([ 'semester_id' =>$students['semester_id'], 'module_id' =>$students['module_id'], 'academic_year_id' => $students['academic_year_id']])->sum('assignment_2');
                                        $clinical_exam = CourseworkNta6::find()->where([ 'semester_id' =>$students['semester_id'], 'module_id' =>$students['module_id'], 'academic_year_id' => $students['academic_year_id']])->sum('practical');
                                        $practical_2 = CourseworkNta6::find()->where([ 'semester_id' =>$students['semester_id'], 'module_id' =>$students['module_id'], 'academic_year_id' => $students['academic_year_id']])->sum('practical_2');
                                        $ppb= CourseworkNta6::find()->where([ 'semester_id' =>$students['semester_id'], 'module_id' =>$students['module_id'], 'academic_year_id' => $students['academic_year_id']])->sum('ppb');

                                        if((!empty($cat1)&& !empty($cat2) && (!empty($clinical_exam) || !empty($practical_2)|| (!empty($ppb)) ||!empty($assignment_1)|| !empty($assignment_2))) ){
                                            $cat1_score = CourseworkNta6::find()->where([ 'student_id' => $students['student_id'],'semester_id' =>$students['semester_id'], 'module_id' =>$students['module_id'], 'academic_year_id' => $students['academic_year_id']])->sum('cat_1p');
                                            $cat2_score = CourseworkNta6::find()->where(['student_id' => $students['student_id'], 'semester_id' =>$students['semester_id'], 'module_id' =>$students['module_id'], 'academic_year_id' => $students['academic_year_id']])->sum('cat_2p');
                                            $assignment_1_score = CourseworkNta6::find()->where(['student_id' => $students['student_id'], 'semester_id' =>$students['semester_id'], 'module_id' =>$students['module_id'], 'academic_year_id' => $students['academic_year_id']])->sum('assignment_1p');
                                            $assignment_2_score = CourseworkNta6::find()->where(['student_id' => $students['student_id'], 'semester_id' =>$students['semester_id'], 'module_id' =>$students['module_id'], 'academic_year_id' => $students['academic_year_id']])->sum('assignment_2p');
                                            $clinical_exam_score= CourseworkNta6::find()->where([ 'student_id' => $students['student_id'],'semester_id' =>$students['semester_id'], 'module_id' =>$students['module_id'], 'academic_year_id' => $students['academic_year_id']])->sum('practicalp');
                                            $practical_2_score= CourseworkNta6::find()->where([ 'student_id' => $students['student_id'],'semester_id' =>$students['semester_id'], 'module_id' =>$students['module_id'], 'academic_year_id' => $students['academic_year_id']])->sum('practical_2p');
                                            $ppb_score= CourseworkNta6::find()->where(['student_id' => $students['student_id'], 'semester_id' =>$students['semester_id'], 'module_id' =>$students['module_id'], 'academic_year_id' => $students['academic_year_id']])->sum('ppbp');
                                            $dbook_score= CourseworkNta6::find()->where(['student_id' => $students['student_id'], 'semester_id' =>$students['semester_id'], 'module_id' =>$students['module_id'], 'academic_year_id' => $students['academic_year_id']])->sum('delivery_bookp');
                                            $total_score=round($cat1_score+$cat2_score+$assignment_1_score+$assignment_2_score+$clinical_exam_score+$practical_2_score+$ppb_score+$dbook_score,1);
                                            $student_exists->total_score=$total_score;
                                            $student_exists->save(false);
                                            if ($total_score>20 || $total_score==20){
                                                $student_exists->remarks='Passed';
                                                $student_exists->save(false);
                                            }
                                            else{
                                                $student_exists->remarks='Failed';
                                                $student_exists->save(false);
                                            }

                                        }



                                    }
                                }

                                else{
                                    $all_students=Assignment::find()->where(['assessment_method_id'=>$model->assessment_method_id,'module_id'=>$model->module_id,'course_id'=>$model->course_id,'academic_year_id'=>$model->academic_year_id,'semester_id'=>$model->semester_id])->all();
                                    foreach($all_students as $students) {
                                        $course_work = new CourseworkNta6();
                                        $course_work->student_id = $students['student_id'];
                                        $course_work->module_id = $students['module_id'];
                                        $course_work->academic_year_id =$students['academic_year_id'];
                                        $course_work->course_id =$students['course_id'];
                                        $course_work->semester_id =$students['semester_id'];
                                        $course_work->staff_id = Yii::$app->user->identity->user_id;
                                        if ($assessment_methods == 'CAT 1') {
                                            $assessment_methods_id=AssessmentMethod::find()->where(['name'=>'CAT 1'])->one()->id;
                                            $parcent=AssessmentMethodTracking::find()->where(['assessment_method_id'=>$assessment_methods_id,'module_id'=>$model->module_id,'category'=>'CA'])->one()->percent;
                                            $course_work->cat_1=$students['score'];
                                            $course_work->cat_1p=round(($students['score']/100)*$parcent,1);
                                        }
                                        if ($assessment_methods == 'CAT 2') {
                                            $assessment_methods_id=AssessmentMethod::find()->where(['name'=>'CAT 2'])->one()->id;
                                            $parcent=AssessmentMethodTracking::find()->where(['assessment_method_id'=>$assessment_methods_id,'module_id'=>$model->module_id,'category'=>'CA'])->one()->percent;
                                            $course_work->cat_2=$students['score'];
                                            $course_work->cat_2p=round(($students['score']/100)*$parcent,1);
                                        }
                                        if ($assessment_methods == 'ASSIGNMENT 1') {
                                            $assessment_methods_id=AssessmentMethod::find()->where(['name'=>'ASSIGNMENT 1'])->one()->id;
                                            $parcent=AssessmentMethodTracking::find()->where(['assessment_method_id'=>$assessment_methods_id,'module_id'=>$model->module_id,'category'=>'CA'])->one()->percent;
                                            $course_work->assignment_1=$students['score'];
                                            $course_work->assignment_1p=round(($students['score']/100)*$parcent,1);
                                        }
                                        if ($assessment_methods == 'ASSIGNMENT 2') {
                                            $assessment_methods_id=AssessmentMethod::find()->where(['name'=>'ASSIGNMENT 2'])->one()->id;
                                            $parcent=AssessmentMethodTracking::find()->where(['assessment_method_id'=>$assessment_methods_id,'module_id'=>$model->module_id,'category'=>'CA'])->one()->percent;
                                            $course_work->assignment_2=$students['score'];
                                            $course_work->assignment_2p=round(($students['score']/100)*$parcent,1);
                                        }
                                        if ($assessment_methods == 'Practical Examination') {
                                            $assessment_methods_id=AssessmentMethod::find()->where(['name'=>'Clinical Examination'])->one()->id;
                                            $parcent=AssessmentMethodTracking::find()->where(['assessment_method_id'=>$assessment_methods_id,'module_id'=>$model->module_id,'category'=>'CA'])->one()->percent;

                                            $course_work->practical=$students['score'];
                                            $course_work->practicalp=round(($students['score']/100)*$parcent,1);
                                        }
                                        if ($assessment_methods == 'Clinical Examination') {
                                            $assessment_methods_id=AssessmentMethod::find()->where(['name'=>'Clinical Examination'])->one()->id;
                                            $parcent=AssessmentMethodTracking::find()->where(['assessment_method_id'=>$assessment_methods_id,'module_id'=>$model->module_id,'category'=>'CA'])->one()->percent;

                                            $course_work->practical=$students['score'];
                                            $course_work->practicalp=round(($students['score']/100)*$parcent,1);
                                        }
                                        if ($assessment_methods =='Case Presentation') {
                                            $assessment_methods_id=AssessmentMethod::find()->where(['name'=>'Case Presentation'])->one()->id;
                                            $parcent=AssessmentMethodTracking::find()->where(['assessment_method_id'=>$assessment_methods_id,'module_id'=>$model->module_id,'category'=>'CA'])->one()->percent;
                                            $course_work->practical=$students['score'];
                                            $course_work->practicalp=round(($students['score']/100)*$parcent,1);
                                            $course_work->save(false);
                                        }
                                        if ($assessment_methods == 'PPB') {
                                            $assessment_methods_id=AssessmentMethod::find()->where(['name'=>'PPB'])->one()->id;
                                            $parcent=AssessmentMethodTracking::find()->where(['assessment_method_id'=>$assessment_methods_id,'module_id'=>$model->module_id,'category'=>'CA'])->one()->percent;
                                            $course_work->ppb=$students['score'];
                                            $course_work->ppbp=round(($students['score']/100)*$parcent,1);
                                        }
                                        if ($assessment_methods == 'Oral Examination') {
                                            $assessment_methods_id=AssessmentMethod::find()->where(['name'=>'Oral Examination','nta_level'=>'6'])->one()->id;
                                            $parcent=AssessmentMethodTracking::find()->where(['assessment_method_id'=>$assessment_methods_id,'module_id'=>$model->module_id,'category'=>'CA'])->one()->percent;
                                            $course_work->practical=$students['score'];
                                            $course_work->practicalp=round(($students['score']/100)*$parcent,1);
                                            $course_work->save(false);
                                        }
                                        if ($assessment_methods == 'OSPE') {
                                            $assessment_methods_id=AssessmentMethod::find()->where(['name'=>'OSPE','nta_level'=>'6'])->one()->id;
                                            $parcent=AssessmentMethodTracking::find()->where(['assessment_method_id'=>$assessment_methods_id,'module_id'=>$model->module_id,'category'=>'CA'])->one()->percent;
                                            $course_work->practical=$students['score'];
                                            $course_work->practicalp=round(($students['score']/100)*$parcent,1);
                                            $course_work->save(false);
                                        }
                                        $course_work->save(false);
                                    }


                                }

                            }
                        }
                        $transaction->commit();
                        unlink($filename);
                        Yii::$app->session->setFlash('getSuccess', '<span class="fa fa-check-square-o"> Congratulations! Results uploaded successfully</span>');
                        return $this->redirect(['index']);
                    }
                    catch (\Exception $e) {
                        fclose($file);
                        unlink($filename);
                        $transaction->rollBack();
                        Yii::$app->session->setFlash('getDanger', $e->getMessage());
//                        var_dump($e->getMessage());
//                        die();
                        Yii::$app->session->setFlash('getDanger', $e->getMessage());
                        //Yii::$app->session->setFlash('getDanger',"<span class=' fa fa-warning'> Invalid file Uploaded! Please review your CSV file</span>");
                        return $this->render('create', ['model' => $model]);
                    }
                }
            }
            else{

                Yii::$app->session->setFlash('getDanger',"<span class=' fa fa-warning'> Invalid file Uploaded! Please review your CSV file</span>");
                return $this->render('create', ['model' => $model]);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Assignment model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {

        // Yii::$app->db->createCommand()->insert('codeverification',['code'=>$code,'phone'=>$model->phone])->execute();
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post())) {
            if ($model->save(false)){

                $year_of_studies=Course::find()->where(['id'=>$model->course_id])->one()->nta_level;
                $assessment_methods=AssessmentMethod::find()->where(['id'=>$model->assessment_method_id])->one()->name;

                //NTA4
                if($year_of_studies=='4'){
                    $student_exists = CourseworkNta4::find()->where(['student_id' => $model->student_id, 'semester_id' =>$model->semester_id, 'module_id' =>$model->module_id, 'academic_year_id' => $model->academic_year_id])->one();
                    if ($assessment_methods == 'CAT 1') {
                        $parcent=AssessmentMethodTracking::find()->where(['assessment_method_id'=>$model->assessment_method_id,'module_id'=>$model->module_id,'category'=>'CA'])->one()->percent;
                        Yii::$app->db->createCommand()->update('coursework_nta4',['cat_1'=>($model->score/100)*$parcent],['student_id' => $model->student_id, 'semester_id' =>$model->semester_id, 'module_id' =>$model->module_id, 'academic_year_id' => $model->academic_year_id])->execute();

                    }
                    if ($assessment_methods == 'CAT 2') {
                        $parcent=AssessmentMethodTracking::find()->where(['assessment_method_id'=>$model->assessment_method_id,'module_id'=>$model->module_id,'category'=>'CA'])->one()->percent;
                        Yii::$app->db->createCommand()->update('coursework_nta4',['cat_2'=>($model->score/100)*$parcent],['student_id' => $model->student_id, 'semester_id' =>$model->semester_id, 'module_id' =>$model->module_id, 'academic_year_id' => $model->academic_year_id])->execute();

                    }
                    if ($assessment_methods == 'ASSIGNMENT 1') {
                        $parcent=AssessmentMethodTracking::find()->where(['assessment_method_id'=>$model->assessment_method_id,'module_id'=>$model->module_id,'category'=>'CA'])->one()->percent;
                        Yii::$app->db->createCommand()->update('coursework_nta4',['assignment_1'=>($model->score/100)*$parcent],['student_id' => $model->student_id, 'semester_id' =>$model->semester_id, 'module_id' =>$model->module_id, 'academic_year_id' => $model->academic_year_id])->execute();

                    }
                    if ($assessment_methods == 'ASSIGNMENT 2') {
                        $parcent=AssessmentMethodTracking::find()->where(['assessment_method_id'=>$model->assessment_method_id,'module_id'=>$model->module_id,'category'=>'CA'])->one()->percent;
                        Yii::$app->db->createCommand()->update('coursework_nta4',['assignment_2'=>($model->score/100)*$parcent],['student_id' => $model->student_id, 'semester_id' =>$model->semester_id, 'module_id' =>$model->module_id, 'academic_year_id' => $model->academic_year_id])->execute();

                    }
                    if ($assessment_methods == 'Clinical Examination') {
                        $parcent=AssessmentMethodTracking::find()->where(['assessment_method_id'=>$model->assessment_method_id,'module_id'=>$model->module_id,'category'=>'CA'])->one()->percent;
                        Yii::$app->db->createCommand()->update('coursework_nta4',['practical'=>($model->score/100)*$parcent],['student_id' => $model->student_id, 'semester_id' =>$model->semester_id, 'module_id' =>$model->module_id, 'academic_year_id' => $model->academic_year_id])->execute();

                    }
                    if ($assessment_methods == 'Practical Examination') {
                        $parcent=AssessmentMethodTracking::find()->where(['assessment_method_id'=>$model->assessment_method_id,'module_id'=>$model->module_id,'category'=>'CA'])->one()->percent;
                        Yii::$app->db->createCommand()->update('coursework_nta4',['practical'=>($model->score/100)*$parcent],['student_id' => $model->student_id, 'semester_id' =>$model->semester_id, 'module_id' =>$model->module_id, 'academic_year_id' => $model->academic_year_id])->execute();

                    }
                    if ($assessment_methods == 'Case Study') {
                        $parcent=AssessmentMethodTracking::find()->where(['assessment_method_id'=>$model->assessment_method_id,'module_id'=>$model->module_id,'category'=>'CA'])->one()->percent;
                        Yii::$app->db->createCommand()->update('coursework_nta4',['practical'=>($model->score/100)*$parcent],['student_id' => $model->student_id, 'semester_id' =>$model->semester_id, 'module_id' =>$model->module_id, 'academic_year_id' => $model->academic_year_id])->execute();

                    }
                    if ($assessment_methods == 'PPB') {
                        $parcent=AssessmentMethodTracking::find()->where(['assessment_method_id'=>$model->assessment_method_id,'module_id'=>$model->module_id,'category'=>'CA'])->one()->percent;
                        Yii::$app->db->createCommand()->update('coursework_nta4',['ppb'=>($model->score/100)*$parcent],['student_id' => $model->student_id, 'semester_id' =>$model->semester_id, 'module_id' =>$model->module_id, 'academic_year_id' => $model->academic_year_id])->execute();

                    }
                    if (!empty($student_exists->total_score)){


                        $cat1_score = CourseworkNta4::find()->where([ 'student_id' => $model->student_id,'semester_id' =>$model->semester_id, 'module_id' =>$model->module_id, 'academic_year_id' => $model->academic_year_id])->sum('cat_1');
                        $cat2_score = CourseworkNta4::find()->where(['student_id' =>$model->student_id, 'semester_id' =>$model->semester_id, 'module_id' =>$model->module_id, 'academic_year_id' => $model->academic_year_id])->sum('cat_2');
                        $assignment_1_score = CourseworkNta4::find()->where(['student_id' => $model->student_id, 'semester_id' =>$model->semester_id, 'module_id' =>$model->module_id, 'academic_year_id' => $model->academic_year_id])->sum('assignment_1');
                        $assignment_2_score = CourseworkNta4::find()->where(['student_id' =>  $model->student_id, 'semester_id' =>$model->semester_id, 'module_id' =>$model->module_id, 'academic_year_id' =>$model->academic_year_id])->sum('assignment_2');
                        $clinical_exam_score= CourseworkNta4::find()->where([ 'student_id' =>  $model->student_id,'semester_id' =>$model->semester_id, 'module_id' =>$model->module_id, 'academic_year_id' => $model->academic_year_id])->sum('practical');
                        // $practical_exam_score= CourseworkNta4::find()->where([ 'student_id' =>  $model->student_id,'semester_id' =>$model->semester_id, 'module_id' =>$model->module_id, 'academic_year_id' => $model->academic_year_id])->sum('practical_2');
                        $ppb_score= CourseworkNta4::find()->where(['student_id' => $model->student_id, 'semester_id' =>$model->semester_id, 'module_id' =>$model->module_id, 'academic_year_id' => $model->academic_year_id])->sum('ppb');
                        $total_score=$cat1_score+$cat2_score+$assignment_1_score+$assignment_2_score+$clinical_exam_score+$ppb_score;
                        Yii::$app->db->createCommand()->update('coursework_nta4',['total_score'=>$total_score],['student_id' => $model->student_id, 'semester_id' =>$model->semester_id, 'module_id' =>$model->module_id, 'academic_year_id' => $model->academic_year_id])->execute();
                        if ($total_score>20 || $total_score==20){
                            Yii::$app->db->createCommand()->update('coursework_nta4',['remarks'=>'Passed'],['student_id' => $model->student_id, 'semester_id' =>$model->semester_id, 'module_id' =>$model->module_id, 'academic_year_id' => $model->academic_year_id])->execute();
                        }
                        else{
                            Yii::$app->db->createCommand()->update('coursework_nta4',['remarks'=>'Failed'],['student_id' => $model->student_id, 'semester_id' =>$model->semester_id, 'module_id' =>$model->module_id, 'academic_year_id' => $model->academic_year_id])->execute();
                        }

                    }
                }
                elseif ($year_of_studies=='5'){
                    $student_exists = CourseworkNta5::find()->where(['student_id' => $model->student_id, 'semester_id' =>$model->semester_id, 'module_id' =>$model->module_id, 'academic_year_id' => $model->academic_year_id])->one();
                    if ($assessment_methods == 'CAT 1') {
                        $parcent=AssessmentMethodTracking::find()->where(['assessment_method_id'=>$model->assessment_method_id,'module_id'=>$model->module_id,'category'=>'CA'])->one()->percent;
                        Yii::$app->db->createCommand()->update('coursework_nta5',['cat_1'=>($model->score/100)*$parcent],['student_id' => $model->student_id, 'semester_id' =>$model->semester_id, 'module_id' =>$model->module_id, 'academic_year_id' => $model->academic_year_id])->execute();

                    }
                    if ($assessment_methods == 'CAT 2') {
                        $parcent=AssessmentMethodTracking::find()->where(['assessment_method_id'=>$model->assessment_method_id,'module_id'=>$model->module_id,'category'=>'CA'])->one()->percent;
                        Yii::$app->db->createCommand()->update('coursework_nta5',['cat_2'=>($model->score/100)*$parcent],['student_id' => $model->student_id, 'semester_id' =>$model->semester_id, 'module_id' =>$model->module_id, 'academic_year_id' => $model->academic_year_id])->execute();

                    }
                    if ($assessment_methods == 'ASSIGNMENT 1') {
                        $parcent=AssessmentMethodTracking::find()->where(['assessment_method_id'=>$model->assessment_method_id,'module_id'=>$model->module_id,'category'=>'CA'])->one()->percent;
                        Yii::$app->db->createCommand()->update('coursework_nta5',['assignment_1'=>($model->score/100)*$parcent],['student_id' => $model->student_id, 'semester_id' =>$model->semester_id, 'module_id' =>$model->module_id, 'academic_year_id' => $model->academic_year_id])->execute();

                    }
                    if ($assessment_methods == 'ASSIGNMENT 2') {
                        $parcent=AssessmentMethodTracking::find()->where(['assessment_method_id'=>$model->assessment_method_id,'module_id'=>$model->module_id,'category'=>'CA'])->one()->percent;
                        Yii::$app->db->createCommand()->update('coursework_nta5',['assignment_2'=>($model->score/100)*$parcent],['student_id' => $model->student_id, 'semester_id' =>$model->semester_id, 'module_id' =>$model->module_id, 'academic_year_id' => $model->academic_year_id])->execute();

                    }
                    if ($assessment_methods == 'Clinical Examination') {
                        $parcent=AssessmentMethodTracking::find()->where(['assessment_method_id'=>$model->assessment_method_id,'module_id'=>$model->module_id,'category'=>'CA'])->one()->percent;
                        Yii::$app->db->createCommand()->update('coursework_nta5',['practical'=>($model->score/100)*$parcent],['student_id' => $model->student_id, 'semester_id' =>$model->semester_id, 'module_id' =>$model->module_id, 'academic_year_id' => $model->academic_year_id])->execute();

                    }
                    if ($assessment_methods =='Portfolio') {
                        $parcent=AssessmentMethodTracking::find()->where(['assessment_method_id'=>$model->assessment_method_id,'module_id'=>$model->module_id,'category'=>'CA'])->one()->percent;
                        Yii::$app->db->createCommand()->update('coursework_nta5',['practical_2'=>($model->score/100)*$parcent],['student_id' => $model->student_id, 'semester_id' =>$model->semester_id, 'module_id' =>$model->module_id, 'academic_year_id' => $model->academic_year_id])->execute();
                    }
                    if ($assessment_methods =='Case Study') {
                        $parcent=AssessmentMethodTracking::find()->where(['assessment_method_id'=>$model->assessment_method_id,'module_id'=>$model->module_id,'category'=>'CA'])->one()->percent;
                        Yii::$app->db->createCommand()->update('coursework_nta5',['practical_2'=>($model->score/100)*$parcent],['student_id' => $model->student_id, 'semester_id' =>$model->semester_id, 'module_id' =>$model->module_id, 'academic_year_id' => $model->academic_year_id])->execute();
                    }
                    if ($assessment_methods =='Field Report') {
                        $parcent=AssessmentMethodTracking::find()->where(['assessment_method_id'=>$model->assessment_method_id,'module_id'=>$model->module_id,'category'=>'CA'])->one()->percent;
                        Yii::$app->db->createCommand()->update('coursework_nta5',['practical_2'=>($model->score/100)*$parcent],['student_id' => $model->student_id, 'semester_id' =>$model->semester_id, 'module_id' =>$model->module_id, 'academic_year_id' => $model->academic_year_id])->execute();
                    }
                    if ($assessment_methods == 'PPB') {
                        $parcent=AssessmentMethodTracking::find()->where(['assessment_method_id'=>$model->assessment_method_id,'module_id'=>$model->module_id,'category'=>'CA'])->one()->percent;
                        Yii::$app->db->createCommand()->update('coursework_nta5',['ppb'=>($model->score/100)*$parcent],['student_id' => $model->student_id, 'semester_id' =>$model->semester_id, 'module_id' =>$model->module_id, 'academic_year_id' => $model->academic_year_id])->execute();

                    }

                    if (!empty($student_exists->total_score)){
                        $cat1_score = CourseworkNta5::find()->where([ 'student_id' => $model->student_id,'semester_id' =>$model->semester_id, 'module_id' =>$model->module_id, 'academic_year_id' => $model->academic_year_id])->sum('cat_1');
                        $cat2_score = CourseworkNta5::find()->where(['student_id' =>$model->student_id, 'semester_id' =>$model->semester_id, 'module_id' =>$model->module_id, 'academic_year_id' => $model->academic_year_id])->sum('cat_2');
                        $assignment_1_score = CourseworkNta5::find()->where(['student_id' => $model->student_id, 'semester_id' =>$model->semester_id, 'module_id' =>$model->module_id, 'academic_year_id' => $model->academic_year_id])->sum('assignment_1');
                        $assignment_2_score = CourseworkNta5::find()->where(['student_id' =>  $model->student_id, 'semester_id' =>$model->semester_id, 'module_id' =>$model->module_id, 'academic_year_id' =>$model->academic_year_id])->sum('assignment_2');
                        $clinical_exam_score= CourseworkNta5::find()->where([ 'student_id' =>  $model->student_id,'semester_id' =>$model->semester_id, 'module_id' =>$model->module_id, 'academic_year_id' => $model->academic_year_id])->sum('practical');
                        $practical_2_score= CourseworkNta6::find()->where([ 'student_id' =>  $model->student_id,'semester_id' =>$model->semester_id, 'module_id' =>$model->module_id, 'academic_year_id' => $model->academic_year_id])->sum('practical_2');
                        $ppb_score= CourseworkNta5::find()->where(['student_id' => $model->student_id, 'semester_id' =>$model->semester_id, 'module_id' =>$model->module_id, 'academic_year_id' => $model->academic_year_id])->sum('ppb');
                        $total_score=$cat1_score+$cat2_score+$assignment_1_score+$assignment_2_score+$clinical_exam_score+$ppb_score+$practical_2_score;

                        Yii::$app->db->createCommand()->update('coursework_nta5',['total_score'=>$total_score],['student_id' => $model->student_id, 'semester_id' =>$model->semester_id, 'module_id' =>$model->module_id, 'academic_year_id' => $model->academic_year_id])->execute();
                        if ($total_score>20 || $total_score==20){
                            Yii::$app->db->createCommand()->update('coursework_nta5',['remarks'=>'Passed'],['student_id' => $model->student_id, 'semester_id' =>$model->semester_id, 'module_id' =>$model->module_id, 'academic_year_id' => $model->academic_year_id])->execute();
                        }
                        else{
                            Yii::$app->db->createCommand()->update('coursework_nta5',['remarks'=>'Failed'],['student_id' => $model->student_id, 'semester_id' =>$model->semester_id, 'module_id' =>$model->module_id, 'academic_year_id' => $model->academic_year_id])->execute();
                        }
                    }

                }
                elseif ($year_of_studies=='6'){
                    $student_exists = CourseworkNta6::find()->where(['student_id' => $model->student_id, 'semester_id' =>$model->semester_id, 'module_id' =>$model->module_id, 'academic_year_id' => $model->academic_year_id])->one();
                    if ($assessment_methods == 'CAT 1') {
                        $parcent=AssessmentMethodTracking::find()->where(['assessment_method_id'=>$model->assessment_method_id,'module_id'=>$model->module_id,'category'=>'CA'])->one()->percent;
                        Yii::$app->db->createCommand()->update('coursework_nta6',['cat_1'=>($model->score/100)*$parcent],['student_id' => $model->student_id, 'semester_id' =>$model->semester_id, 'module_id' =>$model->module_id, 'academic_year_id' => $model->academic_year_id])->execute();
                    }
                    if ($assessment_methods == 'CAT 2') {
                        $parcent=AssessmentMethodTracking::find()->where(['assessment_method_id'=>$model->assessment_method_id,'module_id'=>$model->module_id,'category'=>'CA'])->one()->percent;
                        Yii::$app->db->createCommand()->update('coursework_nta6',['cat_2'=>($model->score/100)*$parcent],['student_id' => $model->student_id, 'semester_id' =>$model->semester_id, 'module_id' =>$model->module_id, 'academic_year_id' => $model->academic_year_id])->execute();

                    }
                    if($assessment_methods == 'ASSIGNMENT 1') {
                        $parcent=AssessmentMethodTracking::find()->where(['assessment_method_id'=>$model->assessment_method_id,'module_id'=>$model->module_id,'category'=>'CA'])->one()->percent;
                        Yii::$app->db->createCommand()->update('coursework_nta6',['assignment_1'=>($model->score/100)*$parcent],['student_id' => $model->student_id, 'semester_id' =>$model->semester_id, 'module_id' =>$model->module_id, 'academic_year_id' => $model->academic_year_id])->execute();

                    }
                    if($assessment_methods == 'ASSIGNMENT 2') {
                        $parcent=AssessmentMethodTracking::find()->where(['assessment_method_id'=>$model->assessment_method_id,'module_id'=>$model->module_id,'category'=>'CA'])->one()->percent;
                        Yii::$app->db->createCommand()->update('coursework_nta6',['assignment_2'=>($model->score/100)*$parcent],['student_id' => $model->student_id, 'semester_id' =>$model->semester_id, 'module_id' =>$model->module_id, 'academic_year_id' => $model->academic_year_id])->execute();

                    }
                    if($assessment_methods == 'Clinical Examination') {
                        $parcent=AssessmentMethodTracking::find()->where(['assessment_method_id'=>$model->assessment_method_id,'module_id'=>$model->module_id,'category'=>'CA'])->one()->percent;
                        Yii::$app->db->createCommand()->update('coursework_nta6',['practical'=>($model->score/100)*$parcent],['student_id' => $model->student_id, 'semester_id' =>$model->semester_id, 'module_id' =>$model->module_id, 'academic_year_id' => $model->academic_year_id])->execute();

                    }
                    if($assessment_methods =='Portfolio') {
                        $parcent=AssessmentMethodTracking::find()->where(['assessment_method_id'=>$model->assessment_method_id,'module_id'=>$model->module_id,'category'=>'CA'])->one()->percent;
                        Yii::$app->db->createCommand()->update('coursework_nta6',['practical_2'=>($model->score/100)*$parcent],['student_id' => $model->student_id, 'semester_id' =>$model->semester_id, 'module_id' =>$model->module_id, 'academic_year_id' => $model->academic_year_id])->execute();
                    }
                    if ($assessment_methods =='Case Study') {
                        $parcent=AssessmentMethodTracking::find()->where(['assessment_method_id'=>$model->assessment_method_id,'module_id'=>$model->module_id,'category'=>'CA'])->one()->percent;
                        Yii::$app->db->createCommand()->update('coursework_nta6',['practical_2'=>($model->score/100)*$parcent],['student_id' => $model->student_id, 'semester_id' =>$model->semester_id, 'module_id' =>$model->module_id, 'academic_year_id' => $model->academic_year_id])->execute();
                    }
                    if ($assessment_methods =='Field Report') {
                        $parcent=AssessmentMethodTracking::find()->where(['assessment_method_id'=>$model->assessment_method_id,'module_id'=>$model->module_id,'category'=>'CA'])->one()->percent;
                        Yii::$app->db->createCommand()->update('coursework_nta6',['practical_2'=>($model->score/100)*$parcent],['student_id' => $model->student_id, 'semester_id' =>$model->semester_id, 'module_id' =>$model->module_id, 'academic_year_id' => $model->academic_year_id])->execute();
                    }
                    if ($assessment_methods == 'PPB') {
                        $parcent=AssessmentMethodTracking::find()->where(['assessment_method_id'=>$model->assessment_method_id,'module_id'=>$model->module_id,'category'=>'CA'])->one()->percent;
                        Yii::$app->db->createCommand()->update('coursework_nta6',['ppb'=>($model->score/100)*$parcent],['student_id' => $model->student_id, 'semester_id' =>$model->semester_id, 'module_id' =>$model->module_id, 'academic_year_id' => $model->academic_year_id])->execute();
                    }
                    if (!empty($student_exists->total_score)){
                        $cat1_score = CourseworkNta6::find()->where([ 'student_id' => $model->student_id,'semester_id' =>$model->semester_id, 'module_id' =>$model->module_id, 'academic_year_id' => $model->academic_year_id])->sum('cat_1');
                        $cat2_score = CourseworkNta6::find()->where(['student_id' =>$model->student_id, 'semester_id' =>$model->semester_id, 'module_id' =>$model->module_id, 'academic_year_id' => $model->academic_year_id])->sum('cat_2');
                        $assignment_1_score = CourseworkNta6::find()->where(['student_id' => $model->student_id, 'semester_id' =>$model->semester_id, 'module_id' =>$model->module_id, 'academic_year_id' => $model->academic_year_id])->sum('assignment_1');
                        $assignment_2_score = CourseworkNta6::find()->where(['student_id' =>  $model->student_id, 'semester_id' =>$model->semester_id, 'module_id' =>$model->module_id, 'academic_year_id' =>$model->academic_year_id])->sum('assignment_2');
                        $clinical_exam_score= CourseworkNta6::find()->where([ 'student_id' =>  $model->student_id,'semester_id' =>$model->semester_id, 'module_id' =>$model->module_id, 'academic_year_id' => $model->academic_year_id])->sum('practical');
                        $practical_2_score= CourseworkNta6::find()->where([ 'student_id' =>  $model->student_id,'semester_id' =>$model->semester_id, 'module_id' =>$model->module_id, 'academic_year_id' => $model->academic_year_id])->sum('practical_2');
                        $ppb_score= CourseworkNta6::find()->where(['student_id' => $model->student_id, 'semester_id' =>$model->semester_id, 'module_id' =>$model->module_id, 'academic_year_id' => $model->academic_year_id])->sum('ppb');
                        $total_score=$cat1_score+$cat2_score+$assignment_1_score+$assignment_2_score+$clinical_exam_score+$ppb_score+$practical_2_score;

                        Yii::$app->db->createCommand()->update('coursework_nta6',['total_score'=>$total_score],['student_id' => $model->student_id, 'semester_id' =>$model->semester_id, 'module_id' =>$model->module_id, 'academic_year_id' => $model->academic_year_id])->execute();
                        if ($total_score>20 || $total_score==20){
                            Yii::$app->db->createCommand()->update('coursework_nta6',['remarks'=>'Passed'],['student_id' => $model->student_id, 'semester_id' =>$model->semester_id, 'module_id' =>$model->module_id, 'academic_year_id' => $model->academic_year_id])->execute();
                        }
                        else{
                            Yii::$app->db->createCommand()->update('coursework_nta6',['remarks'=>'Failed'],['student_id' => $model->student_id, 'semester_id' =>$model->semester_id, 'module_id' =>$model->module_id, 'academic_year_id' => $model->academic_year_id])->execute();
                        }

                    }

                }

                Yii::$app->session->setFlash('getSuccess', '<span class="fa fa-check-square-o"> Congratulations! Changes saved successfully</span>');
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Assignment model.
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
     * Finds the Assignment model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Assignment the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Assignment::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }


    public function actionListsmethod($id)
    {
        $ids = preg_split('/,/', $id);


        if (UserAccount::userHas(['ACADEMIC'])){
            $methods = AssessmentMethod::find()
                ->where(['IN','module_id',$ids])->rightJoin('assessment_method_tracking','assessment_method_tracking.assessment_method_id=assessment_method.id')
                ->orderBy('name ASC')
                ->andWhere(['category'=>'CA'])
                ->all();
        }
        else{
            $methods = AssessmentMethod::find()
                ->where(['IN','module_id',$ids])->rightJoin('assessment_method_tracking','assessment_method_tracking.assessment_method_id=assessment_method.id')
                ->andWhere(['<>','name','CAT 1'])
                ->andWhere(['<>','name','CAT 2'])
                ->andWhere(['category'=>'CA'])
                ->orderBy('name ASC')
                ->all();
        }


        if (!empty($methods)) {
            foreach($methods as $method) {
                echo "<option value =''> ----- Select Method ----- </option>";
                echo "<option value='".$method->id."'>".$method->name."</option>";
            }
        }


    }

    public function actionListsmodule($id){
        $active_semester=\common\models\Semester::find()->where(['status'=>'Active'])->one()->id;
        $active_year=\common\models\AcademicYear::find()->where(['status'=>'Active'])->one()->id;
        $include_module=array_column(\common\models\AssignedModule::find()->where(['semester_id'=>$active_semester,'staff_id'=>Yii::$app->user->identity->user_id])->andWhere(['academic_year_id'=>$active_year])->asArray()->all(),'module_id');

        $ids = preg_split('/,/', $id);

        if (UserAccount::userHas(['ACADEMIC'])){
            $module = Module::find()
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

        else{
            $module = Module::find()
                ->where(['IN','course_id',$ids])
                ->andWhere(['IN','id',$include_module])
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
}
