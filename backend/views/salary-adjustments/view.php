<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\SalaryAdjustments */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Salary Adjustments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
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
<div class="salary-adjustments-view">

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
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
            }],]
    ]) ?>

</div>
