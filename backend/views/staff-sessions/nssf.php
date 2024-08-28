<?php

use common\models\SalaryAdjustments;
use fedemotta\datatables\DataTables;
use kartik\export\ExportMenu;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\PayrollTransactionsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$monthName = DateTime::createFromFormat('!m', $month)->format('F');
$this->title = 'NSSF PAYMENT REPORT FOR THE MONTH OF  '.strtoupper($monthName).' '.$year;
$this->params['breadcrumbs'][] = $this->title;
?>




<?php
\yiister\adminlte\widgets\Box::begin(
    [
        "type" => \yiister\adminlte\widgets\Box::TYPE_PRIMARY,
    ]
)
?>
<p align="right">
    <?= Html::a('New Filter', ['payroll'], ['class' => 'btn btn-success rounded-pill']) ?>
</p>

<div class="payroll-transactions-index">

    <?php


    $totalEarnings = ArrayHelper::getValue($dataProvider->models, function ($model) {
        return array_sum(ArrayHelper::getColumn($model, 'total_earnings'));
    });

    $totalNssf = ArrayHelper::getValue($dataProvider->models, function ($model) {
        return array_sum(ArrayHelper::getColumn($model, 'nssf'));
    });

    $totalAll = ArrayHelper::getValue($dataProvider->models, function ($model) {
        return array_sum(ArrayHelper::getColumn($model, 'total'));
    });


    $columns = [
        ['class' => 'yii\grid\SerialColumn'],

        ['attribute'=>'staff_id','value'=>function($model){
            return  \common\models\Staff::findOne(['id'=>$model->staff_id])->employee_number;
        },'label'=>'Emp No'],

        ['attribute'=>'staff_id','value'=>function($model){
            $staff=\common\models\Staff::findOne(['id'=>$model->staff_id]);
            return  $staff->fname.' '.$staff->lname;
        },'label'=>'Employee Name'],


        ['attribute'=>'staff_id','value'=>function($model){
            $staff=\common\models\Staff::findOne(['id'=>$model->staff_id]);
            return  $staff->nssf;
        },'label'=>'Membership  Number'],

        [
            'attribute' => 'total_earnings',
            'value' => function ($model) {
                return Yii::$app->formatter->asDecimal($model->total_earnings);
            },
            'footer' => Yii::$app->formatter->asDecimal($totalEarnings),
        ],
        [
            'attribute' => 'nssf',
            'value' => function ($model) {
                return Yii::$app->formatter->asDecimal($model->nssf * 2) ;
            },
            'footer' => Yii::$app->formatter->asDecimal($totalNssf * 2),'label'=>'Contribution (20%)'
        ],



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



    echo ExportMenu::widget([
        'dataProvider' => $dataProvider,
        'columns' => $columns,

        'clearBuffers' => false, //optional
        'export' => [
            ExportMenu::FORMAT_PDF,
            ExportMenu::FORMAT_CSV,
            ExportMenu::FORMAT_EXCEL,
        ],
    ]);
    ?>


    <?= DataTables::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,'clientOptions' => [
            "lengthMenu"=> [[20,-1], [20,Yii::t('app',"All")]],
            "info"=>false,
            "responsive"=>true,
            "dom"=> 'lfTrtip',
        ],
        'columns' => $columns,
        'showFooter'=>true
    ]); ?>


</div>



