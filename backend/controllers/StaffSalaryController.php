<?php

namespace backend\controllers;

use common\models\Allowance;
use common\models\Department;
use common\models\Staff;
use common\models\StaffAllowance;
use Yii;
use common\models\StaffSalary;
use common\models\search\StaffSalarySearch;
use yii\data\ActiveDataProvider;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use kartik\mpdf\Pdf;
use yii\filters\AccessControl;

/**
 * StaffSalaryController implements the CRUD actions for StaffSalary model.
 */
class StaffSalaryController extends Controller
{

    public $staff;
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
     * Lists all StaffSalary models.
     * @return mixed
     */
    public function actionIndex()
    {
        if (\common\models\UserAccount::userHas(['HR','PR','ACC','ADMIN'])){
            $searchModel = new StaffSalarySearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);

        }


        else{
            $searchModel=new StaffSalarySearch();

            $dataProvider=new ActiveDataProvider([
                'query'=>StaffSalary::find()->where(['staff_id'=>Yii::$app->user->identity->user_id])->orderBy(['created_at'=>SORT_DESC])
            ]);
            return $this->render('index',['searchModel' => $searchModel, 'dataProvider' => $dataProvider]);


        }





    }

    /**
     * Displays a single StaffSalary model.
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
     * Creates a new StaffSalary model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new StaffSalary();

        if ($model->load(Yii::$app->request->post()) ) {


            $check_salary_slip=StaffSalary::find()->where(['month'=>$model->month,'staff_id'=>$model->staff_id, 'date_format(created_at,"%Y")' => date('Y')])->exists();
            if($check_salary_slip){

                Yii::$app->session->setFlash('getDanger','<span class="fa fa-warning">This Payslip is already exists! Please review the  generated slips</span>');
                return $this->render('create', ['model' => $model,]);
            }


            $month=$model->month.' '.date('Y');
            $staff=Staff::find()->where(['id'=>$model->staff_id])->one();
            $staff_name=$staff->fname.'  '.$staff->lname;
            $staff_number=$staff->employee_number;
            $date_joining=date('F j, Y',strtotime($staff->date_employed));
            $department=Department::find()->where(['id'=>$staff->department_id])->one()->name;
            $account_name=$staff->account_name;
            $account_number=$staff->bank_account_number;
            $basic_salary=Yii::$app->formatter->asDecimal($staff->basic_salary,2);

            //FINDiING A BEST WAY TO GET THESE IDs

            $staff_allowances_exists=StaffAllowance::find()->where(['staff_id'=>$model->staff_id])->exists();

            if ($staff_allowances_exists){
                $staff_allowances=StaffAllowance::find()->where(['staff_id'=>$model->staff_id])->all();
                foreach ($staff_allowances as $posho){
                    $allowance_name=Allowance::find()->where(['id'=>$posho['allowance_id']])->one()->name;

                    if($allowance_name=='HOD Allowance'){
                        $hod_allowance_id=Allowance::find()->where(['name'=>$allowance_name,'id'=>$posho['allowance_id']])->one()->id;
                        $hod_allowance=StaffAllowance::find()->where(['staff_id'=>$model->staff_id,'allowance_id'=>$hod_allowance_id])->exists();
                        if ($hod_allowance){
                            $hod_allowance_amount=Allowance::find()->where(['id'=>$hod_allowance_id])->sum('amount');
                        }
                        else{
                            $hod_allowance_amount=0;
                        }
                    }
                    if($allowance_name=='Transport Allowance'){
                        $transport_allowance_id=Allowance::find()->where(['name'=>$allowance_name,'id'=>$posho['allowance_id']])->one()->id;
                        $transport_allowance=StaffAllowance::find()->where(['staff_id'=>$model->staff_id,'allowance_id'=>$transport_allowance_id])->exists();
                        if ($transport_allowance){
                            $transport_allowance_amount=Allowance::find()->where(['id'=>$transport_allowance_id])->sum('amount');
                        }
                        else{
                            $transport_allowance_amount=0;
                        }
                    }
                    if($allowance_name=='House Allowance'){
                        $house_allowance_id=Allowance::find()->where(['name'=>$allowance_name,'id'=>$posho['allowance_id']])->one()->id;
                        $house_allowance=StaffAllowance::find()->where(['staff_id'=>$model->staff_id,'allowance_id'=>$house_allowance_id])->exists();
                        if ($house_allowance){
                            $house_allowance_amount=Allowance::find()->where(['id'=>$house_allowance_id])->sum('amount');
                        }
                        else{
                            $house_allowance_amount=0;
                        }
                    }

                    if($allowance_name=='Teaching Allowance'){
                        $teaching_allowance_id=Allowance::find()->where(['name'=>$allowance_name,'id'=>$posho['allowance_id']])->one()->id;
                        $teaching_allowance=StaffAllowance::find()->where(['staff_id'=>$model->staff_id,'allowance_id'=>$teaching_allowance_id])->exists();
                        if ($teaching_allowance){
                            $teaching_allowance_amount=Allowance::find()->where(['id'=>$teaching_allowance_id])->sum('amount');
                        }
                        else{
                            $teaching_allowance_amount=0;
                        }

                    }

                    if($allowance_name=='COOK ALLOWANCE'){
                        $cooking_allowance_id=Allowance::find()->where(['name'=>$allowance_name,'id'=>$posho['allowance_id']])->one()->id;
                        $cooking_allowance=StaffAllowance::find()->where(['staff_id'=>$model->staff_id,'allowance_id'=>$cooking_allowance_id])->exists();
                        if ($cooking_allowance){
                            $cooking_allowance_amount=Allowance::find()->where(['id'=>$cooking_allowance_id])->sum('amount');
                        }
                        else{
                            $cooking_allowance_amount=0;
                        }

                    }
                    if($allowance_name=='DRIVER ALLOWANCE'){
                        $driver_allowance_id=Allowance::find()->where(['name'=>$allowance_name,'id'=>$posho['allowance_id']])->one()->id;
                        $driver_allowance=StaffAllowance::find()->where(['staff_id'=>$model->staff_id,'allowance_id'=>$driver_allowance_id])->exists();
                        if ($driver_allowance){
                            $driver_allowance_amount=Allowance::find()->where(['id'=>$driver_allowance_id])->sum('amount');
                        }
                        else{
                            $driver_allowance_amount=0;
                        }

                    }




                }
            }




            $paye=$staff->paye;
            $helsb=$staff->helsb;
            $nssf=$staff->nssf;
            $nhif=$staff->nhif;
            $TUGHE=$staff->TUGHE;
            $helsb1=!empty($helsb)?$helsb:0;
            $nssf1=!empty($nssf)?$nssf:0;
            $TUGHE1=!empty($TUGHE)?$TUGHE:0;
            $total_deduction=$paye+$nhif+$helsb1+$nssf1+ $TUGHE1;







            $hod_allowance_amount=isset($hod_allowance_amount)?$hod_allowance_amount:0;
            $transport_allowance_amount=isset($transport_allowance_amount)?$transport_allowance_amount:0;
            $house_allowance_amount=isset($house_allowance_amount)?$house_allowance_amount:0;
            $teaching_allowance_amount=isset($teaching_allowance_amount)?$teaching_allowance_amount:0;
            $cooking_allowance_amount=isset($cooking_allowance_amount)?$cooking_allowance_amount:0;
            $driver_allowance_amount=isset($driver_allowance_amount)?$driver_allowance_amount:0;

            $total_earnings=$staff->basic_salary+$hod_allowance_amount+$transport_allowance_amount+$house_allowance_amount+$teaching_allowance_amount+$cooking_allowance_amount+$driver_allowance_amount;
            $pdf = new Pdf([
                'mode' => Pdf::MODE_CORE, // leaner size using standard fonts
                'destination' => Pdf::DEST_DOWNLOAD,
                'content' =>$this->renderPartial('slip',[
                    'model'=>$model,
                    'staff'=>$staff_name,
                    'staff_number'=>$staff_number,
                    'date_joining'=>$date_joining,
                    'department'=>$department,
                    'account_name'=>$account_name,
                    'account_number'=>$account_number,
                    'basic_salary'=>$basic_salary,
                    'paye'=>Yii::$app->formatter->asDecimal($paye,2),
                    'helsb'=>Yii::$app->formatter->asDecimal($helsb,2),
                    'nssf'=>Yii::$app->formatter->asDecimal($nssf,2),
                    'nhif'=>Yii::$app->formatter->asDecimal($nhif,2),
                    'TUGHE'=>Yii::$app->formatter->asDecimal($TUGHE,2),
                    'total_deduction'=>$total_deduction,
                    'month'=>$month,
                    'hod_allowance_amount'=>!is_null($hod_allowance_amount)?$hod_allowance_amount:0,
                    'transport_allowance_amount'=>!is_null($transport_allowance_amount)?$transport_allowance_amount:0,
                    'house_allowance_amount'=>!is_null($house_allowance_amount)?$house_allowance_amount:0,
                    'teaching_allowance_amount'=>!is_null($teaching_allowance_amount)?$teaching_allowance_amount:0,
                    'cooking_allowance_amount'=>!is_null($cooking_allowance_amount)?$cooking_allowance_amount:0,
                    'driver_allowance_amount'=>!is_null($driver_allowance_amount)?$driver_allowance_amount:0,
                    'total_earnings'=>$total_earnings

                ]),


                'options' => [
                    'target'=>'_blank',
//                    'showWatermarkImage' => true,
                ],


                'filename'=>$staff_name.' '.date("F, Y"),
                'cssInline' => '*,body{font-family:Times New Roman;font-size:11pt}',

                'methods' => [
                    'SetTitle' => 'KCOHAS Salary Slip',
//                    'SetWatermarkImage' => [\yii\helpers\Url::to(['images/logo.png'])],
                    'SetSubject' => 'Generating PDF files via yii2-mpdf extension has never been easy',
                    'SetHeader' => ['Generated On: ' . date("r")],
                    'SetFooter' => ['|Page {PAGENO}|'],
                    'SetAuthor' => 'KCOHAS',
                    'SetCreator' => 'KCOHAS',
                    'SetKeywords' => 'Krajee, Yii2, Export, PDF, MPDF, Output, Privacy, Policy, yii2-mpdf',
                ]
            ]);


            $folderPath = "kcohas/backend/web/slips/";
            $fileName=strtotime(date('Y-m-d H:i:s'));
            $file = $folderPath . $fileName.'.'.'pdf';
            file_put_contents($file, $pdf->render());


            //SAVING SALARY SLIPS INFO
            $model->created_by=Yii::$app->user->identity->getId();
            $model->salary_slip=$fileName;
            $model->save();

            return $this->redirect(['view', 'id' => $model->id]);

        }

        return $this->render('create', [
            'model' => $model,

        ]);
    }

    /**
     * Updates an existing StaffSalary model.
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
     * Deletes an existing StaffSalary model.
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
     * Finds the StaffSalary model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return StaffSalary the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = StaffSalary::findOne($id)) !== null) {
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
        $url = Url::to(['/staff-salary/document','id'=>$id,'pdf'=>1]);
        $name  ='Payslip';
        $is_docx = preg_match('/.doc(x)?$/',$model->salary_slip);
        return $this->render('_pdf',compact('url','name','is_docx'));
    }




    public function actionDocument($id,$pdf=0){
        $file = $this->findModel($id);
        $path = __DIR__.'/../web/slips/'.$file->salary_slip.'.pdf';
        //$path =Yii::getAlias('@web/slips/'.$file->salary_slip);
        if (!file_exists($path)){

            return 'File Not found'.$path;
        }
        elseif ($pdf==1 && preg_match('/.doc(x)?$/',$path) && file_exists(preg_replace('/.doc(x)?$/','.pdf',$path))){
            $path = preg_replace('/.doc(x)?$/','.pdf',$path);
        }
        return  Yii::$app->response->sendFile($path);
    }




    public function actionViewSlip() {
        Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
        $pdf = new Pdf([
            'mode' => Pdf::MODE_CORE, // leaner size using standard fonts
            'destination' => Pdf::DEST_BROWSER,
            'content' => $this->renderPartial('slip'),

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
}
