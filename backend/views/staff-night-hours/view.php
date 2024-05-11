<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\StaffNightHours */

$this->title = 'Night Hours';
$this->params['breadcrumbs'][] = ['label' => 'Staff Night Hours', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>

<?php //if (Yii::$app->session->hasFlash('success')):?>
<!--    --><?php //= Alert::widget([
//        'options' => [
//            'Successfully!',
//            'Details saved successfully!',
//            Alert::TYPE_SUCCESS
//        ]
//    ]) ?>
<!---->
<?php //endif;?>
<!---->
<?php //if (Yii::$app->session->hasFlash('warning')):?>
<!--    --><?php //= Alert::widget([
//        'options' => [
//            'Failed!',
//            'Entered Quantity exceed the available medicine quantity!Please contact store keeper',
//            Alert::TYPE_WARNING
//        ]
//    ]) ?>
<!---->
<?php //endif;?>
<?php
\yiister\adminlte\widgets\Box::begin(
    [
        "type" => \yiister\adminlte\widgets\Box::TYPE_PRIMARY,
    ]
)
?>
<div class="staff-night-hours-view">


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

            ['attribute'=>'staff_id','value'=>function($model){
                $user=\common\models\Staff::findOne(['id'=>$model->staff_id]);
                return  $user->fname.' '.$user->lname;
            },'label'=>'Staff Name'],
            'days',
            'description:ntext',
            'status',
            'created_at',
            'updated_at',
            ['attribute'=>'created_by','value'=>function($model){
                $user=\common\models\Staff::findOne(['id'=>$model->created_by]);
                return  $user->getFullName();
            }]
        ],
    ]) ?>

</div>
