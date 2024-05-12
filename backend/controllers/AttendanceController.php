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

use yii\db\Expression;

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
//    public function actionCreate()
//    {
//        $model = new Attendance();
//
//        if ($this->request->isPost) {
//            if ($model->load($this->request->post())) {
//
//                $csv = UploadedFile::getInstance($model,'attached_file');
//                if ($csv != null) {
//
//                    $model->attached_file= UploadedFile::getInstance($model, 'attached_file');
//                    $filename = 'attendances/' . date('Ymd-His') . '.' .$model->attached_file->extension;
//                    if ($csv->saveAs($filename)) {
//                        $file = fopen($filename, 'r+');
//                        $line = 0;
//                        $header = [];
//                        $transaction = Yii::$app->db->beginTransaction();
//                        try {
//
//                            $previous_row = null;
//                            while ($file && $row = fgetcsv($file)) {
//                                //echo "Whiling"; exit();
//                                $model2 = new Attendance();
//                                $line++;
//                                if ($line == 1) {
//                                    $header = $row;
//                                } else {
//                                    $userID=UserAccount::findOne(['id' =>Yii::$app->user->identity->getId()])->user_id;
//                                    $model2->staff_id=\common\helpers\ImportHelper::value2Id(Staff::className(), 'employee_number',$row[0]);
////                                    $model2->date=date('Y-m-d',strtotime($row[1]));
////                                    $model2->signin_at=date('Y-m-d H:i:s',strtotime($row[2]));
////                                    $model2->singout_at=date('Y-m-d H:i:s',strtotime($row[3]));
//
//                                    $date = DateTime::createFromFormat('d/m/Y', $row[1]);
//                                    if ($date) {
//                                        $model2->date =$date->format('Y-m-d');
//                                    }
//
//                                    $signinDate = DateTime::createFromFormat('d/m/Y H:i', $row[2]);
//                                    if ($signinDate) {
//                                        $model2->signin_at = $signinDate->format('Y-m-d H:i:s');
//                                    }
//
//                                    $signoutDate = DateTime::createFromFormat('d/m/Y H:i', $row[3]);
//                                    if ($signoutDate) {
//                                        $model2->singout_at = $signoutDate->format('Y-m-d H:i:s');
//                                    }
//                                    $model2->created_by=$userID;
//                                    $dateTime1 = new \DateTime($model2->signin_at);
//                                    $dateTime2 = new \DateTime($model2->singout_at);
//                                    $interval = $dateTime1->diff($dateTime2);
//                                    $model2->hours_per_day=$interval->h + ($interval->days * 24);
//                                    $model2->night_hours=$this->calculateNightHours($model2->singout_at);
//                                    $model2->normal_ot_hours=$this->calculateNormalOvertimeHours( $model2->signin_at,$model2->singout_at);
//                                    $model2->save(false);
//                                }
//                            }
//                            $transaction->commit();
//                            unlink($filename);
//                            Yii::$app->session->setFlash('getSuccess',' <span class="fa fa-check-square-o">Attendance Uploaded Successfully</span>');
//                            return $this->redirect(['/attendance/index']);
//                        }
//
//                        catch (\Exception $e) {
//                           // var_dump( $e->getMessage());die();
//                            Yii::$app->session->setFlash('getError',$e->getMessage());
//                            fclose($file);
//                            unlink($filename);
//                            $transaction->rollBack();
//                            return $this->render('create', ['model' => $model,]);
//                        }
//                    }
//                }else{
//
//                    Yii::$app->session->setFlash('danger', 'No file attached');
//                    return $this->redirect(['/shule/index']);
//                }
//
//            }
//        } else {
//            $model->loadDefaultValues();
//        }
//        return $this->render('create', [
//            'model' => $model,
//        ]);
//    }


