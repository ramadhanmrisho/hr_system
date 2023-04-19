<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\TimeTableSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Time Tables';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php
if(Yii::$app->session->hasFlash('getSuccess')):?>
    <div class="alert alert-sm alert-success zoomIn" align="center">
        <?= Yii::$app->session->getFlash('getSuccess');?>
    </div>
<?php endif;?>
<?php
if(Yii::$app->session->hasFlash('getDanger')):?>
    <div class="alert alert-sm alert-danger zoomIn" align="center">
        <?= Yii::$app->session->getFlash('getDanger');?>
    </div>
<?php endif;?>
<?php
\yiister\adminlte\widgets\Box::begin(
    [
        "type" => \yiister\adminlte\widgets\Box::TYPE_PRIMARY,
    ]
)
?>

<div class="time-table-index">
    <p>
        <?= Html::a('<span class="fa fa-upload"> Upload Time Table</span>', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= \fedemotta\datatables\DataTables::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],


            ['attribute'=>'course_id','value'=>function($model){
                return $model->course->course_name;
            },'label'=>'Course Name'],
            ['attribute' =>'time_table','format'=>'raw', 'value' => function ($model) {return Html::a('<span class="glyphicon glyphicon-paperclip"></span>Click to View',Yii::$app->urlManager->baseUrl.'/kcohas/backend/web/time_tables/'.$model->time_table,['target'=>'blank']);}],
            
            ['attribute'=>'created_by','value'=>function($model){

                $id=\common\models\UserAccount::find()->where(['id'=>$model->created_by])->one()->user_id;
                $staff=\common\models\Staff::find()->where(['id'=>$id])->one();
                return  $staff->fname.' '.$staff->lname;
            }],

            'updated_at',

            ['class' => 'yii\grid\ActionColumn','template'=>'{update}'],
        ],
    ]); ?>


</div>
