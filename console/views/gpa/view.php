<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Gpa */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Gpas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gpa-view">

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
           ['attribute':'academic_year_id','value':'academicYear.name']
            'exam_result_id',
           ['attribute':'semester_id','value':'semester.name']
            'gpa',
            'gpa_class_id',
            'remark',
            'createdBy.fullName',
            'created_at:datetime',
            'updated_at:datetime',
        ],
    ]) ?>

</div>
