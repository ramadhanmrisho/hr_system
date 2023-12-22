<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\RosterSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Roster';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php
\yiister\adminlte\widgets\Box::begin(
    [
        "type" => \yiister\adminlte\widgets\Box::TYPE_PRIMARY,
    ]
)
?>
<div class="roster-index">

    <p align="right">
        <?= Html::a('Create New Roster', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= \fedemotta\datatables\DataTables::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'working_days',
            'working_hours',
            ['attribute'=>'status','value'=>function($model){
                return $model->status==1 ?"Active":"Inactive";
            }],
            'created_at',
            'updated_at',
            ['attribute'=>'created_by','value'=>function($model){
                $user=\common\models\Staff::findOne(['id'=>$model->created_by]);
                return  $user->getFullName();
            }],
            ['class' => 'yii\grid\ActionColumn','template'=>'{view}{update}'],
        ],
    ]); ?>


</div>
