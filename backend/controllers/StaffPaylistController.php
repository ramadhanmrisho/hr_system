<?php

namespace backend\controllers;

use common\models\Staff;
use kartik\mpdf\Pdf;
use Yii;
use common\models\StaffPaylist;
use common\models\search\StaffPaylistSearch;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * StaffPaylistController implements the CRUD actions for StaffPaylist model.
 */
class StaffPaylistController extends Controller
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
     * Lists all StaffPaylist models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new StaffPaylistSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);



        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single StaffPaylist model.
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
     * Creates a new StaffPaylist model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new StaffPaylist();

        if ($model->load(Yii::$app->request->post()) ) {


            $check_paylist=StaffPaylist::find()->where(['month'=>$model->month,'date_format(created_at,"%Y")' => date('Y')])->exists();
            if($check_paylist){

                Yii::$app->session->setFlash('getDanger','<span class="fa fa-warning">This Paylist  already exists! Please review the  generated paylists</span>');
                return $this->render('create', ['model' => $model,]);
            }


            $month=$model->month;
            $all_staff=Staff::find()->rightJoin('user_account','user_account.user_id=staff.id')->where(['user_account.category'=>'staff'])->andWhere(['status'=>10])->orderBy(['fname'=>SORT_ASC])->all();



            $pdf = new Pdf([
                'mode' => Pdf::MODE_CORE, // leaner size using standard fonts
                'destination' => Pdf::DEST_DOWNLOAD,
                'content' =>$this->renderPartial('paylist',[
                    'model'=>$model,
                    'all_staff'=>$all_staff,
                    'month'=>$month,

                ]),

                'options' => [
                    'target'=>'_blank',
                'showWatermarkImage' => true,
                ],

                'filename'=>$month.' '.date("F, Y"),
                'cssInline' => '*,body{font-family:Times New Roman;font-size:11pt}',

                'methods' => [
                    'SetTitle' => 'KCOHAS Paylist',
                    'SetSubject' => 'Generating PDF files via yii2-mpdf extension has never been easy',
                    'SetHeader' => ['Generated On: ' . date("r")],
                    'SetFooter' => ['|Page {PAGENO}|'],
                    'SetAuthor' => 'KCOHAS',
                    'SetCreator' => 'KCOHAS',
                    'SetKeywords' => 'Krajee, Yii2, Export, PDF, MPDF, Output, Privacy, Policy, yii2-mpdf',
                ]
            ]);


            $folderPath ="kcohas/backend/web/paylists/";
            $fileName=strtotime(date('Y-m-d H:i:s'));
            $file = $folderPath . $fileName.'.'.'pdf';
            file_put_contents($file, $pdf->render());

            //SAVING PAY LIST INFO
            $model->created_by=Yii::$app->user->identity->user_id;
            $model->paylist=$fileName;
            $model->save();





            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing StaffPaylist model.
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
     * Deletes an existing StaffPaylist model.
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
     * Finds the StaffPaylist model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return StaffPaylist the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = StaffPaylist::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
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
        $url = Url::to(['/staff-paylist/document','id'=>$id,'pdf'=>1]);
        $name  ='Paylist';
        $is_docx = preg_match('/.doc(x)?$/',$model->paylist);
        return $this->render('_pdf',compact('url','name','is_docx'));
    }




    public function actionDocument($id,$pdf=0){
        $file = $this->findModel($id);
        $path = __DIR__.'/../web/paylists/'.$file->paylist.'.pdf';
        if (!file_exists($path)){

            return 'File Not found'.$path;
        }
        elseif ($pdf==1 && preg_match('/.doc(x)?$/',$path) && file_exists(preg_replace('/.doc(x)?$/','.pdf',$path))){
            $path = preg_replace('/.doc(x)?$/','.pdf',$path);
        }
        return  Yii::$app->response->sendFile($path);
    }
}
