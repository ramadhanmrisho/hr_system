<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\SalaryAdjustmentsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Salary Adjustments';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php
if(Yii::$app->session->hasFlash('getSuccess')):?>
    <div class="alert alert-sm alert-success zoomIn" align="center">
        <?= Yii::$app->session->getFlash('getSuccess');?>
    </div>
<?php endif;?>
<?php
\yiister\adminlte\widgets\Box::begin(
    [
        "type" => \yiister\adminlte\widgets\Box::TYPE_PRIMARY,
    ]
)
?>
<div class="salary-adjustments-index">

    <p align="right">
        <?= Html::a('Add Salary Adjustment', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= \fedemotta\datatables\DataTables::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
          ['attribute'=>'staff_id','value'=>function($model){
              $user=\common\models\Staff::findOne(['id'=>$model->staff_id]);
              return  $user->getFullName();
            }],
            'amount',
            'description',
            'created_at',
            'updated_at',
            ['attribute'=>'status','value'=>function($model){
                return $model->status==1 ?"Active":"Inactive";
            }],
            ['attribute'=>'created_by','value'=>function($model){
                $user=\common\models\Staff::findOne(['id'=>$model->created_by]);
                return  $user->getFullName();
            }],

            ['class' => 'yii\grid\ActionColumn','template'=>'{view}{update}'],
        ],
    ]); ?>


</div>
