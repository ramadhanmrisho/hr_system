<?php

namespace backend\controllers;

use common\models\Assignment;
use common\models\Module;
use common\models\Student;
use Yii;
use common\models\Test;
use common\models\search\TestSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\filters\AccessControl;

/**
 * TestController implements the CRUD actions for Test model.
 */
class TestController extends Controller
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
     * Lists all Test models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TestSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Test model.
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
     * Creates a new Test model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Test();


        if ($model->load(Yii::$app->request->post())) {
            $selected_course=$model->course_id;
            $selected_module=$model->module_id;
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
            $allowedColNum=2;

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
                        $checkIfExist=Test::find()->where(['registration_number'=>$fileop[0],'category'=>$model->category,'module_id'=>$model->module_id,'course_id'=>$model->course_id,'year_of_study_id'=>$model->year_of_study_id,'academic_year_id'=>$model->academic_year_id,'semester_id'=>$model->semester_id])->exists();
                        if($checkIfExist){
                            $checkIfExists=Test::findAll(['registration_number'=>$fileop[0],'category'=>$model->category,'module_id'=>$model->module_id,'course_id'=>$model->course_id,'year_of_study_id'=>$model->year_of_study_id,'academic_year_id'=>$model->academic_year_id,'semester_id'=>$model->semester_id]);
                            foreach($checkIfExists as $student) {
                                echo $student["registration_number"];
                                echo '<br>';
                            }
                            Yii::$app->session->setFlash('getWarning', '<span class="fa fa-times"> Sorry! Results of Students with this registration number already exists!</span>');
                            return $this->render('create', ['model' => $model]);
                        }
                        $registration_number= $fileop[0];
                        $score= $fileop[1];
                        $category=$model->category;
                        $module=$model->module_id;
                        $course=$model->course_id;
                        $year_of_study=$model->year_of_study_id;
                        $academic_year=$model->academic_year_id;
                        $semester=$model->semester_id;
                        $created_by=Yii::$app->user->identity->getId();
                        $student_id=Student::find()->where(['registration_number'=>$registration_number])->one()->id;
                        $sql="INSERT INTO test(student_id,registration_number,category,module_id ,course_id ,year_of_study_id ,academic_year_id ,semester_id ,score,created_by) VALUES ('$student_id','$registration_number','$category','$module','$course','$year_of_study','$academic_year','$semester','$score','$created_by')";
                        $query = Yii::$app->db->createCommand($sql)->execute();

                    }
                    if($query) {
                        unlink($model->csv_file);
                        Yii::$app->session->setFlash('getSuccess', '<span class="fa fa-check-square-o"> Congratulations! Results uploaded successfully</span>');
                        return $this->redirect(['index']);
                    }

                }
            }


            if ($model->save()){
                Yii::$app->session->setFlash('getSuccess','<span class="fa fa-ok"> Results Uploaded Successfully!</span>');
                return $this->redirect(['index']);
            }

        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Test model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {

        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {

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
     * Deletes an existing Test model.
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
     * Finds the Test model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Test the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Test::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
