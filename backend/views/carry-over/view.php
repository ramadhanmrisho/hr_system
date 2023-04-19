<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\CarryOver */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Carry Overs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="carry-over-view">

    <h1><?= Html::encode($this->title) ?></h1>

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
            'id',
            'student_id',
            'module_id',
//           ['attribute':'academic_year_id','value':'academicYear.name']
//           ['attribute':'year_of_study_id','value':'yearOfStudy.name']
//            'course_id',
//            'staff_id',
//           ['attribute':'semester_id','value':'semester.name']
//            'created_at:datetime',
//            'updated_at:datetime',
//            'status',
        ],
    ]) ?>

</div>