//========== WITH HOLIDAYS==========
//    public function actionCreate()
//    {
//        // Get current month and year
//        $currentMonth = date('m');
//        $currentYear = date('Y');
//
//        // Get all staff members
//        $staffMembers = Staff::find()->all();
//
//        // Begin transaction
//        $transaction = Yii::$app->db->beginTransaction();
//
//        try {
//            // Iterate over each staff member
//            foreach ($staffMembers as $staff) {
//                $staffId = $staff->id;
//
//                // Get the first day of the current month
//                $firstDayOfMonth = date('Y-m-01');
//
//                // Get the last day of the current month
//                $lastDayOfMonth = date('Y-m-t');
//
//                // Iterate over each day of the current month
//                $currentDate = $firstDayOfMonth;
//                while ($currentDate <= $lastDayOfMonth) {
//                    // Check if the current day is a working day (e.g., Monday to Friday)
//                    $dayOfWeek = date('N', strtotime($currentDate));
//                    if ($dayOfWeek >= 1 && $dayOfWeek <= 5) { // Assuming Monday to Friday are working days
//                        // Create a new Attendance record
//                        $model = new Attendance();
//                        $model->staff_id = $staffId;
//                        $model->date = $currentDate;
//                        $model->signin_at = $currentDate . ' 08:00:00'; // Assuming signin time is 08:00 am
//                        $model->singout_at = $currentDate . ' 16:00:00'; // Assuming signout time is 04:00 pm
//                        $model->created_by = Yii::$app->user->id;
//
//                        // Calculate hours_per_day
//                        $dateTime1 = new \DateTime($model->signin_at);
//                        $dateTime2 = new \DateTime($model->singout_at);
//                        $interval = $dateTime1->diff($dateTime2);
//                        $model->hours_per_day = $interval->h + ($interval->days * 24);
//
//                        // Calculate night_hours
//                        $model->night_hours = $this->calculateNightHours($model->singout_at);
//
//                        // Calculate normal_ot_hours
//                        $model->normal_ot_hours = $this->calculateNormalOvertimeHours($model->signin_at, $model->singout_at);
//
//                        // Save the attendance record
//                        $model->save(false);
//                    }
//
//                    // Move to the next day
//                    $currentDate = date('Y-m-d', strtotime($currentDate . ' +1 day'));
//                }
//            }
//
//            // Commit transaction
//            $transaction->commit();
//
//            // Set success flash message
//            Yii::$app->session->setFlash('getSuccess', '<span class="fa fa-check-square-o">Attendance Generated Successfully</span>');
//
//            // Redirect to index page
//            return $this->redirect(['/attendance/index']);
//        } catch (\Exception $e) {
//            // Roll back transaction
//            $transaction->rollBack();
//
//            // Set error flash message
//            Yii::$app->session->setFlash('getError', $e->getMessage());
//
//            // Render create view with model
//            return $this->render('create', ['model' => new Attendance()]);
//        }
//    }

    public function actionCreate()
    {
        // Get current year
        $year = date('Y');
       // Current Month
        $month = date('m');


        // Define public holidays
        $holidays = [
            // New Year's Day
            date("Y-m-d", strtotime("$year-01-01")),

            // Zanzibar Revolution Day
            date("Y-m-d", strtotime("$year-01-12")),

            // Good Friday (Easter)
            date("Y-m-d", strtotime("$year-04-15")),

            // Easter Monday
            date("Y-m-d", strtotime("$year-04-18")),

            // Union Day
            date("Y-m-d", strtotime("$year-04-26")),

            // International Workers' Day
            date("Y-m-d", strtotime("$year-05-01")),

            // Eid al-Fitr (dependent on Islamic calendar, varies yearly)
            date("Y-m-d", strtotime("$year-05-15")), // Example date, varies each year

            // Saba Saba (Industry Day)
            date("Y-m-d", strtotime("$year-07-07")),

            // Nane Nane (Farmers' Day)
            date("Y-m-d", strtotime("$year-08-08")),

            // Eid al-Adha (dependent on Islamic calendar, varies yearly)
            date("Y-m-d", strtotime("$year-07-20")), // Example date, varies each year

            // Nyerere Day
            date("Y-m-d", strtotime("$year-10-14")),

            // Independence Day
            date("Y-m-d", strtotime("$year-12-09")),

            // Christmas Day
            date("Y-m-d", strtotime("$year-12-25")),

            // Boxing Day
            date("Y-m-d", strtotime("$year-12-26"))
        ];


        $AttendanceExist = Attendance::find()
            ->where(['MONTH(created_at)' => $month, 'YEAR(created_at)' => $year])
            ->exists();

        if ($AttendanceExist){
            // Set success flash message
            Yii::$app->session->setFlash('getError', '<span class="fa fa-close"> The Attendance for this Month already exist</span>');
            // Redirect to index page
            return $this->redirect(['/attendance/index']);
        }
        else{
            // Get all staff members
            $staffMembers = Staff::find()->all();

            // Begin transaction
            $transaction = Yii::$app->db->beginTransaction();
            try {
                // Iterate over each staff member
                foreach ($staffMembers as $staff) {
                    $staffId = $staff->id;

                    // Get the first day of the current month
                    $firstDayOfMonth = date('Y-m-01');

                    // Get the last day of the current month
                    $lastDayOfMonth = date('Y-m-t');

                    // Iterate over each day of the current month
                    $currentDate = $firstDayOfMonth;
                    while ($currentDate <= $lastDayOfMonth) {
                        // Check if the current day is a working day (e.g., Monday to Friday)
                        $dayOfWeek = date('N', strtotime($currentDate));
                        if ($dayOfWeek >= 1 && $dayOfWeek <= 5) { // Assuming Monday to Friday are working days
                            // Check if the current date is not a public holiday
                            if (!in_array($currentDate, $holidays)) {
                                // Create a new Attendance record
                                $model = new Attendance();
                                $model->staff_id = $staffId;
                                $model->date = $currentDate;
                                $model->signin_at = $currentDate . ' 08:00:00'; // Assuming signin time is 08:00 am
                                $model->singout_at = $currentDate . ' 16:00:00'; // Assuming signout time is 04:00 pm
                                $model->created_by = Yii::$app->user->id;

                                // Calculate hours_per_day
                                $dateTime1 = new \DateTime($model->signin_at);
                                $dateTime2 = new \DateTime($model->singout_at);
                                $interval = $dateTime1->diff($dateTime2);
                                $model->hours_per_day = $interval->h + ($interval->days * 24);

                                // Calculate night_hours
                                $model->night_hours = $this->calculateNightHours($model->singout_at);

                                // Calculate normal_ot_hours
                                $model->normal_ot_hours = $this->calculateNormalOvertimeHours($model->signin_at, $model->singout_at);

                                // Save the attendance record
                                $model->save(false);
                            }
                        }

                        // Move to the next day
                        $currentDate = date('Y-m-d', strtotime($currentDate . ' +1 day'));
                    }
                }

                // Commit transaction
                $transaction->commit();

                // Set success flash message
                Yii::$app->session->setFlash('getSuccess', '<span class="fa fa-check-square-o">Attendance Generated Successfully</span>');

                // Redirect to index page
                return $this->redirect(['/attendance/index']);
            } catch (\Exception $e) {
                // Roll back transaction
                $transaction->rollBack();

                // Set error flash message
                Yii::$app->session->setFlash('getError', $e->getMessage());

                // Render create view with model
                return $this->render('create', ['model' => new Attendance()]);
            }
        }

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

    public function actionAdd()
    {
        $model = new Attendance();
        if ($model->load(Yii::$app->request->post())) {
            //var_dump($model);die();
            $userID=UserAccount::findOne(['id' =>Yii::$app->user->identity->getId()])->user_id;
            $model->created_by=$userID;
            $signinDateTime = DateTime::createFromFormat('Y-m-d h:i A', $model->date . ' ' . $model->signin_at);
            $signoutDateTime = DateTime::createFromFormat('Y-m-d h:i A', $model->date . ' ' .$model->singout_at);
            $model->signin_at = $signinDateTime->format('Y-m-d H:i:s'); // Example: 2024-05-01 08:30:00
            $model->singout_at = $signoutDateTime->format('Y-m-d H:i:s'); // Example: 2024-05-01 17:30:00
            $dateTime1 = new \DateTime($model->signin_at);
            $dateTime2 = new \DateTime($model->singout_at);
            $interval = $dateTime1->diff($dateTime2);
            $model->hours_per_day = $interval->h + ($interval->days * 24);
            // Calculate night_hours
            $model->night_hours = $this->calculateNightHours($model->singout_at);
            // Calculate normal_ot_hours
            $model->normal_ot_hours = $this->calculateNormalOvertimeHours($model->signin_at, $model->singout_at);
            $model->save(false);
            Yii::$app->session->setFlash('getSuccess', '<span class="fa fa-check-square-o">Attendance Generated Successfully</span>');
            return $this->redirect(['view', 'id' => $model->id]);

        }

        return $this->render('create', [
            'model' => $model,
        ]);
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

        if ($model->load(Yii::$app->request->post()) ) {

            $dateTime1 = new \DateTime($model->signin_at);
            $dateTime2 = new \DateTime($model->singout_at);
            $interval = $dateTime1->diff($dateTime2);
            $model->hours_per_day = $interval->h + ($interval->days * 24);

            // Calculate night_hours
            $model->night_hours = $this->calculateNightHours($model->singout_at);

            // Calculate normal_ot_hours
            $model->normal_ot_hours = $this->calculateNormalOvertimeHours($model->signin_at, $model->singout_at);
            if ($model->save(false)){
                Yii::$app->session->setFlash('getSuccess', '<span class="fa fa-check-square-o">Attendance updated Successfully</span>');
                return $this->redirect(['view', 'id' => $model->id]);
            }
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
