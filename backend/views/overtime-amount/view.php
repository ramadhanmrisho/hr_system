<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\OvertimeAmount */

$this->title ="OT Amounts Details";
$this->params['breadcrumbs'][] = ['label' => 'Overtime Amounts', 'url' => ['index']];
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
)
?>
<div class="overtime-amount-view">
    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>

    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [

            'special_ot_amount',
            'normal_ot_amount',
            'created_at',
            'updated_at',
              ['attribute'=>'created_by','value'=>function($model){
                $user=\common\models\Staff::findOne(['id'=>$model->created_by]);
                return  $user->getFullName();
            }],
            ['attribute'=>'status','value'=>function($model){
                return $model->status==1 ?"Active":"Inactive";
            }],
        ],
    ]) ?>

</div>
