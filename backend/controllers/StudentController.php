<?php

namespace backend\controllers;

use common\models\AcademicYear;
use common\models\ALevelInformation;
use common\models\Course;
use common\models\District;
use common\models\OLevelInformation;
use common\models\ParentInformation;
use common\models\Payment;
use common\models\Semester;
use common\models\UserAccount;
use Yii;
use common\models\Student;
use common\models\search\StudentSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\filters\AccessControl;

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
     * Lists all Student models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new StudentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

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
        $studentModel=new Student();
        $parentModel=new ParentInformation();
        $OlevelModel=new OLevelInformation();
        $AlevelModel=new ALevelInformation();


        $student_load=$studentModel->load(Yii::$app->request->post());
        $parent_load=$parentModel->load(Yii::$app->request->post());
        $Olevel_load=$OlevelModel->load(Yii::$app->request->post());
        $Alevel_load=$AlevelModel->load(Yii::$app->request->post());


        if ($student_load && $parent_load && $Olevel_load && $Alevel_load) {
           
        
            $student_exist=Student::find()->where(['registration_number'=>$studentModel->registration_number])->exists();
            if ($student_exist){
                Yii::$app->session->setFlash('reqDanger', 'This registration Number already exists!');
                return $this->render('create', ['model' => $studentModel,]);
            }


            //SAVING STUDENT INFO
            $newDate = date("Y-m-d", strtotime($studentModel->dob));
            $date_of_admission = date("Y-m-d", strtotime($studentModel->date_of_admission));
            $studentModel->passport_size = UploadedFile::getInstance($studentModel, 'passport_size');
            //$filename =$studentModel->fname.'-'.date('YmdHis').'.' . $studentModel->passport_size->extension;
            $studentModel->dob=$newDate;
            $studentModel->date_of_admission=$date_of_admission;
            $studentModel->created_by=Yii::$app->user->identity->getId();

            if ($studentModel->save(false)){
               
               
             $folderPath = "kcohas/backend/web/student_photo/";
            //$file = $folderPath . $model->passport_size->baseName. '.' . $model->passport_size->extension;
            //file_put_contents($file, $model->passport_size);
                $studentModel->passport_size->saveAs(Yii::getAlias('@web').'kcohas/backend/web/student_photo/' .  $studentModel->passport_size->baseName. '.' .  $studentModel->passport_size->extension);

                //SAVING OTHER INFO
                $parentModel->student_id=$studentModel->id;
                if($parentModel->save(false)){

                    $OlevelModel->o_level_certificate = UploadedFile::getInstance($OlevelModel, 'o_level_certificate');
                    //$filename =$studentModel->fname.'-'.date('YmdHis').'.' . $OlevelModel->o_level_certificate->extension;
                    $OlevelModel->student_id=$studentModel->id;

                    if($OlevelModel->save(false)){
                        $OlevelModel->o_level_certificate->saveAs(Yii::getAlias('@web').'kcohas/backend/web/attachments/' .  $OlevelModel->o_level_certificate->baseName. '.' .  $OlevelModel->o_level_certificate->extension);


                        if (isset($AlevelModel)){
                            if (!empty($AlevelModel->a_level_certificate)){
                            $AlevelModel->a_level_certificate = UploadedFile::getInstance($AlevelModel, 'a_level_certificate');
                            //$filename =$studentModel->fname.'-'.date('YmdHis').'.' . $AlevelModel->a_level_certificate->extension;
                            $AlevelModel->a_level_certificate->saveAs(Yii::getAlias('@web').'kcohas/backend/web/attachments/' .  $AlevelModel->a_level_certificate->baseName. '.' .  $AlevelModel->a_level_certificate->extension);
                            $AlevelModel->student_id=$studentModel->id;
                            $AlevelModel->save();
                            }
                        }

                    }
                }

            }
            //CREATING STUDENT ACCOUNT
            $userAccount_model=new UserAccount();
            $userAccount_model->user_id=$studentModel->id;
            $userAccount_model->username=$studentModel->registration_number ;
            $userAccount_model->password=Yii::$app->security->generatePasswordHash($studentModel->registration_number);
            $userAccount_model->email=$studentModel->email;
            $userAccount_model->category='student';
            $userAccount_model->created_by=Yii::$app->user->identity->getId();
            $userAccount_model->save(false);
            Yii::$app->session->setFlash('getSuccess', 'Student Information Saved Successfully !');
            return $this->redirect(['view', 'id' => $studentModel->id]);
        }

        return $this->render('create', [
            'model' => $studentModel,
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

        if ($model->load(Yii::$app->request->post()) ) {


      if($model->save()){

                $user=UserAccount::findOne(['user_id' =>$model->id,'category'=>'student']);
                $user->username=$model->registration_number;
                $user->password=Yii::$app->security->generatePasswordHash($model->registration_number);
                $user->save(false);

                //Yii::$app->db->createCommand()->update('user_account', ['username' =>$model->registration_number], ['user_id' =>$model->id])->execute();
                Yii::$app->session->setFlash('getSuccess', ' <span class="fa fa-check-square-o"> Changes Saved Successfully !</span>');
                return $this->redirect(['view', 'id' => $model->id]);
            }



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

    public function actionListsdistrict($id)
    {
        $ids = preg_split('/,/', $id);
        $district = District::find()
            ->where(['IN','region_id',$ids])
            ->orderBy('name ASC')
            ->all();
        if (!empty($district)) {
            foreach($district as $dist) {
                echo "<option value =''> ----- Select District ----- </option>";
                echo "<option value='".$dist->id."'>".$dist->name."</option>";
            }
        }

    }


    public function actionUploadPhoto($id){
        $model = $this->findModel($id);
        $model->passport_size = UploadedFile::getInstance($model, 'passport_size');
        $model->created_by=Yii::$app->user->identity->getId();
        if( !is_null($model->passport_size) && file_exists('/'.$model->passport_size)){
            unlink('/'.$model->passport_size);
            $file = $this->upload($model);
            if($model->save())
            {
            $folderPath = "kcohas/backend/web/student_photo/";
            $file = $folderPath . $model->passport_size->baseName. '.' . $model->passport_size->extension;
            file_put_contents($file, $model->passport_size);
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
                
                 $folderPath = "kcohas/backend/web/student_photo/";
            $file = $folderPath . $model->passport_size->baseName. '.' . $model->passport_size->extension;
            file_put_contents($file, $model->passport_size);
                //$saved=$model->passport_size->saveAs('student_photo/' . $model->passport_size->baseName. '.' . $model->passport_size->extension);
            }

            if($model->save(false))
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
    
  
    //MARKING PAYMENT FOR STUDENT BY ACCOUNTANT
    public  function actionPayment($id){

        $model = $this->findModel($id);

        $payment_model=new Payment();
        $payment_model->student_id=$model->id;
        $payment_model->academic_year_id=$model->academic_year_id;
        $payment_model->nta_level=$model->nta_level;
        $payment_model->course_id=$model->course_id;
        $payment_model->semester_id=Semester::find()->where(['status'=>'Active'])->one()->id;
        $payment_model->status='Paid';
        $payment_model->created_by=Yii::$app->user->identity->getId();
        if (  $payment_model->save(false)){
            Yii::$app->session->setFlash('getSuccess', ' <span class="fa fa-check-square-o"> Saved Successfully</span>!');
            return $this->redirect(['view', 'id' => $id]);
        }
    }


//MOVE TO NEXT LEVEL
    public function actionPromote($authorization){
        
    //   var_dump($student_ids);
    //           die();

        if(Yii::$app->request->isAjax && Yii::$app->request->post())
        {
          

            //GENERATE NEXT ACADEMIC YEAR IF NOT EXIST
            $current = date('Y');
            $next = date('Y', strtotime('+1 year'));
            $year=$current.'/'.$next;
            $academic_year_exist=AcademicYear::find()->where(['name'=>$year,'status'=>'Inactive'])->exists();
            if (!$academic_year_exist){
                $new_academic_year=new AcademicYear();
                $new_academic_year->name=$year;
                $new_academic_year->status='Inactive';
                $new_academic_year->created_by=Yii::$app->user->identity->getId();
                $new_academic_year->save();
            }
            $new_academic_year_id=AcademicYear::find()->where(['status'=>'Inactive','name'=>$year])->one()->id;

            $student_ids = explode(',',$_POST['data']);
              
            $title=$authorization;
            if (empty($_POST['data'])){
                Yii::$app->session->setFlash('getDanger', ' <span class="fa fa-warning"> You must select atleast one student</span>!');
                return $this->redirect(['index','authorization'=>$authorization]);
            }
            


      if (!empty($student_ids)){
          foreach ($student_ids as $student_id){
              //$student=Student::find()->where(['id'=>$student_id])->one();
              if ($title=='clinical_1'){
                  $course_id=Course::find()->where(['nta_level'=>'5','abbreviation'=>'NTA5_CM'])->one()->id;
                  Yii::$app->db->createCommand()->update('student', ['nta_level' => '5', 'status' => 'Continuing', 'course_id' =>$course_id,'academic_year_id'=>$new_academic_year_id], ['id' => $student_id])->execute();
              }
              elseif ($title=='clinical_2'){
                  $course_id=Course::find()->where(['nta_level'=>'6','abbreviation'=>'NTA6_CM'])->one()->id;
                  Yii::$app->db->createCommand()->update('student', ['nta_level' => '6', 'status' => 'Continuing', 'course_id' =>$course_id,'academic_year_id'=>$new_academic_year_id], ['id' => $student_id])->execute();
              }
              elseif ($title=='nursing_1'){
                  $course_id=Course::find()->where(['nta_level'=>'5','abbreviation'=>'NTA5_NM'])->one()->id;
                  Yii::$app->db->createCommand()->update('student', ['nta_level' => '5', 'status' => 'Continuing', 'course_id' =>$course_id,'academic_year_id'=>$new_academic_year_id], ['id' => $student_id])->execute();

              }
              elseif ($title=='nursing_2'){
                  $course_id=Course::find()->where(['nta_level'=>'6','abbreviation'=>'NTA6_NM'])->one()->id;
                  Yii::$app->db->createCommand()->update('student', ['nta_level' => '5', 'status' => 'Continuing', 'course_id' =>$course_id,'academic_year_id'=>$new_academic_year_id], ['id' => $student_id])->execute();
              }

          }

          Yii::$app->session->setFlash('getSuccess', ' <span class="fa fa-check-square-o">  Successfully Moved to next level</span>!');
          return $this->redirect(['index','authorization'=>$authorization]);
      }
        }
        else{
            Yii::$app->session->setFlash('getDanger', ' <span class="fa fa-close"> Failed to move to the level</span>!');
            return $this->redirect(['index','authorization'=>$authorization]);
        }



    }




}
