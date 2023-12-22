<?php

use common\models\Department;
use common\models\Designation;
use common\models\SalaryAdjustments;
use common\models\Staff;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\PayrollTransactions */

$staff= Staff::findOne(['id'=>$model->staff_id]);
$this->title = 'SALARY DETAILS FOR '.$staff->fname.' '.$staff->lname;
$this->params['breadcrumbs'][] = ['label' => 'Staff Payroll', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<?php
\yiister\adminlte\widgets\Box::begin(
    [
        "type" => \yiister\adminlte\widgets\Box::TYPE_PRIMARY,
    ]
)
?>
<div class="payroll-transactions-view">

    <div class="row">
        <div class="col-md-5">
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    ['attribute'=>'created_at','value'=>function($model){
                        return  date('M-Y', strtotime($model->created_at));
                    },'label'=>'Salary Month'],

                    ['attribute'=>'staff_id','value'=>function($model){
                        return  Staff::findOne(['id'=>$model->staff_id])->employee_number;
                    },'label'=>'Emp No'],

                    ['attribute'=>'staff_id','value'=>function($model){
                        $staff= Staff::findOne(['id'=>$model->staff_id]);
                        return  $staff->fname.' '.$staff->lname;
                    },'label'=>'Employee Name'],

                    ['attribute'=>'departiment_id','value'=>function($model){
                        return  $department= Department::findOne(['id'=>$model->departiment_id])->name;
                    },'label'=>'Department Name'],

                    ['attribute'=>'designation_id','value'=>function($model){
                        return  Designation::findOne(['id'=>$model->designation_id])->name;
                    }],
                    ['attribute'=>'basic_salary','value'=>function($model){
                        return  Yii::$app->formatter->asDecimal($model->basic_salary);
                    }],
                    ['attribute'=>'salary_adjustiment_id','value'=>function($model){

                        $amount= !empty($model->salary_adjustiment_id)? SalaryAdjustments::find()->where(['id'=>$model->salary_adjustiment_id])->one()->amount:0;
                        return  Yii::$app->formatter->asDecimal($amount);
                    }],

                    [
                        'attribute' => 'allowances',
                        'value' => function ($model) {
                            return Yii::$app->formatter->asDecimal($model->allowances);
                        },
                    ],
                    [
                        'attribute' => 'night_hours',
                        'value' => function ($model) {
                            return $model->night_hours;
                        },
                    ],
                    [
                        'attribute' => 'night_allowance',
                        'value' => function ($model) {
                            return Yii::$app->formatter->asDecimal($model->night_allowance);
                        },
                    ],
                    [
                        'attribute' => 'normal_ot_hours',
                        'value' => function ($model) {
                            return $model->normal_ot_hours;
                        },
                    ],
                    [
                        'attribute' => 'special_ot_hours',
                        'value' => function ($model) {
                            return $model->special_ot_hours;
                        },
                    ],
                    [
                        'attribute' => 'normal_ot_amount',
                        'value' => function ($model) {
                            return Yii::$app->formatter->asDecimal($model->normal_ot_amount);
                        },
                    ],

                    [
                        'attribute' => 'special_ot_amount',
                        'value' => function ($model) {
                            return Yii::$app->formatter->asDecimal($model->special_ot_amount);
                        },
                    ],
                    'absent_days',
                    [
                        'attribute' => 'absent_amount',
                        'value' => function ($model) {
                            return Yii::$app->formatter->asDecimal($model->absent_amount);
                        },
                    ],
                    [
                        'attribute' => 'total_earnings',
                        'value' => function ($model) {
                            return Yii::$app->formatter->asDecimal($model->total_earnings);
                        },
                    ],

                    [
                        'attribute' => 'total',
                        'value' => function ($model) {
                            return Yii::$app->formatter->asDecimal($model->total);
                        },
                    ],
                ],
            ]) ?>
        </div>
        <div class="col-md-7">
            <!DOCTYPE html>
            <!DOCTYPE html>
            <html>
            <head>
                <title>Salary Slip</title>
                <!-- Include CSS for styling -->
                <style>
                    /* Add your CSS styling here */
                    body {
                        font-family: Arial, sans-serif;
                    }
                    .container {
                        max-width: 800px;
                        margin: 0 auto;
                        padding: 20px;
                        border: 1px solid #ccc;
                        border-radius: 5px;
                    }
                    .heading {
                        text-align: center;
                        margin-bottom: 20px;
                    }
                    .details-table {
                        width: 100%;
                        border-collapse: collapse;
                        margin-bottom: 20px;
                    }
                    .details-table th, .details-table td {
                        border: 1px solid black;
                        padding: 8px;
                    }
                    .details-table th {
                        background-color: #f0f0f0;
                    }
                    .signature {
                        text-align: right;
                        margin-top: 20px;
                    }

                    @media print {
                        .printableContent {
                            border: 1px solid black; /* Set your border style */
                            padding: 10px; /* Optional: add some padding for spacing */
                        }
                </style>
            </head>
            <body>

            <?php
            $staff=Staff::findOne(['id'=>$model->staff_id]);
            $department= Department::findOne(['id'=>$model->departiment_id])->name;
            $designation=Designation::findOne(['id'=>$model->designation_id])->name;
            $salary_adjustment_amount= !empty($model->salary_adjustiment_id)? SalaryAdjustments::find()->where(['id'=>$model->salary_adjustiment_id])->one()->amount:0;
            $union=is_null($model->union_contibution)?0:$model->union_contibution;
            $salary_advance=is_null($model->union_contibution)?0:$model->salary_advance;
            $total_deductions=$model->absent_amount+$union+$salary_advance+$model->nssf+$model->paye;
            ?>

            <div class="printableContent container" id="printableDiv">
                <h4 class="heading" align="center"><strong>SALARY SLIP FOR THE MONTH OF<br><?=date('M-Y', strtotime($model->created_at))?> </strong></h4>
                <table class="details-table">
                    <tbody>
                    <tr>
                        <th>Employee NO.:</th>
                        <td><?=$staff->employee_number?></td>
                        <th>Name:</th>
                        <td><?=$staff->fname.' '.$staff->lname?></td>
                        <th>NSSF NO.:</th>
                        <td><?= $staff->nssf_number?></td>
                    </tr>
                    <tr>
                        <th>Department:</th>
                        <td><?=$department?></td>
                        <th>Designation:</th>
                        <td><?= $designation?></td>
                        <th>CURRENCY:</th>
                        <td>TZS</td>
                    </tr>
                    <!-- Add more rows for EARNINGS and DEDUCTIONS -->
                    <tr>
                        <th style="text-align: center;" colspan="3">EARNINGS</th>
                        <td colspan="1"></td>

                        <th style="text-align: center;" colspan="1">DEDUCTIONS</th>
                        <td colspan="1"></td>
                    </tr>
                    <!-- Example row for Earnings -->
                    <tr>
                        <td>Basic Salary:</td>
                        <td colspan="2"><?= Yii::$app->formatter->asDecimal($staff->basic_salary,2)?></td>
                        <td>NSSF contr.:</td>
                        <td colspan="5"><?= Yii::$app->formatter->asDecimal($model->nssf,2)?></td>
                    </tr>
                    <tr>
                        <td>Salary Advance:</td>
                        <td colspan="2"><?= Yii::$app->formatter->asDecimal($salary_advance,2)?></td>

                        <td>PAYE .:</td>
                        <td colspan="2"><?= Yii::$app->formatter->asDecimal($model->paye,2)?></td>

                    </tr>

                    <tr>
                        <td>Allowance:</td>
                        <td colspan="2">-</td>
                        <td>Salary Adjustment:</td>
                        <td colspan="2"><?= Yii::$app->formatter->asDecimal($salary_adjustment_amount,2)?></td>
                    </tr>
                    <tr>
                        <td>Normal OT Amount:</td>
                        <td colspan="2"><?= Yii::$app->formatter->asDecimal($model->normal_ot_amount,2)?></td>
                        <td>Union Contr:</td>
                        <td colspan="2"><?= Yii::$app->formatter->asDecimal($union,2)?></td>
                    </tr>
                    <tr>
                        <td>Special OT Amount:</td>
                        <td colspan="2"><?= Yii::$app->formatter->asDecimal($model->special_ot_amount,2)?></td>
                        <td>Loan:</td>
                        <td colspan="2">-</td>
                    </tr>
                    <tr>
                        <td>Leave Travel Assistance:</td>
                        <td colspan="2">-</td>
                        <td></td>
                        <td colspan="2"></td>
                    </tr>
                    <tr>
                        <th>Total Earnings:</th>
                        <td colspan="2"><?= Yii::$app->formatter->asDecimal($model->total_earnings,2)?></td>
                        <th>Total Deductions:</th>
                        <td colspan="2"><?= Yii::$app->formatter->asDecimal($model->special_ot_amount,2)?></td>

                    </tr>
                    <tr>
                        <th>Net Salary:</th>
                        <td colspan="5"><?= Yii::$app->formatter->asDecimal($model->net_salary,2)?></td>
                    </tr>
                    </tbody>
                </table><br>
                <div class="signature">
                    Employee Signature: ________________________________
                </div>

            </div>
<br>
            <p align="center" style="padding-left: 50px">
               <button class="btn btn-primary col-sm-3 fa fa-print" onclick="printDiv('printableDiv')">Print</button>

            </p>
            </body>
            </html>


        </div>
    </div>


</div>


<script>
    function printDiv() {
        var printContents = document.getElementById('printableDiv').innerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;

        window.print();

        document.body.innerHTML = originalContents;
    }
</script>

