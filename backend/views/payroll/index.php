<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\PayrollSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Payroll Records';
$this->params['breadcrumbs'][] = $this->title;
?>

<?php
\yiister\adminlte\widgets\Box::begin(
    [
        "type" => \yiister\adminlte\widgets\Box::TYPE_PRIMARY,
    ]
)
?>
<div class="payroll-index">


    <p align="right">
        <?= Html::a('<span class="fa fa-book"> Run Payroll</span>', ['payroll-transactions/create'],[
            'class' => 'btn btn-success',
            'data' => [
                'confirm' => 'Are you sure you want to generate payroll for this month ?',
                'method' => 'post',
            ],
        ]) ?>

    </p>


    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'payroll_transaction_id',
            'created_at',
            'status',
            'created_by',
            //'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
