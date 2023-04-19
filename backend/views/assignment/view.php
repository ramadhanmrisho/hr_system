<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Assignment */

$this->title = $model->student->lname;
$this->params['breadcrumbs'][] = ['label' => 'Results', 'url' => ['index']];
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
<div class="assignment-view">


<?php if($model->created_by==Yii::$app->user->identity->user_id || \common\models\UserAccount::userHas(['ACADEMIC'])){?>
    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this student score?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
<?php }?>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            ['attribute'=>'student_id','value'=>function($model){return $model->student->fname.' '.$model->student->lname;}],
            ['attribute'=>'module_id','value'=>function($model){ return $model->module->module_name;}],
            ['attribute'=>'course_id','value'=>function($model){ return $model->course->course_name;}],
            ['attribute'=>'nta_level','value'=>function($model){ return $model->nta_level;}],
            ['attribute'=>'academic_year_id','value'=>function($model){ return $model->academicYear->name;}],
            ['attribute'=>'semester_id','value'=>function($model){ return $model->semester->name;}],
            'score',
            'createdBy.fullName',
            'created_at:datetime',
            'updated_at:datetime',
        ],
    ]) ?>

</div>
