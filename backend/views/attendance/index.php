<?php

use kartik\export\ExportMenu;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\AttendanceSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Attendances';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php
\yiister\adminlte\widgets\Box::begin(
    [
        "type" => \yiister\adminlte\widgets\Box::TYPE_PRIMARY,
    ]
)
?>
<?php
if(Yii::$app->session->hasFlash('getSuccess')):?>
    <div class="alert alert-sm alert-success zoomIn" align="center">
        <?= Yii::$app->session->getFlash('getSuccess');?>
    </div>
<?php endif;?>

<?php
if(Yii::$app->session->hasFlash('getError')):?>
    <div class="alert alert-sm alert-danger zoomIn" align="center">
        <?= Yii::$app->session->getFlash('getError');?>
    </div>
<?php endif;?>


<div class=" attendance-index">
    <p>
        <?= Html::a('Generate  Attendance', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <p align="right">
        <?= Html::a('Add Individual Attendance', ['add'], ['class' => 'btn btn-primary']) ?>
    </p>


    <?php


echo ExportMenu::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        ['attribute'=>'staff_id','value'=>function ($model) {
            $user=\common\models\Staff::findOne(['id'=>$model->staff_id]);
            return $user->fname.' '.$user->lname;
        },'filter'=>ArrayHelper::map(\common\models\Staff::find()->all(), 'id', function ($model) {
            return $model->fname . ' ' . $model->lname;

        })],
        ['attribute'=>'staff_id','value'=>function ($model) {
            $user=\common\models\Staff::findOne(['id'=>$model->staff_id]);
            return $user->employee_number;
        },'filter'=>ArrayHelper::map(\common\models\Staff::find()->all(), 'id', 'employee_number')],
        'date',
        'signin_at',
        'singout_at',
        'hours_per_day',
        'normal_ot_hours',
        'night_hours',
        //'updated_at',
        //'created_by',
        ['class' => 'yii\grid\ActionColumn','template'=>'{view}{update}'],
    ],
    'clearBuffers' => true, //optional

]);
?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            ['attribute'=>'staff_id','value'=>function ($model) {
                $user=\common\models\Staff::findOne(['id'=>$model->staff_id]);
                return $user->fname.' '.$user->lname;
            },'filter'=>ArrayHelper::map(\common\models\Staff::find()->all(), 'id', function ($model) {
                return $model->fname . ' ' . $model->lname;
            })],
            ['attribute'=>'staff_id','value'=>function ($model) {
                $user=\common\models\Staff::findOne(['id'=>$model->staff_id]);
                return $user->employee_number;
            },'label'=>'Staff Number','filter'=>ArrayHelper::map(\common\models\Staff::find()->all(), 'id', 'employee_number')],
            'date',
            'signin_at',
            'singout_at',
            'hours_per_day',
            'normal_ot_hours',
            'night_hours',
            'created_at',
            //'updated_at',
            //'created_by',
            ['class' => 'yii\grid\ActionColumn','template'=>'{view}{update}'],
        ],
    ]); ?>


</div>


