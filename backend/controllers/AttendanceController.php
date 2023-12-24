<?php

namespace backend\controllers;

use common\models\Roster;
use common\models\Staff;
use common\models\UserAccount;
use DateTime;
use Yii;
use common\models\Attendance;
use common\models\search\AttendanceSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * AttendanceController implements the CRUD actions for Attendance model.
 */
class AttendanceController extends Controller
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
     * Lists all Attendance models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AttendanceSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Attendance model.
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
     * Creates a new Attendance model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Attendance();

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {

                $csv = UploadedFile::getInstance($model,'attached_file');
                if ($csv != null) {

                    $model->attached_file= UploadedFile::getInstance($model, 'attached_file');
                    $filename = 'attendances/' . date('Ymd-His') . '.' .$model->attached_file->extension;
                    if ($csv->saveAs($filename)) {
                        $file = fopen($filename, 'r+');
                        $line = 0;
                        $header = [];
                        $transaction = Yii::$app->db->beginTransaction();
                        try {

                            $previous_row = null;
                            while ($file && $row = fgetcsv($file)) {
                                //echo "Whiling"; exit();
                                $model2 = new Attendance();
                                $line++;
                                if ($line == 1) {
                                    $header = $row;
                                } else {
                                    $userID=UserAccount::findOne(['id' =>Yii::$app->user->identity->getId()])->user_id;
                                    $model2->staff_id=\common\helpers\ImportHelper::value2Id(Staff::className(), 'employee_number',$row[0]);
//                                    $model2->date=date('Y-m-d',strtotime($row[1]));
//                                    $model2->signin_at=date('Y-m-d H:i:s',strtotime($row[2]));
//                                    $model2->singout_at=date('Y-m-d H:i:s',strtotime($row[3]));

                                    $date = DateTime::createFromFormat('d/m/Y', $row[1]);
                                    if ($date) {
                                        $model2->date =$date->format('Y-m-d');
                                    }

                                    $signinDate = DateTime::createFromFormat('d/m/Y H:i', $row[2]);
                                    if ($signinDate) {
                                        $model2->signin_at = $signinDate->format('Y-m-d H:i:s');
                                    }

                                    $signoutDate = DateTime::createFromFormat('d/m/Y H:i', $row[3]);
                                    if ($signoutDate) {
                                        $model2->singout_at = $signoutDate->format('Y-m-d H:i:s');
                                    }
                                    $model2->created_by=$userID;
                                    $dateTime1 = new \DateTime($model2->signin_at);
                                    $dateTime2 = new \DateTime($model2->singout_at);
                                    $interval = $dateTime1->diff($dateTime2);
                                    $model2->hours_per_day=$interval->h + ($interval->days * 24);
                                    $model2->night_hours=$this->calculateNightHours($model2->singout_at);
                                    $model2->normal_ot_hours=$this->calculateNormalOvertimeHours( $model2->signin_at,$model2->singout_at);
                                    $model2->save(false);
                                }
                            }
                            $transaction->commit();
                            unlink($filename);
                            Yii::$app->session->setFlash('getSuccess',' <span class="fa fa-check-square-o">Attendance Uploaded Successfully</span>');
                            return $this->redirect(['/attendance/index']);
                        }

                        catch (\Exception $e) {
                           // var_dump( $e->getMessage());die();
                            Yii::$app->session->setFlash('getError',$e->getMessage());
                            fclose($file);
                            unlink($filename);
                            $transaction->rollBack();
                            return $this->render('create', ['model' => $model,]);
                        }
                    }
                }else{

                    Yii::$app->session->setFlash('danger', 'No file attached');
                    return $this->redirect(['/shule/index']);
                }

            }
        } else {
            $model->loadDefaultValues();
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }


   public static  function calculateNightHours($signoutDateTime)
    {
        // Convert the string signout date and time to a DateTime object
        $signout =new \DateTime($signoutDateTime);

        // Set the night start time (22:00:00)
        $nightStartTime =new \DateTime($signout->format('Y-m-d') . ' 20:00:00');

        // Calculate night hours if the signout time is after 22:00:00
        if ($signout > $nightStartTime) {
            // Calculate the difference between signout time and night start time
            $nightHours = $signout->diff($nightStartTime)->h;

            // Calculate the minutes if needed
            $nightMinutes = $signout->diff($nightStartTime)->i;

            // Total night hours
            $nightTotal = $nightHours + ($nightMinutes / 60);

            return $nightTotal;
        } else {
            return 0; // No night hours if the signout time is before 22:00:00
        }
    }


   public static function calculateNormalOvertimeHours($signinDateTime, $signoutDateTime)
    {
        $normalWorkingHours=Roster::find()->where(['status'=>1])->one()->working_hours;
        // Convert the string sign-in and sign-out date and times to DateTime objects
        $signin = new \DateTime($signinDateTime);
        $signout = new \DateTime($signoutDateTime);

        // Calculate the time difference between sign-in and sign-out times
        $timeDifference = $signin->diff($signout);

        // Calculate the total hours worked
        $totalHoursWorked = $timeDifference->h + ($timeDifference->i / 60);

        // Calculate normal overtime hours if the total hours worked exceed the normal working hours
        if ($totalHoursWorked > $normalWorkingHours) {
            $normalOvertimeHours = $totalHoursWorked - $normalWorkingHours;
            return $normalOvertimeHours;
        } else {
            return 0; // No normal overtime if hours worked are within normal working hours
        }
    }




    /**
     * Updates an existing Attendance model.
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
     * Deletes an existing Attendance model.
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
     * Finds the Attendance model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Attendance the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Attendance::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
