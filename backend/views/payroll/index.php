<?php

use common\models\Payroll;
use common\models\Staff;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\PayrollSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Payroll Records';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php
if(Yii::$app->session->hasFlash('getError')):?>
    <div class="alert alert-sm alert-danger zoomIn" align="center">
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
<div class="payroll-index">

    <?php


    $currentYear = date('Y');
    $currentMonth = date('m');
    // Check if a payroll entry exists for the current month and year
    $payrollExists = Payroll::find()
        ->where(['YEAR(created_at)' => $currentYear])
        ->andWhere(['MONTH(created_at)' => $currentMonth])
        ->exists();
    ?>

<!--    --><?php //if ($payrollExists):?>
    <p align="right">
        <?= Html::a('<span class="fa fa-book"> Run Payroll</span>', ['payroll-transactions/create'],[
            'class' => 'btn btn-success',
            'data' => [
                'confirm' => 'Are you sure you want to generate payroll for this month ?',
                'method' => 'post',
            ],
        ]) ?>

    </p>
<!--    --><?php //endif;?>


    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            ['attribute'=>'created_at','value'=>function($model){
                return  date('M-Y', strtotime($model->created_at));
            },'label'=>'Salary Month'],
            'created_at',

            // 'updated_at',
            ['attribute'=>'created_by','value'=>function($model){
                $user= Staff::findOne(['id'=>$model->created_by]);
                return  $user->getFullName();
            }],


            ['class' => 'yii\grid\ActionColumn',
                'template'=>'{view}',
                'contentOptions' => ['style' => 'width:100px;'],
                'header'=>"ACTION",
                'headerOptions' => [
                    'style' => 'color:red'
                ],
                'buttons' => [
                    //view button
                    'view' => function ($url, $model) {
                        return Html::a('<span class="fa fa-open-eye"></span>View More', $url, [
                            'title' => Yii::t('app', 'View'),
                            'class'=>'btn btn-primary btn-xs',]);
                    },
                    'urlCreator' => function ($action, $model, $key, $index) {
                        if ($action === 'more') {
                            $url = 'index.php?r=transactions/index&payroll_id='.$model->payroll_id;
                            return $url;
                        }

                    } ,
                ],

            ],
        ],
    ]); ?>


</div>
