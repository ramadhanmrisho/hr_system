<?php

namespace backend\controllers;

use common\models\Payment;
use common\models\Student;
use kartik\mpdf\Pdf;
use Yii;
use common\models\StudentPaymentReport;
use common\models\search\StudentPaymentReportSearch;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * StudentPaymentReportController implements the CRUD actions for StudentPaymentReport model.
 */
class StudentPaymentReportController extends Controller
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
     * Lists all StudentPaymentReport models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new StudentPaymentReportSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single StudentPaymentReport model.
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



    public function actionCreate()
    {
        $model = new StudentPaymentReport();
        if ($model->load(Yii::$app->request->post())) {


            if ($model->status=='Paid'){
                $payment_model=Payment::findOne(['academic_year_id'=>$model->academic_year_id,'course_id'=>$model->course_id,'semester_id'=>$model->semester_id]);
                if (empty($payment_model)){
                    Yii::$app->session->setFlash('getDanger',' <span class="fa fa-warning"> No any Students Available ! </span>');
                    return $this->render('create', ['model' => $model,]);
                }
                $student=Payment::find()->innerJoin('student','student.id=payment.student_id')->where(['payment.academic_year_id'=>$model->academic_year_id,'payment.course_id'=>$model->course_id,'payment.semester_id'=>$model->semester_id])->orderBy(['fname'=>SORT_ASC])->all();
            }


            elseif($model->status=='Not Paid'){
                $exclude =array_column(
                    Payment::find()->where(['academic_year_id'=>$model->academic_year_id])
                        ->andWhere(['course_id'=>$model->course_id])
                        ->andWhere(['semester_id'=>$model->semester_id])
                        ->select(['student_id'])
                        ->asArray()
                        ->all(),
                    'student_id'
                );

                $student= Student::find()->where(['academic_year_id'=>$model->academic_year_id,'course_id'=>$model->course_id])->andWhere(['NOT IN','id',$exclude])->all();

                if (empty($student)){
                    Yii::$app->session->setFlash('getDanger',' <span class="fa fa-warning"> No any Students Available ! </span>');
                    return $this->render('create', ['model' => $model,]);
                }
            }




            //  ->rightJoin('user_account','user_account.user_id=staff.id')
            // ->andWhere(['status'=>10])->orderBy(['fname'=>SORT_ASC])

            $pdf = new Pdf([
                'mode' => Pdf::MODE_CORE, // leaner size using standard fonts
                'destination' => Pdf::DEST_DOWNLOAD,
                'content' =>$this->renderPartial('paylist',[
                    'model'=>$model,
                    'student'=>$student,


                ]),

                'options' => [
                    'target'=>'_blank',
                    'showWatermarkImage' => true,
                ],

                'filename'=>$model->status.' '.date("F, Y"),
                'cssInline' => '*,body{font-family:Times New Roman;font-size:11pt}',

                'methods' => [
                    'SetTitle' => 'KCOHAS Student Financial Report',
                    'SetSubject' => 'Generating PDF files via yii2-mpdf extension has never been easy',
                    'SetHeader' => ['Generated On: ' . date("r")],
                    'SetFooter' => ['|Page {PAGENO}|'],
                    'SetAuthor' => 'KCOHAS',
                    'SetCreator' => 'KCOHAS',
                    'SetKeywords' => 'Krajee, Yii2, Export, PDF, MPDF, Output, Privacy, Policy, yii2-mpdf',
                ]
            ]);


            $folderPath = "kcohas/backend/web/studentlists/";
            $fileName=strtotime(date('Y-m-d H:i:s'));
            $file = $folderPath . $fileName.'.'.'pdf';
            file_put_contents($file, $pdf->render());


            //$payment_model=new StudentPaymentReport();
            $model->file_name=$fileName;
            $model->save(false);



            return $this->redirect(['view', 'id' => $model->id]);

        }


        return $this->render('create', [
            'model' => $model,
        ]);
    }



    /**
     * Displays a single slip model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionPdfViewer($id)
    {
        $model = $this->findModel($id);
        $this->layout = 'pdf.php';
        $url = Url::to(['/student-payment-report/document','id'=>$id,'pdf'=>1]);
        $name  ='Paylist';
        $is_docx = preg_match('/.doc(x)?$/',$model->file_name);
        return $this->render('_pdf',compact('url','name','is_docx'));
    }




    public function actionDocument($id,$pdf=0){
        $file = $this->findModel($id);
        $path = __DIR__.'/../web/studentlists/'.$file->file_name.'.pdf';
        if (!file_exists($path)){

            return 'File Not found'.$path;
        }
        elseif ($pdf==1 && preg_match('/.doc(x)?$/',$path) && file_exists(preg_replace('/.doc(x)?$/','.pdf',$path))){
            $path = preg_replace('/.doc(x)?$/','.pdf',$path);
        }
        return  Yii::$app->response->sendFile($path);
    }


    /**
     * Updates an existing StudentPaymentReport model.
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
     * Deletes an existing StudentPaymentReport model.
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
     * Finds the StudentPaymentReport model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return StudentPaymentReport the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = StudentPaymentReport::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
