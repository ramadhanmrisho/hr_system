<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\OvertimeAmountSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Overtime Amounts';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php
\yiister\adminlte\widgets\Box::begin(
    [
        "type" => \yiister\adminlte\widgets\Box::TYPE_PRIMARY,
    ]
)
?>
<div class="overtime-amount-index">
    <p align="right">
        <?= Html::a('Add Overtime Amount', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= \fedemotta\datatables\DataTables::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'special_ot_amount',
            'normal_ot_amount',
            'created_at',
            'updated_at',
            ['attribute'=>'created_by','value'=>function($model){
                $user=\common\models\Staff::findOne(['id'=>$model->created_by]);
                return  $user->getFullName();
            }],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
