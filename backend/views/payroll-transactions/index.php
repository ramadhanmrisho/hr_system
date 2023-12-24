<?php

use common\models\SalaryAdjustments;
use kartik\export\ExportMenu;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\PayrollTransactionsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Payroll Information';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php
if(Yii::$app->session->hasFlash('getSuccess')):?>
    <div class="alert alert-sm alert-success zoomIn" align="center">
        <?= Yii::$app->session->getFlash('getSuccess');?>
    </div>
<?php endif;?>

<?php
if(Yii::$app->session->hasFlash('getError')):?>
    <div class="alert alert-sm alert-warning zoomIn" align="center">
        <?= Yii::$app->session->getFlash('getError');?>
    </div>
<?php endif;?>

<?php
\yiister\adminlte\widgets\Box::begin(
    [
        "type" => \yiister\adminlte\widgets\Box::TYPE_PRIMARY,
    ]
)
?>
<div class="payroll-transactions-index">

    <?php


    $columns=[
        ['class' => 'yii\grid\SerialColumn'],
        ['class' => 'yii\grid\ActionColumn','template'=>'{view}'],
        ['attribute'=>'created_at','value'=>function($model){
            return  date('M-Y', strtotime($model->created_at));
        },'label'=>'Salary Month'],

        ['attribute'=>'staff_id','value'=>function($model){
            return  \common\models\Staff::findOne(['id'=>$model->staff_id])->employee_number;
        },'label'=>'Emp No'],

        ['attribute'=>'staff_id','value'=>function($model){
            $staff=\common\models\Staff::findOne(['id'=>$model->staff_id]);
            return  $staff->fname.' '.$staff->lname;
        },'label'=>'Employee Name'],

        ['attribute'=>'departiment_id','value'=>function($model){
            return  $department=\common\models\Department::findOne(['id'=>$model->departiment_id])->name;
        },'label'=>'Department Name'],

        ['attribute'=>'designation_id','value'=>function($model){
            return  \common\models\Designation::findOne(['id'=>$model->designation_id])->name;
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
        [
            'attribute' => 'nssf',
            'value' => function ($model) {
                return Yii::$app->formatter->asDecimal($model->nssf);
            },
        ],
        [
            'attribute' => 'taxable_income',
            'value' => function ($model) {
                return Yii::$app->formatter->asDecimal($model->taxable_income);
            },
        ],
        [
            'attribute' => 'paye',
            'value' => function ($model) {
                return Yii::$app->formatter->asDecimal($model->paye);
            },
        ],
        [
            'attribute' => 'loan',
            'value' => function ($model) {
                return Yii::$app->formatter->asDecimal($model->loan);
            },
        ],
        [
            'attribute' => 'salary_advance',
            'value' => function ($model) {
                return is_numeric($model->salary_advance)?Yii::$app->formatter->asDecimal($model->salary_advance):0;
            },
        ],
        [
            'attribute' => 'union_contibution',
            'value' => function ($model) {
                return is_numeric($model->union_contibution)?Yii::$app->formatter->asDecimal($model->union_contibution):0;
            },
        ],
        [
            'attribute' => 'net_salary',
            'value' => function ($model) {
                return Yii::$app->formatter->asDecimal($model->net_salary);
            },
        ],
        [
            'attribute' => 'wcf',
            'value' => function ($model) {
                return Yii::$app->formatter->asDecimal($model->wcf);
            },
        ],
        [
            'attribute' => 'sdl',
            'value' => function ($model) {
                return Yii::$app->formatter->asDecimal($model->sdl);
            },
        ],
        [
            'attribute' => 'nhif',
            'value' => function ($model) {
                return Yii::$app->formatter->asDecimal($model->nhif);
            },
        ],
        [
            'attribute' => 'total',
            'value' => function ($model) {
                return Yii::$app->formatter->asDecimal($model->total);
            },
        ],

        'created_at',
       // 'updated_at',
        ['attribute'=>'created_by','value'=>function($model){
                $user=\common\models\Staff::findOne(['id'=>$model->created_by]);
                return  $user->getFullName();
            }],


    ];

    $exportConfig = [
        ExportMenu::FORMAT_CSV => [
            'label' => 'CSV',
            'filename' => function() {
                return 'exported_data_' . date('YmdHis'); // Rename CSV file
            },
        ],
        ExportMenu::FORMAT_EXCEL => [
            'label' => 'Excel',
            'filename' => function() {
                return 'exported_data_' . date('YmdHis'); // Rename Excel file
            },
        ],
        ExportMenu::FORMAT_PDF => [
            'label' => 'PDF',
            'filename' => function() {
                return 'exported_data_' . date('YmdHis'); // Rename PDF file
            },
        ],
    ];

    echo '<p align="right">'. ExportMenu::widget([
        'dataProvider' => $dataProvider,
        'columns' => $columns,

        'clearBuffers' => false, //optional
        'dropdownOptions' => [
            'label' => 'Export',
            'class' => 'btn btn-success', // Styling for the dropdown button
        ],
            'export' => $exportConfig,

    ]).'<p>';


    ?>


    <?= \fedemotta\datatables\DataTables::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
          'id'=>'gridTable',
        'clientOptions' => [
            'scrollX' => true,
            //'scrollY' => '400px', // You can adjust the height as needed
            // Add other DataTables options here if required

        ],
        'columns' => $columns,
    ]); ?>


</div>



<?php
//// Add this script in a script block in your view file
//$this->registerJs("
//    $(document).ready(function() {
//        $('#gridTable tbody tr').click(function() {
//            var href = $(this).find('a').attr('href');
//            if (href) {
//                window.location = href;
//            }
//        });
//
//        // Adding hover effect for rows
//        $('#your-gridview-id tbody tr').hover(
//            function() {
//                $(this).css('cursor', 'pointer !important'); // Change cursor to pointer on hover
//                $(this).addClass('hovered-row'); // Add a class for visual feedback
//            },
//            function() {
//                $(this).css('cursor', 'auto !important'); // Change cursor back to default
//                $(this).removeClass('hovered-row'); // Remove the added class
//            }
//        );
//    });
//");
//?>



