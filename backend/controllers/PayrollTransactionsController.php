<?php

namespace backend\controllers;

use common\models\Absentees;
use common\models\Attendance;
use common\models\DeductionsPercentage;
use common\models\OvertimeAmount;
use common\models\Payroll;
use common\models\Roster;
use common\models\SalaryAdjustments;
use common\models\SalaryAdvance;
use common\models\Staff;
use common\models\StaffAllowance;
use common\models\StaffNightHours;
use common\models\UnionContribution;
use common\models\UserAccount;
use Yii;
use common\models\PayrollTransactions;
use common\models\search\PayrollTransactionsSearch;
use yii\db\Expression;
use yii\db\Query;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PayrollTransactionsController implements the CRUD actions for PayrollTransactions model.
 */
class PayrollTransactionsController extends Controller
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
     * Lists all PayrollTransactions models.
     * @return mixed
     */
    public function actionIndex($payroll_id)
    {
        $searchModel = new PayrollTransactionsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andFilterWhere(['payroll_id' => $payroll_id]);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PayrollTransactions model.
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
     * Creates a new PayrollTransactions model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     * Genarating Payroll
     */
    public function actionCreate()
    {


//
//
//var_dump($this->unionContribution($staff->id));
//echo $staff->id.'<br>';


        $currentYear = date('Y');
        $currentMonth = date('m');
        // Check if a payroll entry exists for the current month and year
        $attendanceExists = Attendance::find()
            ->where(['YEAR(created_at)' => $currentYear])
            ->andWhere(['MONTH(created_at)' => $currentMonth])
            ->exists();


        if ($attendanceExists){
          Yii::$app->session->setFlash('getError',' <span class="fa fa-check-square-o">Please Upload Attendance for this Month </span>');
          return $this->redirect(['index']);
      }
      else{
          $allStaff=Staff::find()->where(['status'=>1])->orderBy(['fname'=>SORT_ASC])->all();
          foreach ($allStaff as $staff){
              $model = new PayrollTransactions();
              $model->payroll_id=$this->payrollID();
              $model->staff_id=$staff->id;
              $model->departiment_id=$staff->department_id;
              $model->designation_id=$staff->designation_id;
              $model->basic_salary=$staff->basic_salary;
              $model->salary_adjustiment_id=!is_null($this->salaryAdjustment($staff->id))?$this->salaryAdjustment($staff->id):0;
              $model->allowances=$this->staffAllowances($staff->id);
              $model->night_hours=$this->calculateNightHours($staff->id);
              $model->night_allowance=$this->calculateNightHours($staff->id)*OvertimeAmount::find()->where(['status'=>1])->one()->normal_ot_amount;
              $has_overtime=Staff::findOne(['id'=>$staff->id])->has_ot;
              $model->normal_ot_hours=$has_overtime=="Yes"?$this->calculateOvertimeByStaffInMonth($staff->id):0;
              $model->special_ot_hours=$this->calculateWorkingHoursWithHolidays($staff->id);
              $model->normal_ot_amount=(int)$model->normal_ot_hours*OvertimeAmount::find()->where(['status'=>1])->one()->normal_ot_amount;
              $model->special_ot_amount= (int) $model->special_ot_hours*OvertimeAmount::find()->where(['status'=>1])->one()->special_ot_amount;
              $model->absent_days=$this->absentDays($staff->id);
              $model->absent_amount= (int)$model->absent_days*$this->calculateDailySalary($staff->id);
              $adjustmentAmount=SalaryAdjustments::find()->where(['id'=>$model->salary_adjustiment_id])->exists()?SalaryAdjustments::findOne(['id'=>$model->salary_adjustiment_id])->amount:0;
              $model->total_earnings=($model->basic_salary+$adjustmentAmount+ $model->allowances+$model->night_allowance+$model->normal_ot_amount+$model->special_ot_amount)-$model->absent_amount;
              $model->nssf=(DeductionsPercentage::findOne(['status'=>'active'])->NSSF/100)*$model->total_earnings;
              $model->taxable_income=$model->total_earnings-$model->nssf;
              $model->paye=$this->calculatePAYE($model->taxable_income);
              $model->loan=0;
              $model->salary_advance=$this->salaryAdvance($staff->id);
              $model->union_contibution=$this->unionContribution($staff->id);
              $model->wcf=(DeductionsPercentage::findOne(['status'=>'active'])->WCF)/100 * $model->total_earnings;
              $model->sdl=(DeductionsPercentage::findOne(['status'=>'active'])->SDL/100)*$model->total_earnings;
              $has_NHIF=Staff::findOne(['id'=>$staff->id])->nhif;
              $model->nhif=$has_NHIF=="Yes"?(DeductionsPercentage::findOne(['status'=>'active'])->NHIF/100)*$model->total_earnings:0;
              $model->net_salary=$model->total_earnings-($model->nssf+$model->paye+$model->loan+$model->salary_advance+$model->union_contibution+$model->nhif);
              $model->total=$model->total_earnings+$model->nssf+$model->nhif+ $model->wcf+$model->sdl;
              $userID=UserAccount::findOne(['id' =>Yii::$app->user->identity->getId()])->user_id;
              $model->created_by=$userID;
              $model->save(false);
////          //print $staff->fname.' - '.$this->calculatePAYE($staff->basic_salary).'<br>';
//          var_dump($model->total);
//          echo $staff->id.'<br>';
          }
          $payroll_record=new Payroll();
          $payroll_record->payroll_transaction_id=$model->payroll_id;
          $payroll_record->created_by=$userID;
          $payroll_record->save();
          Yii::$app->session->setFlash('getSuccess',' <span class="fa fa-check-square-o">Payroll Generated  Successfully</span>');
          return $this->redirect(['index','payroll_id'=>$model->payroll_id]);
      }

    }




    //calculate salary adjustment
    public static function salaryAdjustment($staff_id){
        $currentMonth = date('m');
        $currentYear = date('Y');
        $salaryExists=SalaryAdjustments::find()
            ->where(['=', 'staff_id', $staff_id])
            ->andWhere(['MONTH(created_at)' => $currentMonth])
            ->andWhere(['YEAR(created_at)' => $currentYear])
            ->exists();

        if ($salaryExists){
            $salaryAdjustmentID = SalaryAdjustments::find()
                ->where(['=', 'staff_id', $staff_id])
                ->andWhere(['MONTH(created_at)' => $currentMonth])
                ->andWhere(['YEAR(created_at)' => $currentYear])
                ->one()->id;
        }
        return isset($salaryAdjustmentID)?$salaryAdjustmentID:null;
    }



    public static function staffAllowances($staff_id){
        $allowanceAmount = StaffAllowance::find()
            ->select(['SUM(amount) AS total_amount'])
            ->innerJoinWith('allowance') // Assuming `allowance` is the relation name in StaffAllowance model
            ->where(['staff_id' => $staff_id])
            ->scalar();
        return isset($allowanceAmount)?$allowanceAmount:0;
    }


    public static function payrollID(){
        $counter=Payroll::find()->count();
        return $counter+1;
    }

    public static function calculateNightHours($staff_id)
    {
        $year = date('Y');
        $month = date('m');

        // Calculate total night hours worked by the staff for the given month and year
        $totalNightHours = Attendance::find()
            ->select(['SUM(night_hours) AS totalNightHours'])
            ->where(['staff_id' => $staff_id])
            ->andWhere(new Expression('YEAR(singout_at) = :year', [':year' => $year]))
            ->andWhere(new Expression('MONTH(singout_at) = :month', [':month' => $month]))
            ->scalar();

        return $totalNightHours ? round($totalNightHours, 2) : 0;
    }

//    public static function calculateNightHours($staff_id)
//    {
//        $year = date('Y');
//        $month = date('m');
//
//        $totalNightHours = StaffNightHours::find()
//            ->select(['SUM(days) AS total_days'])
//            ->where(['staff_id' => $staff_id])
//            ->andWhere(['MONTH(created_at)' => $month, 'YEAR(created_at)' => $year])
//            ->scalar();
//
//        return $totalNightHours ? round($totalNightHours, 2) : 0;
//    }



//    public static function calculateOvertimeByStaffInMonth($staffId)
//    {
//        $year = date('Y');
//        $month = date('m');
//
//        $overtimeQuery = Attendance::find()
//            ->select(['staff_id', 'SUM(normal_ot_hours) AS overtime'])
//            ->where(['staff_id' => $staffId])
//            ->andWhere(['MONTH(signin_at)' => $month, 'YEAR(signin_at)' => $year])
//            ->groupBy('staff_id')
//            ->asArray()
//            ->all();
//
//        return $overtimeQuery;
//    }

    public static function calculateOvertimeByStaffInMonth($staffId)
    {
        $year = date('Y');
        $month = date('m');

        $overtimeQuery = Attendance::find()
            ->select(['staff_id', 'SUM(normal_ot_hours) AS overtime'])
            ->where(['staff_id' => $staffId])
            ->andWhere(['MONTH(signin_at)' => $month, 'YEAR(signin_at)' => $year])
            ->groupBy('staff_id')
            ->asArray()
            ->all();

        return $overtimeQuery;
    }

    public static function absentDays($staff_id){
        $year = date('Y');
        $month = date('m');
        $absentdayz = Absentees::find()
            ->select(['SUM(days) AS total_days'])
            ->where(['staff_id' => $staff_id])
            ->andWhere(['MONTH(created_at)' => $month, 'YEAR(created_at)' => $year])
            ->scalar();
        return isset($absentdayz)?$absentdayz:0;
    }


    public static function calculateWorkingHoursWithHolidays($staff_id)
    {

        $year=date('Y');
        $holidays = array(
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
        );

       // var_dump($holidays);die();
        $years = date('Y');
        $month = date('m');


        $workingHoursQuery = Attendance::find()
            ->select(['SUM(TIMESTAMPDIFF(HOUR, signin_at, singout_at)) AS total_hours'])
            ->where(['MONTH(signin_at)' => $month, 'YEAR(signin_at)' => $years, 'staff_id' => $staff_id]);

        // Filter out holidays
        if (!empty($holidays)) {
            $workingHoursQuery->andWhere(['IN', 'DATE(signin_at)', $holidays]);
        }

        $totalHours = $workingHoursQuery->scalar();

        return $totalHours ?: 0;
    }


    public static function calculatePAYE($totalEarnings) {
        if ($totalEarnings <= 270000) {
            return 0;
        } elseif ($totalEarnings <= 520000) {
            return ($totalEarnings - 270000) * 0.08;
        } elseif ($totalEarnings <= 760000) {
            return 20000 + (($totalEarnings - 520000) * 0.2);
        } elseif ($totalEarnings <= 1000000) {
            return 68000 + (($totalEarnings - 760000) * 0.25);
        } else {
            return 128000 + (($totalEarnings - 1000000) * 0.3);
        }
    }

    public static function calculateDailySalary($staff_id) {

        $basicPay=Staff::findOne(['id'=>$staff_id])->basic_salary;
        $numberOfWorkingDays=Roster::find()->where(['status'=>1])->one()->working_days;
        // Check if basic pay and number of working days are numeric and greater than zero
        if (!is_numeric($basicPay) || !is_numeric($numberOfWorkingDays) || $basicPay <= 0 || $numberOfWorkingDays <= 0) {
            return "Invalid input. Please provide valid numeric values for basic pay and number of working days.";
        }
        // Calculate daily salary
        $days=4.333 * $numberOfWorkingDays;
        $dailySalary = $basicPay /$days ;
        return $dailySalary;
    }



    public static function salaryAdvance($staff_id){
        $year = date('Y');
        $month = date('m');
        $has_salary=SalaryAdvance::find()->where(['staff_id'=>$staff_id,'status'=>'not paid'])
            ->andWhere(['MONTH(created_at)' => $month, 'YEAR(created_at)' => $year])->exists();

        if ($has_salary){
            $staff_advance=SalaryAdvance::find()->where(['staff_id'=>$staff_id,'status'=>'not paid'])->andWhere(['MONTH(created_at)' => $month, 'YEAR(created_at)' => $year])->one();
            $salary=$staff_advance->amount;
            $staff_advance->status="paid";
            $staff_advance->save(false);
        }
        else $salary=null;
        return is_null($salary)?null:$salary;
    }


    public static function unionContribution($staff_id){
        $has_union=UnionContribution::find()->where(['staff_id'=>$staff_id,'status'=>'active'])->exists();

        if ($has_union){
            $union_amount=UnionContribution::find()->where(['staff_id'=>$staff_id,'status'=>'active'])->one()->amount;
        }
        else $union_amount=null;
        return is_null($union_amount)?null:$union_amount;
    }

    public static function getPublicHolidaysInTanzania() {
        $year=date('Y');
        $holidays = array(
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
        );

        return $holidays;
    }


//     public static function calculateWorkingDays()
//{
//    $workingDays = [];
//
//    // Fetch all distinct staff IDs
//    $staffIds = Attendance::find()->where(['status'=>1])
//        ->select('staff_id')
//        ->distinct()
//        ->column();
//
//    // Loop through each staff ID to calculate working days
//    foreach ($staffIds as $staffId) {
//        // Calculate working days for each staff
//        $workingDays[$staffId] = Attendance::find()
//            ->where(['staff_id' => $staffId])
//            ->andWhere(['>=', 'hours_per_day', 'working_hours'])
//            ->count(); // Count complete working days
//    }
//
//    return $workingDays;
//}


    public static function calculateWorkingDaysPerStaff($staffId)
    {
        // Calculate working days for the specified staff ID
        $noOfWorkinghours=Roster::find()->where(['status'=>1])->one()->working_hours;
        $workingDays = Attendance::find()
            ->where(['staff_id' => $staffId])
            ->andWhere(['>=', 'hours_per_day', $noOfWorkinghours])
            ->count(); // Count complete working days
        return $workingDays;
    }





    /**
     * Updates an existing PayrollTransactions model.
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
     * Deletes an existing PayrollTransactions model.
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
     * Finds the PayrollTransactions model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PayrollTransactions the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PayrollTransactions::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
