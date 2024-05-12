<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Attendance */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Attendances', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
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
);


?>
<div class="attendance-view">

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>


    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            ['attribute'=>'staff_id','value'=>function ($model) {
                $user=\common\models\Staff::findOne(['id'=>$model->staff_id]);
                return $user->fname.' '.$user->lname;
            }],
            'date',
            'signin_at',
            'singout_at',
            'hours_per_day',
            'normal_ot_hours',
            'night_hours',
            'created_at',
            'updated_at',
//            ['attribute'=>'created_by','value'=>function($model){
//                $user=\common\models\Staff::findOne(['id'=>$model->created_by]);
//                return  $user->getFullName();
//            }]
        ],
    ]) ?>

</div>
