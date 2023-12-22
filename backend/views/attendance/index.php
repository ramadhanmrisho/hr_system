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
<div class=" attendance-index">
    <p>
        <?= Html::a('Upload  Attendance', ['create'], ['class' => 'btn btn-success']) ?>
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
        'date',
        'signin_at',
        'singout_at',
        'hours_per_day',
        'created_at',
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
            'date',
            'signin_at',
            'singout_at',
            'hours_per_day',
            'created_at',
            //'updated_at',
            //'created_by',
            ['class' => 'yii\grid\ActionColumn','template'=>'{view}{update}'],
        ],
    ]); ?>


</div>

<!DOCTYPE html>
<html>
<head>
    <title>Sample Table</title>
</head>
<body>

<table border="1">
    <thead>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Age</th>
        <th>City</th>
        <th>Country</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td>1</td>
        <td>John Doe</td>
        <td>30</td>
        <td>New York</td>
        <td>USA</td>
    </tr>
    <tr>
        <td>2</td>
        <td>Jane Smith</td>
        <td>25</td>
        <td>London</td>
        <td>UK</td>
    </tr>
    <tr>
        <td>3</td>
        <td>Alice Johnson</td>
        <td>35</td>
        <td>Paris</td>
        <td>France</td>
    </tr>
    </tbody>
</table>
</body>
</html>
